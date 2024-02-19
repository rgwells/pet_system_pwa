<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use server\modules\PetOwner;

include_once "..\modules\PetOwner.php";

final class PetOwnerTest extends TestCase
{
    public function testLoadPetOwner(): void
    {
        // load known avatar
        $obj = PetOwner::getOwner('06340496-1003-4399-a131-84bbc321dc87');
        $this->assertIsObject($obj);

        // load a bad id
        $obj = PetOwner::getOwner('abc');
        $this->assertEquals($obj, new PetOwner ());
    }


    public function testAddFood () : void
    {
        // load known avatar
        $obj = PetOwner::getOwner('06340496-1003-4399-a131-84bbc321dc87');
        $food = $obj->food;

        // reload avatar amd compare the food values.
        $count = PetOwner::addFoodAndAction('06340496-1003-4399-a131-84bbc321dc87', 5, -1);
        $obj = PetOwner::getOwner('06340496-1003-4399-a131-84bbc321dc87');
        $this->assertFalse ($food == $obj->food);
        $this->assertTrue ($obj->food == ($food + 5));
    }


    public function testLogin(): void
    {
        // load known avatar
        $obj = PetOwner::getOwner('06340496-1003-4399-a131-84bbc321dc87');
        $this->assertIsObject($obj);

        PetOwner::login('c4e7f3e3-fc91-483a-8389-a12c504e1251');
        $obj2 = PetOwner::getOwner('c4e7f3e3-fc91-483a-8389-a12c504e1251    ');
    }



    public function testPetList () : void
    {
        // load known avatar
        $obj = PetOwner::getOwner('06340496-1003-4399-a131-84bbc321dc87');
        $this->assertIsObject($obj);


        $pets = PetOwner::getPetList('06340496-1003-4399-a131-84bbc321dc87', 0, 'none');
        $this->assertIsArray($pets);
    }


    public function testOwnerSave () : void
    {
        // load known avatar
        $obj = PetOwner::getOwner('06340496-1003-4399-a131-84bbc321dc87');
        $this->assertIsObject($obj);

        $obj->food = $obj->food + 1;
        $obj->actionPoints = $obj->actionPoints + 1;
        $obj2 = PetOwner::saveOwner($obj);
        $this->assertIsObject($obj2);
        $this->assertTrue($obj2->food === $obj->food);
        $this->assertTrue($obj2->actionPoints === $obj->actionPoints);

    }


    public function testAddLocation () : void
    {
        $count = PetOwner::addLocation('06340496-1003-4399-a131-84bbc321dc87','Pandemonium',"<70.0, 210.0, 56.0>", "1.0.0.0", "1af35e58-e3b7-b432-d1f9-44cb9570773f", "http://www.google.com");
        $this->assertTrue($count > 0);
    }
}

?>