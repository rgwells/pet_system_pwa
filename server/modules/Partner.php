<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace server\modules {

    use PDO;
    use PDOException;

    class Partner
    {

        public static function getPartner (int $id) : Partner
        {
            $result = null;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = 'select * from ps_partner where id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $row = $stmt->fetch();
                    if ($row) {
                        $result = Partner::loadFromRow($row);
                    }
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }

        public static function getRandomList (int $count) : array
        {
            $result = [];
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = 'select * from ps_partner order by rand() limit :count';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":count", $count, PDO::PARAM_STR);
                $stmt->execute();
                $stmt->rowCount();
                while ($row = $stmt->fetch()) {
                    $partner = Partner::loadFromRow($row);
                    array_push($result, $partner);
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }


        public static function toString (Partner $obj, string $delimiter) : string
        {
            $result = $obj->id . $delimiter .
                $obj->regNum . $delimiter .
                $obj->name . $delimiter .
                $obj->region . $delimiter .
                $obj->regionCoord . $delimiter .
                $obj->parcelId . $delimiter .
                $obj->textureId . $delimiter;

            return ($result);
        }


        private static function loadFromRow (array $row) : Partner
        {
            $obj = new Partner ();
            $obj->id = $row["id"];
            $obj->regNum = $row["registration_id"];
            $obj->name = $row["name"];
            $obj->region = $row["region_name"];
            $obj->regionCoord = $row["landing_coord"];
            $obj->parcelId = $row["parcel_id"];
            $obj->textureId = $row["texture_id"] ? $row["texture_id"] : "";
            return ($obj);
        }

        public int $id = 0;
        public string $regNum = "";
        public string $name = "";
        public string $region = "";
        public string $regionCoord = "";
        public string $parcelId = "";
        public string $textureId = "";
    }
}
?>