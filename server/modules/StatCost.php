<?php


namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace server\modules {

    use PDO;
    use PDOException;

    class StatCost
    {
        public static function getStatCost (int $questId, string $name) : StatCost
        {
            $obj = new StatCost ();

            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = 'select * from ps_stat_cost where quest_id = :questId and action = :name';

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':questId', $questId, PDO::PARAM_INT);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $obj = StatCost::loadFromRow ($row);
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }



        private static function loadFromRow (array $row) : StatCost
        {
            $obj = new StatCost ();
            $obj->id = $row["id"];
            $obj->questId = $row["quest_id"];
            $obj->action = $row["action"];

            // Fitness category
            $obj->constitution = $row["constitution"];
            $obj->strength = $row["strength"];
            $obj->agility = $row["agility"];
            // wizardry category
            $obj->intelligence = $row["intelligence"];
            $obj->wisdom = $row["wisdom"];
            $obj->sorcery = $row["sorcery"];
            // charisma category
            $obj->charm = $row["charm"];
            $obj->confidence = $row["confidence"];
            $obj->empathy = $row["empathy"];
            // nature category
            $obj->loyalty = $row["loyalty"];
            $obj->spirituality = $row["spirituality"];
            $obj->karma = $row["karma"];

            $obj->food = $row["food"];
            $obj->fatigue = $row["fatigue"];


            return ($obj);
        }


        public int $id;
        public int $questId;
        public string $action;

        // fitness category
        public int $constitution;
        public int $strength;
        public int $agility;

        // wizardry category
        public int $intelligence;
        public int $wisdom;
        public int $sorcery;

        // charisma category
        public int $charm;
        public int $confidence;
        public int $empathy;

        // nature category
        public int $loyalty;  // loyalty
        public int $spirituality; // oooh powers
        public int $karma; // karma

        public int $food;
        public int $fatigue;

    }
}
?>