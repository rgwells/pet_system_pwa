<?php

include_once "..\modules\Pet.php";

use PHPUnit\Framework\TestCase;
use server\modules\Pet;



class PetFixupTest extends TestCase
{
    public function testStatFixup () : void
    {
        $pet = Pet::getPet(1);

        $max = $pet->fitnessMax;
        $pet->strength += $max - $pet->strength;
        $pet->constitution += 10;

        $pet = Pet::fixupStats($pet);
        $this->assertIsObject($pet);
        $this->assertTrue($pet->strength < $pet->fitnessMax);

        $pet->loyalty = 20;
        $pet->spirituality = 20;
        $pet->karma = 20;
        $pet = Pet::fixupStats($pet);
        $this->assertTrue($pet->loyalty == 20);



    }
}

?>