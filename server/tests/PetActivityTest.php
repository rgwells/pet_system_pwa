<?php

use PHPUnit\Framework\TestCase;
use server\modules\PetActivity;
use server\modules\Pet;

include_once "..\modules\PetActivity.php";
include_once "..\modules\Pet.php";

class PetActivityTest extends TestCase
{
    public function testAddActivity () : void
    {
        $pet1 = Pet::getPet (1);
        $ok = PetActivity::addActivity($pet1->id, "Encounter");
        $this->assertTrue ($ok);

        try {
            $ok = PetActivity::addActivity(-42, "Encounter");
        }
        catch (Exception $e)
        {
            // OK, fk vioilation
            $ok = true;
        }
        $this->assertTrue($ok);
    }

    public function testGetActivity () : void
    {
        $pa = PetActivity::getActivity(1001);
        $this->assertIsObject ($pa);
        $this->assertIsInt ($pa->petId);
        $this->assertIsString($pa->activity);

    }

    public function testGetActivityByPet () : void
    {
        $a = PetActivity::getActivityByPet(1, 8, 0);
        $this->assertIsArray($a);
        $this->assertTrue (count ($a) >= 1 );
    }
}

?>