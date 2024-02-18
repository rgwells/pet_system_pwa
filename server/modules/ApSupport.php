<?php


namespace {
    include_once __DIR__ . "/../inc/config.php";
}


namespace modules {

    use DateTimeImmutable;
    use PDO;
    use PDOException;

    class ApSupport
    {
        public static function debitSoulCoin (string $avId, int $amount) : string
        {
            // check SC debit
            /*
                string body =
                llList2Json(JSON_OBJECT,
                    [
                        "type", "multi-add",
                        "amount", (string)amount,
                        "uuids", parse_list(reward_type),
                        "today", llGetDate ()
                    ]
                );
                string URL = "https://www.pandemoniumsl.com/slutility/new/soulcoin.php";
                list httpType = [HTTP_METHOD, "POST", HTTP_BODY_MAXLENGTH, 16384];
                requestKey = llHTTPRequest(URL, httpType, body);

                string NOT_ENOUGH_COINS = "0";
                string DEBIT_SUCCESS = "1";
                string USER_NOT_FOUND = "2";
                string USER_SPECIFIC_ERROR = "3";
                string CREDIT_SUCCESS = "4";
            */
            /*
            $date = new DateTimeImmutable();
            $data = array(
                'type' => 'multi-add',
                'amount' => $amount,
                'uuids' => $avId,
                'today' => $date->format('Y-m-d'),
            );

            $json = json_encode($data);
            $url = 'https://www.pandemoniumsl.com/slutility/new/soulcoin.php';
            $ch = curl_init($url);
            if ($ch !== false) {
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($json)));

                $resp = curl_exec($ch);
            }
            if (curl_errno($ch)) {
                error_log("response: " . $resp);
                error_log('Error: ' . curl_error($ch));
            }
            else {
                error_log("response: " . $resp);
            }

            curl_close($ch);
            */

            $result = "0";

            try {
                error_log ( 'av: ' . $avId . ', amt: ' . $amount);

                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = 'SELECT avuuid, soulpoint FROM dcurrency WHERE avuuid = :avuuid';

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':avuuid', $avId, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $num = $row["soulpoint"];

                    if ($num - $amount > 0)
                    {
                        $sql = 'update dcurrency set soulpoint = soulpoint - :amt where avuuid = :avuuid';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':avuuid', $avId, PDO::PARAM_STR);
                        $stmt->bindParam(':amt', $amount, PDO::PARAM_INT);
                        $stmt->execute();
                        if ($stmt->rowCount() > 0) {
                            $result = "1";
                        }
                    }
                }
            }
            catch (PDOException $e) {
                $result = $e->getCode();
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
            }

            return ($result);
        }
    }
}
?>