<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace server\modules {

    use PDO;
    use PDOException;

    class Grade
    {
        public static function getGrade(string $name) : Grade
        {
            $obj = new Grade ();

            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = 'select * from ps_grade where rarity = :name';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $obj = Grade::loadFromRow ($row);
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }



        private static function loadFromRow (array $row) : Grade
        {
            $obj = new Grade ();
            $obj->rarity = $row["rarity"];
            $obj->code = $row["code"];
            $obj->minValue = $row["min_value"];
            $obj->maxValue = $row["max_value"];

            return ($obj);
        }

        public string $rarity;
        public string $code;
        public string $minValue;
        public string $maxValue;
    }
}
?>