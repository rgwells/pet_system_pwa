<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace server\modules {

    use PDO;
    use PDOException;

    class Patreon
    {
        public static function getPatreon (string $avId) : Patreon
        {
            $result = new Patreon ();
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = 'select * from dpatreon where avuuid = :avId';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':avId', $avId, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $row = $stmt->fetch();
                    if ($row) {
                        $result = Patreon::loadFromRow($row);
                    }
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }

        public static function getMaxApointsForAv (string $avId) : int
        {
            $aPoints = 5;
            $pat = Patreon::getPatreon ($avId);
            if ($pat->avId != "")
            {
                if (($pat->tier >= 8) && ($pat->tier <= 19)) {
                    $aPoints = 7;
                }
                else if (($pat->tier >= 20) && ($pat->tier <= 49)) {
                    $aPoints = 9;
                }
                else if (($pat->tier >= 50) && ($pat->tier <= 99)) {
                    $aPoints = 11;
                }
                else if ($pat->tier >= 100) {
                    $aPoints = 13;
                }
            }

            return ($aPoints);
        }


        public static function toString (Patreon $obj, string $delimiter) : string
        {
            $result = $obj->avId . $delimiter .
                $obj->avName . $delimiter .
                $obj->tier . $delimiter .
                $obj->note . $delimiter;
            return ($result);
        }

        private static function loadFromRow (array $row) : Patreon
        {
            $obj = new Patreon ();
            $obj->avId = $row["avuuid"];
            $obj->avName = $row["avname"];
            $obj->tier = $row["tier"];
            $obj->note = $row["note"];
            return ($obj);
        }

        public string $avId = "";
        public string $avName = "";
        public int $tier = 0;
        public string $note = "";
    }
}

?>