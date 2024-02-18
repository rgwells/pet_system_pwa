<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace modules {

    use PDO;
    use PDOException;

    class Habitat
    {
        public static function getHabitat (int $id) : Habitat
        {
            $result = null;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = 'select * from ps_habitat where id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $row = $stmt->fetch();
                    if ($row) {
                        $result = Habitat::loadFromRow($row);
                    }
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }

        public static function getHabitatByName (string $name) : Habitat
        {
            $result = null;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = 'select * from ps_habitat where habitat = :name';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $row = $stmt->fetch();
                    if ($row) {
                        $result = Habitat::loadFromRow($row);
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
                    $sql = 'select * from ps_habitat order by rand() limit :count';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':count', $maxCount, PDO::PARAM_INT);
                }
                else {
                    $sql = 'select * from ps_habitat where habitat = :habitat order by rand() limit :count';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':habitat', $habitatType, PDO::PARAM_STR);
                    $stmt->bindParam(':count', $maxCount, PDO::PARAM_INT);
                }
                if ($stmt->execute()) {
                    while ($row = $stmt->fetch()) {
                        $obj = Habitat::loadFromRow($row);
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


        public static function toString (Habitat $obj, string $delimiter) : string
        {
            $result =
                $obj->id . $delimiter .
                $obj->name . $delimiter .
                $obj->texture;

            return ($result);
        }


        private static function loadFromRow (array $row) : Habitat
        {
            $obj = new Habitat ();
            $obj->id = $row["id"];
            $obj->name = $row["habitat"];
            $obj->texture = $row["texture"];
            return ($obj);
        }

        public int $id = 0;
        public string $name;
        public string $texture;

    }
}
?>