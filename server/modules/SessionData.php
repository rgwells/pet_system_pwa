<?php
namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace server\modules {

    class SessionData
    {
        public static function getSessionData () : array
        {
            $avId = "";
            $avName = "";
            session_start();

            if ((array_key_exists('avId', $_SESSION)) &&
                (array_key_exists('avName', $_SESSION))) {
                $avId = $_SESSION['avId'];
                $avName = $_SESSION['avName'];
            } else {
                showError(
                    "Session Expired",
                    "You have been logged out!",
                    "The page may have expired or is loading, Please wait.<br/>If the page does not load in a few seconds, obtain a new link in-world.");
            }
            return (array ($avId, $avName));
        }

        /**
         * @return array status, avId and av name
         */
        public static function getValidSessionData () : array {
            $error = "";
            $avId = "";
            $avName = "";
            $primUrl = "";
            $altLogin = "";
            $result = 0;
            $ok = 1;
            $diff = INWORLD_MESSAGE_MAXAGE + 1;

            // initialize the variables to empty.
            $messageHash = "";
            $messageTime = "";
            $messageAvId = "";
            $messageName = "";
            $messageUrl = "";

            $queries = array();
            parse_str($_SERVER['QUERY_STRING'], $queries);
            if (isset ($queries['token'])) {
                $tokenData = $queries['token'];
                $decodeQuery = base64_decode($tokenData);
                $qsTokens = explode("|", $decodeQuery, 5);

                // only read in the variables if there are enough
                if (count($qsTokens) >= 5) {
                    $messageHash = $qsTokens[0];
                    $messageTime = $qsTokens[1];
                    $messageAvId = $qsTokens[2];
                    $messageName = $qsTokens[3];
                    $messageUrl = $qsTokens[4];
                }
                else
                {
                    $error = $error . "incorrect number of arguments - " . count($qsTokens) . "<br/>";
                }

                // create the work string for computing the hash
                // note that the order of these variables it Important!
                $workString =
                    INWORLD_SHARED_SECRET .
                    $messageTime . '|' .
                    $messageAvId . "|" .
                    $messageName . "|" .
                    $messageUrl;

                $hash = sha1($workString);
                $ct = time();

                // compare the hash and compute the time differences between the hashed
                // value and the current time
                $ok = strcmp($hash, $messageHash);
                if (! $ok)
                {
                    $error = $error . "hash value is not correct<br/>";
                }

                $diff = ($ct - (int)$messageTime);

                if ($diff <= INWORLD_MESSAGE_MAXAGE)
                {
                    $error = $error . "login time expired<br/>";
                }
            }

            if (isset ($queries['altLogin'])) {
                $altLogin = "1";
            }

            if (!$ok &&
                ($diff <= INWORLD_MESSAGE_MAXAGE)) {
                // Success save off the uuid for later use in the session
                $result = 1;
                $avId = $messageAvId;
                $avName = $messageName;
                $primUrl = $messageUrl;
            } else {
                // remove the session
                session_start();
                session_destroy();
            }

            return array($result, $avId, $avName, $primUrl, $error, $altLogin);
        }
    }

}
?>