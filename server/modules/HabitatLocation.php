<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace server\modules {

    use PDO;
    use PDOException;

    class HabitatLocation
    {
        public static function getHabitatLocation (int $id) : HabitatLocation
        {
            $result = null;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = 'select * from ps_habitat_location where id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $row = $stmt->fetch();
                    if ($row) {
                        $result = HabitatLocation::loadFromRow($row);
                    }
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }


        public static function getFirstHabitatLocationByRegNum (string $regNum) : HabitatLocation | null
        {
            $result = null;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = 'select * from ps_habitat_location where registration_id = :regNum';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':regNum', $regNum, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $row = $stmt->fetch();
                    if ($row) {
                        $result = HabitatLocation::loadFromRow($row);
                    }
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }


        public static function deleteHabitatLocation (int $id) : int
        {
            $result = 0;
            $pdo = null;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $pdo->beginTransaction();

                $sql = 'delete from ps_habitat_location where id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $count = $stmt->rowCount();
                    if ($pdo->commit()) {
                        $result = $count;
                    }
                }
            } catch (PDOException $e) {
                $pdo?->rollBack();
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }


        public static function putHabitatLocation (HabitatLocation $obj) : HabitatLocation
        {
            $result = new HabitatLocation ();

            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $pdo->beginTransaction();

                $sql = 'select * from ps_habitat_location where type = :type and habitat = :habitat and region_name = :region and parcel_id = :parcel';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':type', $obj->type,  PDO::PARAM_STR);
                $stmt->bindParam(':habitat', $obj->habitatName,  PDO::PARAM_STR);
                $stmt->bindParam(':region', $obj->regionName,  PDO::PARAM_STR);
                $stmt->bindParam(':parcel', $obj->parcelId, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $count = $stmt->rowCount();
                    if (!$count) {

                        $sql = 'insert into ps_habitat_location 
                                (registration_id, name, type, habitat, region_name, region_coord, area, parcel_id, texture_id, sl_value, dispenser_version) 
                                values 
                                (:regId, :name, :type, :habitat, :region, :coord, :area, :parcel, :texture, :slValue, :dispVersion)';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':regId', $obj->registrationId, PDO::PARAM_STR);
                        $stmt->bindParam(':name', $obj->name, PDO::PARAM_STR);
                        $stmt->bindParam(':type', $obj->type, PDO::PARAM_STR);
                        $stmt->bindParam(':habitat', $obj->habitatName, PDO::PARAM_STR);
                        $stmt->bindParam(':region', $obj->regionName, PDO::PARAM_STR);
                        $stmt->bindParam(':coord', $obj->regionCoord, PDO::PARAM_STR);
                        $stmt->bindParam(':area', $obj->regionArea, PDO::PARAM_STR);
                        $stmt->bindParam(':parcel', $obj->parcelId, PDO::PARAM_STR);
                        $stmt->bindParam(':texture', $obj->textureId, PDO::PARAM_STR);
                        $stmt->bindParam(':slValue', $obj->slValue, PDO::PARAM_INT);
                        $stmt->bindParam(':dispVersion', $obj->dispenserVersion, PDO::PARAM_STR);
                        if ($stmt->execute()) {
                            $stmt->rowCount();
                            $id = $pdo->lastInsertId();
                            if ($pdo->commit()) {
                                $result = HabitatLocation::getHabitatLocation($id);
                            }
                        }
                    }
                    else
                    {
                        $row = $stmt->fetch();
                        if ($row) {
                            $result = HabitatLocation::loadFromRow($row);
                        }
                    }
                }
            } catch (PDOException $e) {
                $pdo?->rollBack();
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                //throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }

        public static function saveHabitatLocation (HabitatLocation $obj) : HabitatLocation
        {
            $result = $obj;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $pdo->beginTransaction();

                $sql = 'update ps_habitat_location set 
                        registration_id = :regId, name = :name, type = :type, habitat = :habitat, region_name = :region, 
                        region_coord = :coord, area = :area, parcel_id = :parcel, texture_id = :texture, sl_value = :slValue, dispenser_version = :dispVersion
                        where id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':regId', $obj->registrationId, PDO::PARAM_STR);
                $stmt->bindParam(':name', $obj->name, PDO::PARAM_STR);
                $stmt->bindParam(':type', $obj->type,  PDO::PARAM_STR);
                $stmt->bindParam(':habitat', $obj->habitatName,  PDO::PARAM_STR);
                $stmt->bindParam(':region', $obj->regionName,  PDO::PARAM_STR);
                $stmt->bindParam(':coord', $obj->regionCoord, PDO::PARAM_STR);
                $stmt->bindParam(':area', $obj->regionArea, PDO::PARAM_STR);
                $stmt->bindParam(':parcel', $obj->parcelId, PDO::PARAM_STR);
                $stmt->bindParam(':texture', $obj->textureId, PDO::PARAM_STR);
                $stmt->bindParam(':slValue', $obj->slValue, PDO::PARAM_INT);
                $stmt->bindParam(':dispVersion', $obj->dispenserVersion, PDO::PARAM_STR);

                $stmt->bindParam(':id', $obj->id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    if ($pdo->commit()) {
                        $result = HabitatLocation::getHabitatLocation($obj->id);
                    }
                }
            } catch (PDOException $e) {
                $pdo?->rollBack();
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }


        public static function getHabitatsForRegion (string $regionName, int $randomize = 0) : array
        {
            $result = [];
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = "";

                if ($randomize) {
                    $sql = 'select * from ps_habitat_location where region_name = :region  order by rand()';
                }
                else {
                    $sql = 'select * from ps_habitat_location where region_name = :region';
                }
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':region', $regionName, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    while ($row = $stmt->fetch()) {
                        $obj = HabitatLocation::loadFromRow($row);
                        array_push($result, $obj);
                    }
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }


        public static function getRandomHabitat (string $habitatType, int $maxCount) : array
        {
            $result = [];
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = "";

                if ($habitatType == "")
                {
                    $sql = 'select * from ps_habitat_location order by rand() limit :count';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':count', $maxCount, PDO::PARAM_INT);
                }
                else {
                    $sql = 'select * from ps_habitat_location where habitat = :habitat order by rand() limit :count';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':habitat', $habitatType, PDO::PARAM_STR);
                    $stmt->bindParam(':count', $maxCount, PDO::PARAM_INT);
                }
                if ($stmt->execute()) {
                    while ($row = $stmt->fetch()) {
                        $obj = HabitatLocation::loadFromRow($row);
                        array_push($result, $obj);
                    }
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }


        public static function removeHabitatLocation (string $regId) : bool
        {
            $result = false;

            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $pdo->beginTransaction();

                $sql = 'select id from ps_habitat_location where registration_id = :regId';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':regId', $regId, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    while ($row = $stmt->fetch()) {
                        $obj = $row['id'];

                        $sql = 'delete from ps_habitat_location where id = :id';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':id', $obj, PDO::PARAM_INT);
                        if ($stmt->execute()) {
                            $count = $stmt->rowCount();
                            if ($count == 0) {
                                eLog("Error deleting id = " . $obj);
                            }
                            else {
                                $result = true;
                            }
                        }
                    }

                    $pdo->commit ();
                }
            } catch (PDOException $e) {
                eLog($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($result);
        }

        public static function toString (HabitatLocation $obj, string $delimiter) : string
        {
            $result =
                $obj->id . $delimiter .
                $obj->registrationId . $delimiter .
                $obj->name . $delimiter .
                $obj->type . $delimiter .
                $obj->habitatName . $delimiter .
                $obj->regionName . $delimiter .
                $obj->regionCoord . $delimiter .
                $obj->regionArea . $delimiter .
                $obj->parcelId . $delimiter .
                $obj->textureId  . $delimiter .
                $obj->slValue  . $delimiter .
                $obj->dispenserVersion;

            return ($result);
        }


        private static function loadFromRow (array $row) : HabitatLocation
        {
            $obj = new HabitatLocation ();

            $obj->id = $row["id"];
            $obj->registrationId = $row["registration_id"];
            $obj->name = $row["name"];
            $obj->type = $row["type"];
            $obj->habitatName = $row["habitat"];
            $obj->regionName = $row["region_name"];
            $obj->regionCoord = $row["region_coord"];
            $obj->regionArea = $row["area"];
            $obj->parcelId = $row["parcel_id"];
            $obj->textureId = $row["texture_id"];
            $obj->slValue = $row["sl_value"] ? $row["sl_value"] : 0;
            $obj->dispenserVersion = $row["dispenser_version"] ? $row["dispenser_version"] : "";

            return ($obj);
        }

        public int $id = 0;
        public string $registrationId;
        public string $name;
        public string $type;
        public string $habitatName;
        public string $regionName;
        public string $regionCoord;
        public string $regionArea;
        public string $parcelId;
        public string $textureId;
        public int $slValue = 0;
        public string $dispenserVersion;
    }
}
?>