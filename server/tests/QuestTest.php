<?php
include_once "..\modules\Quest.php";



use PHPUnit\Framework\TestCase;
use server\modules\Quest;


class QuestTest extends TestCase
{
    public function testGetRandomQuest(): void
    {
        $obj = Quest::getRandomQuest("");
        $this->assertIsObject($obj);


        $obj = Quest::getQuestDef(2);
        $this->assertIsObject($obj);
    }
}

?>