<?php

include_once "..\modules\Pet.php";

use PHPUnit\Framework\TestCase;
use server\modules\Pet;



class PetTest extends TestCase
{
    public function testLoadPet(): void
    {
        // load known avatar
        $obj = Pet::getPet(1);
        $this->assertIsObject($obj);

        // load a bad id
        $obj = Pet::getPet(-42);
        $this->assertEquals($obj, new Pet ());
        $this->assertFalse (isset ($obj->id));
    }

    public function testBreedPet (): void
    {
        $pet1 = Pet::getPet (1);
        $pet2 = Pet::getPet (2);
        $pet3 = Pet::breed($pet1, $pet2, $pet1->owner);
        $this->assertIsObject($pet3);

    }

    public function testPetRest (): void
    {
        $pet1 = Pet::getPet (1);
        $ok = Pet::restPets($pet1->owner, -10, -1);
        $this->assertTrue ($ok);
    }
}

?>