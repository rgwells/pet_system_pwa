<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace server\modules {

    use PDO;
    use PDOException;

    class Settings
    {
        public static function getSetting (string $key) : Settings
        {
            // all return data will be pushed into this array
            $obj = new Settings ();

            try {
                $pdo = new PDO(\DB_DSN, \DB_USERNAME, \DB_PASSWORD, \DB_OPTIONS);

                $sql = 'select * from ps_settings where keyName = :key';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':key', $key, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $obj = Settings::loadFromRow ($row);
                }
            } catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }



        public static function getSettings () : array
        {
            $result = [];
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = 'select * from ps_settings order by keyName';
                $stmt = $pdo->prepare($sql);
                if ($stmt->execute()) {
                    while ($row = $stmt->fetch()) {
                        $obj = Settings::loadFromRow($row);
                        array_push($result, $obj);
                    }
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
            }
            return ($result);
        }



        private static function loadFromRow (array $row) : Settings
        {
            $obj = new Settings();
            $obj->key = $row["keyName"];
            $obj->value = $row["keyValue"];
            return ($obj);
        }

        public static function toString (Settings $obj, string $delimiter) : string
        {
            $result =
                $obj->key . $delimiter .
                $obj->value;

            return ($result);
        }


        public string $key = "";
        public string | null $value = "";
    }
}

?>