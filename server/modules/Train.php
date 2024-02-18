<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
}


namespace modules {

    use PDO;
    use PDOException;

    class Train
    {
        public static function getTrainList () : array
        {
            $result = [];
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = 'select * from ps_train_info order by id asc';
                $stmt = $pdo->prepare($sql);

                $stmt->execute();
                $stmt->rowCount();
                while ($row = $stmt->fetch()) {
                    $train = Train::loadFromRow($row);
                    array_push($result, $train);
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }

        private static function loadFromRow (array $row) : Train
        {
            $obj = new Train ();
            $obj->type = $row["type"];
            $obj->cost = $row["cost"];
            $obj->texture = $row["texture"];
            $obj->constitution = $row["constitution"];
            $obj->strength = $row["strength"];
            $obj->agility = $row["agility"];
            $obj->charm = $row["charm"];
            $obj->confidence = $row["confidence"];
            $obj->empathy = $row["empathy"];
            $obj->intelligence = $row["intelligence"];
            $obj->wisdom = $row["wisdom"];
            $obj->sorcery = $row["sorcery"];
            $obj->loyalty = $row["loyalty"];
            $obj->spirituality = $row["spirituality"];
            $obj->karma = $row["karma"];
            $obj->fatigue = $row["fatigue"];
            return ($obj);
        }
        public string $type;
        public int $cost = 0;
        public string $texture;
        public int $constitution = 0;
        public int $strength = 0;
        public int $agility = 0;
        public int $charm = 0;
        public int $confidence = 0;
        public int $empathy = 0;
        public int $intelligence = 0;
        public int $wisdom = 0;
        public int $sorcery = 0;
        public int $loyalty = 0;
        public int $spirituality = 0;
        public int $karma = 0;
        public int $fatigue = 0;

    }
}
?>