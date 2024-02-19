<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
}
namespace server\modules {

    use PDO;
    use PDOException;

    class Quest
    {
        public static function getRandomQuest (string $category) : Quest
        {
            $obj = null;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = '';
                if ($category) {
                    $sql = 'select * from ps_quest_def where enabled = true and type = :category order by id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':category', $category, PDO::PARAM_INT);
                }
                else {
                    $sql = "select * from ps_quest_def where enabled = true 
                           and (type = 'Monster' or type = 'Event' or type = 'Puzzle' or type = 'Encounter')
                           order by id";
                    $stmt = $pdo->prepare($sql);
                }

                $stmt->execute();
                $temp = random_int(0, $stmt->rowCount() - 1);
                $i = 0;
                while ($row = $stmt->fetch()) {
                    if ($i == $temp) {
                        $obj = Quest::loadFromRow($row);
                        return ($obj);
                    }
                    $i++;
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($obj);
        }

        public static function getCount () : int
        {
            $count = 0;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = 'select count(*) as count from ps_quest_def where active = :active';
                $stmt = $pdo->prepare($sql);
                $active = true;
                $stmt->bindParam(':active', $active, PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $count = $row['count'];
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($count);
        }

        public static function getQuestDef ($id) : Quest
        {
            $obj = new Quest ();

            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = 'select * from ps_quest_def where id = :id';

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $obj = Quest::loadFromRow ($row);
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }


        private static function loadFromRow (array $row) : Quest
        {
            $obj = new Quest ();
            $obj->id = $row["id"];
            $obj->enabled = $row["enabled"];
            $obj->type = $row["type"];
            $obj->nextAction = $row["next_action"];
            $obj->texture = $row["texture"];
            $obj->message = $row["text"];

            return ($obj);
        }

        public int $id;
        public bool $enabled;
        public string $type;
        public string $nextAction;
        public string $texture;
        public string $message;
    }

}

?>