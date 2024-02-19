<?php
namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace server\modules {


    use Exception;

    class LocationRequest
    {
        public static function makeRequest (string $url, string $av) : string
        {
            $resp = "";

            $curl = \curl_init();
            $headers = array(
                "Accept: application/json",
                "Content-Type: application/json");

            \curl_setopt($curl, CURLOPT_URL, $url);
            \curl_setopt($curl, CURLOPT_POST, true);
            \curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            \curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            \curl_setopt($curl, CURLOPT_POSTFIELDS, "SAVE_LOCATION|" . $av);
            $resp = \curl_exec($curl);
            \curl_close($curl);

            error_log("location response: " . $resp);

            return ($resp);
        }
    }
}
?>