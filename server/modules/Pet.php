<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace server\modules {

    use Exception;
    use PDO;
    use PDOException;

    include_once __DIR__ . "/PetGene.php";
    include_once __DIR__ . "/PetOwner.php";
    include_once __DIR__ . "/PetPersonality.php";
    include_once __DIR__ . "/PetHabitat.php";
    include_once __DIR__ . "/RankTier.php";


    class Pet
    {
        public static function getPet(int $id) : Pet
        {
            $obj = new Pet ();

            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = 'select * from ps_player_pet_view where id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        $row = $stmt->fetch();
                        $obj = Pet::loadFromRow($row);
                    }
                }
                else {
                    $stmt->errorCode();
                    eLog (implode ($stmt->errorInfo()) . ', code = ' . $stmt->errorCode());
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }


        public static function getNextPetNumber() : int
        {
            $result = 0;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = 'select max(pet_number) as count from ps_player_pet_view';
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $result = $row["count"];
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($result);
        }


        public static function getPetByOwnerAndNumber(string $owner, int $petNumber) : Pet
        {
            $obj = new Pet ();

            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = 'select * from ps_player_pet_view where avuuid = :avId and pet_number = :petNumber';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':avId', $owner, PDO::PARAM_STR);
                $stmt->bindParam(':petNumber', $petNumber, PDO::PARAM_INT);

                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $obj = Pet::loadFromRow ($row);
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }

        public static function deletePet (int $petId) : bool
        {
            $result = false;
            $pdo = null;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $pdo->beginTransaction();

                $sql = 'delete from ps_pet_activity where pet_id = :petId';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':petId', $petId, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $sql = 'delete from ps_pet_genome where  pet_id = :petId';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':petId', $petId, PDO::PARAM_INT);
                    $stmt->execute();


                    $sql = 'delete from ps_player_pet where  id = :petId';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':petId', $petId, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        $count = $stmt->rowCount();
                        if ($pdo->commit()) {
                            $result = $count;
                        }
                    }
                }
            } catch (PDOException $e) {
                $pdo?->rollBack();
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($result);
        }


        public static function getFirstPetByOwner(string $avId, string $attribute) : Pet
        {
            $obj = new Pet ();

            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = "select * from ps_player_pet_view " .
                    "where avuuid = :avId and ('none' = :attr1 OR attribute = :attr2) " .
                    "order by pet_number";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':avId', $avId, PDO::PARAM_STR);
                $stmt->bindParam(':attr1', $attribute, PDO::PARAM_STR);
                $stmt->bindParam(':attr2', $attribute, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $obj = Pet::loadFromRow ($row);
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }


        public static function getPetCountForOwner(string $avId, string $filter) : int
        {
            $count = 0;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = "select count(*) as count from ps_player_pet_view where avuuid = :avId and ('none' = :filterOpt or attribute = :filterValue)";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':avId', $avId, PDO::PARAM_STR);
                $stmt->bindParam(':filterOpt', $filter, PDO::PARAM_STR);
                $stmt->bindParam(':filterValue', $filter, PDO::PARAM_STR);
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

        private static function loadFromRow (array $row) : Pet
        {
            $obj = new Pet ();
            $obj->id = $row["id"];
            $obj->petNumber = $row["pet_number"];
            $obj->enabled = (is_null ($row ["enabled"])) ? false : $row ["enabled"];
            $obj->updateTime = strtotime ($row["update_date"]);
            $obj->petId = $row["pet_id"];
            $obj->parentA = $row["parent_a"];
            $obj->parentB = $row["parent_b"];
            $obj->owner = (is_null ($row["avuuid"])) ? ('') : ($row["avuuid"]);
            $obj->birthDate = strtotime ($row["birth_date"]);
            $obj->age = $row["age"];
            $obj->stage = $row["stage"];
            $obj->health = $row["health"];
            $obj->habitat = $row["habitat"];
            $obj->personality = $row["personality"];
            // Misc attributes
            $obj->fatigue = $row["fatigue"];
            // Fitness category
            $obj->fitnessRankTier = $row["fitness_rank_tier"];
            $obj->fitness = $row["fitness"];
            $obj->constitution = $row["constitution"];
            $obj->strength = $row["strength"];
            $obj->agility = $row["agility"];
            // wizardry category
            $obj->wizardryRankTier = $row["wizardry_rank_tier"];
            $obj->wizardry = $row["wizardry"];
            $obj->intelligence = $row["intelligence"];
            $obj->wisdom = $row["wisdom"];
            $obj->sorcery = $row["sorcery"];
            // charisma category
            $obj->charismaRankTier = $row["charisma_rank_tier"];
            $obj->charisma = $row["charisma"];
            $obj->charm = $row["charm"];
            $obj->confidence = $row["confidence"];
            $obj->empathy = $row["empathy"];
            // nature category
            $obj->natureRankTier = $row["nature_rank_tier"];
            $obj->nature = $row["nature"];
            $obj->loyalty = $row["loyalty"];
            $obj->spirituality = $row["spirituality"];
            $obj->karma = $row["karma"];
            // odds and ends
            $obj->texture = $row["pet_texture"];
            $obj->faceTexture = $row["face_texture"] ? $row["face_texture"] : '';
            $obj->attributeTexture = $row["attribute_texture"];
            $obj->attributeColor = $row["attribute_color"];
            $obj->grade = $row["grade"];
            $obj->attribute = $row["attribute"];
            $obj->species = $row["species"];

            $obj->fitnessMax = $row["fitness_max"];
            $obj->wizardryMax = $row["wizardry_max"];
            $obj->charismaMax = $row["charisma_max"];
            $obj->natureMax = $row["nature_max"];

            $obj->breedingCount = $row["breeding_count"];
            $obj->forageCount = $row["forage_count"];
            $obj->encounterCount = $row["encounter_count"];
            $obj->trainCount = $row["train_count"];

            return ($obj);
        }


        public static function savePet ($pet) : Pet
        {
            $result = $pet;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $pdo->beginTransaction();

                $pet = Pet::fixupStats ($pet);

                $sql = 'update ps_player_pet set 
                        avuuid = :av, stage = :stage, pet_id = :petId, parent_a = :parentA, parent_b = :parentB, 
                        health = :health, habitat = :habitat, personality = :personality, fatigue = :fatigue,  
                        fitness_rank_tier = :fitnessRankTier, constitution = :constitution, strength = :strength, agility = :agility, 
                        wizardry_rank_tier = :wizardryRankTier, intelligence = :intelligence, wisdom = :wisdom, sorcery = :sorcery, 
                        charisma_rank_tier = :charismaRankTier, charm = :charm, confidence = :confidence, empathy = :empathy, 
                        nature_rank_tier = :natureRankTier, loyalty = :loyalty, spirituality = :spirituality, karma = :karma,
                        pet_number = :petNumber, enabled = :enabled, is_wild = false
                        where id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':av', $pet->owner, PDO::PARAM_STR);
                $stmt->bindParam(':stage', $pet->stage, PDO::PARAM_STR);
                $stmt->bindParam(':petId', $pet->petId,  PDO::PARAM_INT);
                $stmt->bindParam(':parentA', $pet->parentA,  PDO::PARAM_INT);
                $stmt->bindParam(':parentB', $pet->parentB,  PDO::PARAM_INT);
                $stmt->bindParam(':health', $pet->health, PDO::PARAM_STR);
                $stmt->bindParam(':habitat', $pet->habitat, PDO::PARAM_STR);
                $stmt->bindParam(':personality', $pet->personality, PDO::PARAM_STR);
                $stmt->bindParam(':fatigue', $pet->fatigue, PDO::PARAM_INT);
                $stmt->bindParam(':fitnessRankTier', $pet->fitnessRankTier, PDO::PARAM_STR);
                $stmt->bindParam(':constitution', $pet->constitution, PDO::PARAM_INT);
                $stmt->bindParam(':strength', $pet->strength, PDO::PARAM_INT);
                $stmt->bindParam(':agility', $pet->agility, PDO::PARAM_INT);
                $stmt->bindParam(':wizardryRankTier', $pet->wizardryRankTier, PDO::PARAM_STR);
                $stmt->bindParam(':intelligence', $pet->intelligence, PDO::PARAM_INT);
                $stmt->bindParam(':wisdom', $pet->wisdom, PDO::PARAM_INT);
                $stmt->bindParam(':sorcery', $pet->sorcery, PDO::PARAM_INT);
                $stmt->bindParam(':charismaRankTier', $pet->charismaRankTier, PDO::PARAM_STR);
                $stmt->bindParam(':charm', $pet->charm, PDO::PARAM_INT);
                $stmt->bindParam(':confidence', $pet->confidence, PDO::PARAM_INT);
                $stmt->bindParam(':empathy', $pet->empathy, PDO::PARAM_INT);
                $stmt->bindParam(':natureRankTier', $pet->natureRankTier, PDO::PARAM_STR);
                $stmt->bindParam(':loyalty', $pet->loyalty, PDO::PARAM_INT);
                $stmt->bindParam(':spirituality', $pet->spirituality, PDO::PARAM_INT);
                $stmt->bindParam(':karma', $pet->karma, PDO::PARAM_INT);
                $stmt->bindParam(':enabled', $pet->enabled, PDO::PARAM_INT);
                $stmt->bindParam(':petNumber', $pet->petNumber, PDO::PARAM_INT);
                $stmt->bindParam(':id', $pet->id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    if ($pdo->commit()) {
                        $result = Pet::getPet($pet->id);
                    }
                }
            } catch (PDOException $e) {
                $pdo?->rollBack();
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }

        public static function putPet($pet) : Pet
        {
            $result = new Pet ();
            $flag = false;
            $id  = 0;
            $pdo = null;

            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $pdo->beginTransaction();

                $sql = 'insert into ps_player_pet 
                        (avuuid, stage, pet_id, parent_a, parent_b, health, habitat, personality,  fatigue, 
                         fitness_rank_tier, constitution, strength, agility, 
                         wizardry_rank_tier, intelligence, wisdom, sorcery, charisma_rank_tier, charm, confidence, 
                         empathy, nature_rank_tier, loyalty, spirituality, karma,
                         enabled) 
                        values 
                        (:av, :stage, :petId, :parentA, :parentB, :health, :habitat, :personality, :fatigue,  
                         :fitness_rank_tier, :constitution, :strength, :agility,
                         :wizardry_rank_tier, :intelligence, :wisdom, :sorcery, :charisma_rank_tier, :charm, :confidence, 
                         :empathy, :nature_rank_tier, :loyalty, :spirit, :karma,
                         :enabled)';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':av', $pet->owner, PDO::PARAM_STR);
                $stmt->bindParam(':stage', $pet->stage, PDO::PARAM_STR);
                $stmt->bindParam(':petId', $pet->petId,  PDO::PARAM_INT);
                $stmt->bindParam(':enabled', $pet->enabled,  PDO::PARAM_INT);
                $stmt->bindParam(':parentA', $pet->parentA,  PDO::PARAM_INT);
                $stmt->bindParam(':parentB', $pet->parentB,  PDO::PARAM_INT);
                $stmt->bindParam(':health', $pet->health, PDO::PARAM_STR);
                $stmt->bindParam(':habitat', $pet->habitat, PDO::PARAM_STR);
                $stmt->bindParam(':personality', $pet->personality, PDO::PARAM_STR);
                $stmt->bindParam(':fatigue', $pet->fatigue, PDO::PARAM_INT);
                $stmt->bindParam(':fitness_rank_tier', $pet->fitnessRankTier, PDO::PARAM_STR);
                $stmt->bindParam(':constitution', $pet->constitution, PDO::PARAM_INT);
                $stmt->bindParam(':strength', $pet->strength, PDO::PARAM_INT);
                $stmt->bindParam(':agility', $pet->agility, PDO::PARAM_INT);
                $stmt->bindParam(':wizardry_rank_tier', $pet->wizardryRankTier, PDO::PARAM_STR);
                $stmt->bindParam(':intelligence', $pet->intelligence, PDO::PARAM_INT);
                $stmt->bindParam(':wisdom', $pet->wisdom, PDO::PARAM_INT);
                $stmt->bindParam(':sorcery', $pet->sorcery, PDO::PARAM_INT);
                $stmt->bindParam(':charisma_rank_tier', $pet->charismaRankTier, PDO::PARAM_STR);
                $stmt->bindParam(':charm', $pet->charm, PDO::PARAM_INT);
                $stmt->bindParam(':confidence', $pet->confidence, PDO::PARAM_INT);
                $stmt->bindParam(':empathy', $pet->empathy, PDO::PARAM_INT);
                $stmt->bindParam(':nature_rank_tier', $pet->natureRankTier, PDO::PARAM_STR);
                $stmt->bindParam(':loyalty', $pet->loyalty, PDO::PARAM_INT);
                $stmt->bindParam(':spirit', $pet->spirituality, PDO::PARAM_INT);
                $stmt->bindParam(':karma', $pet->karma, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() >= 1) {
                        $id = $pdo->lastInsertId();
                        if ($pdo->commit()) {
                            $flag = true;
                        }
                    }
                }
            } catch (PDOException $e) {
                $pdo?->rollBack();
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            if ($flag)
            {
                $result = Pet::getPet($id);
            }


            return ($result);
        }


        public static function restPets (string $ownerId, int $fatigueAmt, int $actionPts) : bool
        {
            $result = false;
            $pdo = null;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $pdo->beginTransaction();

                // NOTE: this sql has the potential to move some fatigue values
                // below 0, this is not an accepted state for the value
                // so another sql statement will be run after this to fix up the values
                $sql = "update ps_player_pet set fatigue = fatigue + :fatigue where avuuid = :avId and health <> 'Dead' ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':avId', $ownerId, PDO::PARAM_STR);
                $stmt->bindParam(':fatigue', $fatigueAmt, PDO::PARAM_INT);
                if ($stmt->execute()) {

                    // fix up pet fatigue values anything below zero, should be set to 0
                    $sql = 'update ps_player_pet set fatigue = 0 where fatigue < 0';
                    $stmt = $pdo->prepare($sql);
                    if ($stmt->execute()) {
                        $result = $pdo->commit();
                        $owner = PetOwner::getOwner($ownerId);
                        // calculate the new value for action points
                        $owner->actionPoints = $owner->actionPoints + $actionPts;
                        $owner = PetOwner::saveOwner($owner);
                        eLog ("action points: " . $owner->actionPoints);
                    }
                }
            } catch (PDOException $e) {
                $pdo?->rollBack();
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }


        /**
         * @throws Exception
         */
        public static function breed(Pet $pet1, Pet $pet2, string $av) : Pet
        {
            $newPet = new Pet ();

            $newPet = Pet::setBaseAttributes ($newPet, $pet1->grade);

            $newPet->owner = $av;
            // info from parents
            $temp = random_int (0, 1);
            $parentPet = $pet1;
            if ($temp) {
                $parentPet = $pet2;
            }
            $newPet->parentA = $pet1->id;
            $newPet->parentB = $pet2->id;
            $newPet->petId = $parentPet->petId;
            $newPet->texture = $parentPet->texture;
            $newPet->faceTexture = $parentPet->faceTexture;
            $newPet->attributeTexture = $parentPet->attributeTexture;
            $newPet->attributeColor = $parentPet->attributeColor;
            $newPet->attribute = $parentPet->attribute;
            $newPet->species = $parentPet->species;
            $newPet->habitat = PetHabitat::getRandomHabitat($parentPet->attribute);

            $newPet = Pet::putPet($newPet);
            return ($newPet);
        }


        /**
         * @throws Exception
         */
        public static function cloneFromTemplate (PetTemplate $pet, string $grade, string $avId) : Pet
        {
            $obj = new Pet ();

            $obj = Pet::setBaseAttributes ($obj, $grade);

            $obj->owner = $avId;
            // clone info from template pet
            $obj->parentA = null;
            $obj->parentB = null;
            $obj->petId = $pet->id;
            $obj->texture = $pet->texture;
            $obj->faceTexture = $pet->faceTexture;
            $obj->attributeTexture = $pet->attributeTexture;
            $obj->attributeColor = $pet->color;
            $obj->attribute = $pet->attributeName;
            $obj->species = $pet->species;

            // generate a random habitat
            $obj->habitat = PetHabitat::getRandomHabitat($pet->attributeName);

            $obj = Pet::putPet($obj);
            // make the genome for the pet
            $gene = PetGene::saveRandomGene($obj);

            return ($obj);
        }


        /**
         * @throws Exception
         */
        private static function setBaseAttributes (Pet $pet, string $grade) : Pet
        {
            $pet->age = 0;
            $pet->stage = 'Adult';

            $temp = random_int (0, 9);
            $personality = PetPersonality::$names[$temp];
            $pet->personality = $personality;
            $pet->grade = $grade;
            $pet->health = 'Healthy';

            switch ($grade)
            {
                case "Uncommon" :  $min = 2; $max = 4; $base = 20; break;
                case "Rare" :      $min = 4; $max = 6; $base = 30; break;
                case "Epic" :      $min = 6; $max = 8; $base = 40; break;
                case "Legendary" : $min = 8; $max = 10; $base = 50; break;
                case "Ancient" :   $min = 10; $max = 12; $base = 60; break;
                case "Mythical" :  $min = 12; $max = 14; $base = 70; break;

                case "Common" :
                default :
                    $min = 0; $max = 2; $base = 10; break;
            }

             // Fitness category
            $temp = random_int ($min, $max);
            $frt = RankTier::$rankTier[$temp];
            $pet->fitnessRankTier = $frt;
            // wizardry category
            $temp = random_int ($min, $max);
            $wrt = RankTier::$rankTier[$temp];
            $pet->wizardryRankTier = $wrt;
            // charisma category
            $temp = random_int ($min, $max);
            $crt = RankTier::$rankTier[$temp];
            $pet->charismaRankTier = $crt;
            // nature category
            $temp = random_int ($min, $max);
            $nrt = RankTier::$rankTier[$temp];
            $pet->natureRankTier = $nrt;

            // Misc attributes
            $pet->fatigue = 0;
            // Fitness category
            $pet->constitution = $base;
            $pet->strength = $base;
            $pet->agility = $base;
            // wizardry category
            $pet->intelligence = $base;
            $pet->wisdom = $base;
            $pet->sorcery = $base;
            // charisma category
            $pet->charm = $base;
            $pet->confidence = $base;
            $pet->empathy = $base;
            // nature category
            $pet->loyalty = $base;
            $pet->spirituality = $base;
            $pet->karma = $base;

            return ($pet);
        }

        public static function fixupStats (Pet $pet) : Pet
        {
            // first check for negative numbers in the stats
            // Misc attributes
            $pet->fatigue = ($pet->fatigue < 0) ? (0) : ($pet->fatigue);
            // Fitness category
            $pet->constitution = ($pet->constitution < 0) ? (0) : ($pet->constitution);
            $pet->strength = ($pet->strength < 0) ? (0) : ($pet->strength);
            $pet->agility = ($pet->agility < 0) ? (0) : ($pet->agility);
            // wizardry category
            $pet->intelligence = ($pet->intelligence < 0) ? (0) : ($pet->intelligence);
            $pet->wisdom = ($pet->wisdom < 0) ? (0) : ($pet->wisdom);
            $pet->sorcery = ($pet->sorcery < 0) ? (0) : ($pet->sorcery);
            // charisma category
            $pet->charm = ($pet->charm < 0) ? (0) : ($pet->charm);
            $pet->confidence = ($pet->confidence < 0) ? (0) : ($pet->confidence);
            $pet->empathy = ($pet->empathy < 0) ? (0) : ($pet->empathy);
            // nature category
            $pet->loyalty = ($pet->loyalty < 0) ? (0) : ($pet->loyalty);
            $pet->spirituality = ($pet->spirituality < 0) ? (0) : ($pet->spirituality);
            $pet->karma = ($pet->karma < 0) ? (0) : ($pet->karma);

            // enforce limits on stats
            if ($pet->id)
            {
                $oldPet = Pet::getPet($pet->id);

                // Fitness category
                $temp = Pet::setMaxStat2(
                    $pet->fitnessMax,
                    [$pet->strength, $pet->constitution, $pet->agility],
                    [$oldPet->strength, $oldPet->constitution, $oldPet->agility]);
                $pet->strength = $temp[0];
                $pet->constitution = $temp[1];
                $pet->agility = $temp[2];

                // Wizardry category
                $temp = Pet::setMaxStat2(
                    $pet->wizardryMax,
                    [$pet->intelligence, $pet->wisdom, $pet->sorcery],
                    [$oldPet->intelligence, $oldPet->wisdom, $oldPet->sorcery]);
                $pet->intelligence = $temp[0];
                $pet->wisdom = $temp[1];
                $pet->sorcery = $temp[2];

                // Charisma category
                $temp = Pet::setMaxStat2(
                    $pet->charismaMax,
                    [$pet->charm, $pet->confidence, $pet->empathy],
                    [$oldPet->charm, $oldPet->confidence, $oldPet->empathy]);
                $pet->charm = $temp[0];
                $pet->confidence = $temp[1];
                $pet->empathy = $temp[2];

                // Nature category
                $temp = Pet::setMaxStat2(
                    $pet->natureMax,
                    [$pet->loyalty, $pet->spirituality, $pet->karma],
                    [$oldPet->loyalty, $oldPet->spirituality, $oldPet->karma]);
                $pet->loyalty = $temp[0];
                $pet->spirituality = $temp[1];
                $pet->karma = $temp[2];
            }
            return ($pet);
        }



        private static function setMaxStat (int $maxValue, array $newValues, array $oldValues) : array
        {
            $result = array ();

            $len = count ($newValues);
            $total = array_sum ($newValues);
            if ($total > $maxValue)
            {
                for ($i= 0; $i < $len; $i++)
                {
                    $oldValues[$i] = $newValues[$i];
                    $oldTotal = array_sum($oldValues);
                    if ($oldTotal < $maxValue)
                    {
                        continue;
                    }
                    else
                    {
                        $oldValues[$i] -= ($oldTotal - $maxValue);
                    }
                }
                $result = $oldValues;
            }
            else
            {
                $result = $newValues;
            }

            return ($result);
        }

        private static function setMaxStat2 (int $maxValue, array $newValues, array $oldValues) : array
        {
            $result = array ();

            $len = count ($newValues);

            for ($i= 0; $i < $len; $i++)
            {
                $oldValues[$i] = $newValues[$i];

                if ($newValues[$i] < $maxValue)
                {
                    continue;
                }
                else
                {
                    $oldValues[$i] = $maxValue;
                }
            }
            $result = $oldValues;


            return ($result);
        }

        // ----------------------------------------------
        // Pet properties
        public string $id = "";  // pet database id
        public string $species = ""; // type of per (denormalized from det definition)
        public int $petNumber = 0; // pet number
        public bool $enabled = false; // is pet enabled
        public int | null $parentA;  // parent A
        public int | null $parentB; // parent B
        public int $petId = 0;
        public string $owner = "";  // owner uuid
        public int $birthDate = 0; // birthdate
        public int $updateTime = 0; // last update time of object / pet
        public int $age = 0;  // age of the pet in days  (still need this?)
        public string $stage = "";  // start of per growth, Juvenile, adult, senior
        public string $health = ""; // health of the pet currently
        public string $habitat = ""; // pets normal habitat
        public string $personality = ""; // personality of the pet

        // fitness category
        public string $fitnessRankTier = "";
        public int $fitness = 0;
        public int $constitution = 0;
        public int $strength = 0;
        public int $agility = 0;

        // wizardry category
        public string $wizardryRankTier = "";
        public int $wizardry = 0;
        public int $intelligence = 0;
        public int $wisdom = 0;
        public int $sorcery = 0;

        // charisma category
        public string $charismaRankTier = "";
        public int $charisma = 0;
        public int $charm = 0;
        public int $confidence = 0;
        public int $empathy = 0;

        // nature category
        public string $natureRankTier = "";
        public int $nature = 0; // current nature
        public int $loyalty = 0;  // loyalty
        public int $spirituality = 0; // oooh powers
        public int $karma = 0; // karma

        // Misc settings
        public int $fatigue = 0; // current stress level of pet
        public string $texture = "";  // denormalized from attributed
        public string $faceTexture; // denormalized from pet base data
        public string $attributeTexture = ""; // denormalized from attributes table
        public string $attributeColor = ""; // denormalized from attributed
        public string $grade = ""; // denormalized from pet information
        public string $attribute = "";  // denormalized from attribute table

        public int $fitnessMax = 0;  // denormalized max fitness value
        public int $wizardryMax = 0;  // denormalized max wizardry value
        public int $charismaMax = 0;  // denormalized max charisma value
        public int $natureMax = 0;  // denormalized max nature value

        public int $breedingCount = 0; // Calculated:  how many times has the pet bred?
        public int $forageCount = 0;  // Calculated: how many times has the per foraged
        public int $encounterCount = 0; // Calculated: how many encounters has the pet had?
        public int $trainCount = 0;  // Calculated: training count
    }
}

?>