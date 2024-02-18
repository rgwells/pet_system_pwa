<?php


namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace modules {

    use PDO;
    use PDOException;

    class QuestChoice
    {
        public static function getQuestChoice (int $questId, string $name) : QuestChoice
        {
            $obj = new QuestChoice ();

            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = 'select * from ps_quest_choice where quest_id = :questId and action = :name';

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':questId', $questId, PDO::PARAM_INT);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $obj = QuestChoice::loadFromRow ($row);
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }



        private static function loadFromRow (array $row) : QuestChoice
        {
            $obj = new QuestChoice ();
            $obj->id = $row["id"];
            $obj->questId = $row["quest_id"];
            $obj->type = $row["type"];
            $obj->action = $row["action"];
            $obj->texture = $row["texture"];
            $obj->emoticon = $row["emote_img"] ? $row["emote_img"] : '';
            $obj->faceImg = $row["face_img"] ? $row["face_img"] : '';
            $obj->message = $row["text"];
            $obj->actionCost = $row["action_cost"] ? $row["action_cost"] : '';
            $obj->actionTest = $row["action_test"] ? $row["action_test"] : '';
            $obj->actionCmd = $row["action_cmd"] ? $row["action_cmd"] : '';
            $obj->choiceCount =  $row["choice_count"];
            $obj->questDone = $row["quest_done"];

            $obj->choices[0] = $row["choice_1"];
            $obj->choices[1] = $row["choice_2"];
            $obj->choices[2] = $row["choice_3"];
            $obj->choices[3] = $row["choice_4"];
            $obj->choices[4] = $row["choice_5"];

            $obj->actions[0] = $row["action_1"];
            $obj->actions[1] = $row["action_2"];
            $obj->actions[2] = $row["action_3"];
            $obj->actions[3] = $row["action_4"];
            $obj->actions[4] = $row["action_5"];

            return ($obj);
        }


        public int $id = 0;
        public int $questId;
        public string $action;
        public string $type;
        public string $message;
        public string $texture;
        public string $faceImg;
        public string $emoticon;
        public int $choiceCount = 0;
        public array $choices = array (1, 2, 3, 4, 5);
        public array $actions = array (1, 2, 3, 4, 5);
        public string $actionCost = "";
        public string $actionTest = "";
        public string $actionCmd = "";
        public bool $questDone;
    }
}
?>