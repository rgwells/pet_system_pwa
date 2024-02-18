<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace modules {

    use PDO;
    use PDOException;

    class Food
    {
        public static function getFoodList () : array
        {
            $result = [];
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = 'select * from ps_food_info order by cost asc';
                $stmt = $pdo->prepare($sql);

                $stmt->execute();
                $stmt->rowCount();
                while ($row = $stmt->fetch()) {
                    $food = Food::loadFromRow($row);
                    array_push($result, $food);
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }

        private static function loadFromRow (array $row) : Food
        {
            $obj = new Food ();
            $obj->type = $row["type"];
            $obj->cost = $row["cost"];
            $obj->actionPoints = $row["action_points"];
            $obj->texture = $row["texture"];
            $obj->reqFitness = $row["req_fitness"];
            $obj->reqCharisma = $row["req_charisma"];
            $obj->reqWizardry = $row["req_wizardry"];
            $obj->reqNature = $row["req_nature"];
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

        public string $type = "";
        public int $cost = 0;
        public int $actionPoints = 0;
        public string $texture  = "";
        public int $reqFitness = 0;
        public int $reqWizardry = 0;
        public int $reqCharisma = 0;
        public int $reqNature = 0;
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