<?php

require_once '../inc/config.php';
include_once __DIR__ . "/../modules/Quest.php";
include_once __DIR__ . "/../modules/QuestChoice.php";
include_once __DIR__ . "/../modules/StatTest.php";
include_once __DIR__ . "/../modules/StatCost.php";

use server\modules\Quest;
use server\modules\QuestChoice;
use server\modules\StatCost;
use server\modules\StatTest;


if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $type = !empty($_GET["type"]) ? $_GET["type"] : 'none';

    if ($type == "get_random_quest") {
        //$quest = Quest::getRandomQuest("");
        $quest = Quest::getQuestDef(9);

        $questChoice = QuestChoice::getQuestChoice($quest->id, $quest->nextAction);
        $result = [$quest, $questChoice];
        die (json_encode($result, JSON_PRETTY_PRINT));
    }
    else if ($type === "get_quest")
    {
        $questId = !empty($_GET["quest_id"]) ? $_GET["quest_id"] : -1;
        $quest = Quest::getQuestDef($questId);
        $questChoice = QuestChoice::getQuestChoice($quest->id, $quest->nextAction);
        $result = [$quest, $questChoice];
        die (json_encode($result, JSON_PRETTY_PRINT));
    }
    else if ($type === "get_quest_choice")
    {
        $questId = !empty($_GET["quest_id"]) ? $_GET["quest_id"] : -1;
        $actionName = !empty($_GET["action_name"]) ? $_GET["action_name"] : -1;
        $obj = QuestChoice::getQuestChoice($questId, $actionName);
        $test = StatTest::getStatTest($questId, $obj->actionTest);
        $cost = StatCost::getStatCost($questId, $obj->actionCost);

        $result = [$obj, $test, $cost];
        die (json_encode($result, JSON_PRETTY_PRINT));
    }
    else if ($type === "get_quest_test")
    {
        $questId = !empty($_GET["quest_id"]) ? $_GET["quest_id"] : -1;
        $actionName = !empty($_GET["action_name"]) ? $_GET["action_name"] : -1;
        $obj = StatTest::getStatTest($questId, $actionName);
        $win = QuestChoice::getQuestChoice($questId, $obj->winAction);
        $lose = QuestChoice::getQuestChoice($questId, $obj->loseAction);

        $result = [$obj, $win, $lose ];
        die (json_encode($result, JSON_PRETTY_PRINT));
    }
    else if ($type === "get_quest_cost")
    {
        $questId = !empty($_GET["quest_id"]) ? $_GET["quest_id"] : -1;
        $actionName = !empty($_GET["action_name"]) ? $_GET["action_name"] : -1;
        $obj = StatCost::getStatCost($questId, $actionName);
        $result = json_encode($obj, JSON_PRETTY_PRINT);
        die ($result);
    }
    else if ($type == "get_forage_quest") {
        $quest = Quest::getRandomQuest('Forage');

        $questChoice = QuestChoice::getQuestChoice($quest->id, $quest->nextAction);
        $result = [$quest, $questChoice];
        die (json_encode($result, JSON_PRETTY_PRINT));
    }
    else if ($type == "get_train_quest") {
        $quest = Quest::getRandomQuest('Train');

        $questChoice = QuestChoice::getQuestChoice($quest->id, $quest->nextAction);
        $result = [$quest, $questChoice];
        die (json_encode($result, JSON_PRETTY_PRINT));
    }
    else if ($type == "get_rest_quest") {
        $quest = Quest::getRandomQuest('Rest');
        $questChoice = QuestChoice::getQuestChoice($quest->id, $quest->nextAction);
        $result = [$quest, $questChoice];
        die (json_encode($result, JSON_PRETTY_PRINT));
    }
}

?>