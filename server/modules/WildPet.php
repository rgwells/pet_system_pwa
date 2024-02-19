<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
    include_once __DIR__ . "/../modules/HabitatLocation.php";
}

namespace server\modules {

    use Exception;
    use PDO;
    use PDOException;

    class WildPet
    {
        function __construct(string $grade = "Common")
        {
            $temp = random_int (0, 9);
            $this->personality = PetPersonality::$names[$temp];
            $this->grade = $grade;

            switch ($grade)
            {
                case "Uncommon" :  $min = 2; $max = 4; break;
                case "Rare" :      $min = 4; $max = 6; break;
                case "Epic" :      $min = 6; $max = 8; break;
                case "Legendary" : $min = 8; $max = 10; break;
                case "Ancient" :   $min = 10; $max = 12; break;
                case "Mythical" :  $min = 12; $max = 14; break;
                case "Common" :
                default :
                    $min = 0; $max = 2; break;
            }

            // Fitness category
            $temp = random_int ($min, $max);
            $frt = RankTier::$rankTier[$temp];
            $this->fitnessRankTier = $frt;
            // wizardry category
            $temp = random_int ($min, $max);
            $wrt = RankTier::$rankTier[$temp];
            $this->wizardryRankTier = $wrt;
            // charisma category
            $temp = random_int ($min, $max);
            $crt = RankTier::$rankTier[$temp];
            $this->charismaRankTier = $crt;
            // nature category
            $temp = random_int ($min, $max);
            $nrt = RankTier::$rankTier[$temp];
            $this->natureRankTier = $nrt;

            // Misc attributes
            $this->isWild = 1;
            $this->fatigue = 0;
            // Fitness category
            $base =  floor (RankTier::$rankTierMax[$this->fitnessRankTier] / 3);
            $this->constitution = $base;
            $this->strength = $base;
            $this->agility = $base;
            // wizardry category
            $base = floor (RankTier::$rankTierMax[$this->wizardryRankTier] / 3);
            $this->intelligence = $base;
            $this->wisdom = $base;
            $this->sorcery = $base;
            // charisma category
            $base = floor (RankTier::$rankTierMax[$this->charismaRankTier] / 3);
            $this->charm = $base;
            $this->confidence = $base;
            $this->empathy = $base;
            // nature category
            $base = floor (RankTier::$rankTierMax[$this->natureRankTier] / 3);
            $this->loyalty = $base;
            $this->spirituality = $base;
            $this->karma = $base;

            $this->fitness = RankTier::$rankTierMax[$this->fitnessRankTier];
            $this->wizardry = RankTier::$rankTierMax[$this->wizardryRankTier];
            $this->charisma = RankTier::$rankTierMax[$this->charismaRankTier];
            $this->nature = RankTier::$rankTierMax[$this->natureRankTier];

            $this->id = 0;
        }

        public static function getWildPet(int $id) : WildPet
        {
            $obj = new WildPet ();

            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = 'select * from ps_player_pet_view where id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $obj = WildPet::loadFromRow ($row);
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }


        public static function getRandomWildPetForRegion(string $region, string $coord): WildPet
        {
            $obj = null;

            $habitatType = "Plain";
            $dispenser = "dispenser";
            $habitats = HabitatLocation::getHabitatsForRegion($region, 1);
            $habitat = self::getClosestHabitat($coord, $habitats);
            if ($habitat) {
                $habitatType = $habitat->habitatName;
                $dispenser = $habitat->type;
            }
            else {
                if (sizeof($habitats) >= 1) {
                    $habitatType = $habitats[0]->habitatName;
                    $dispenser = $habitats[0]->type;
                }
            }

            $grade = self::getRandomGrade ($dispenser);
            $wp = self::getRandomWildPetForHabitat($habitatType, $grade);
            if (! $wp)
            {
                $wp = self::getRandomWildPetForHabitat($habitatType, 'any');
            }
            $obj = $wp;
            return ($obj);
        }



        public static function getRandomWildPet(string $region, string $coord, string $grade): WildPet
        {
            $obj= null;
            try {
                $habitatType = "Plain";
                $habitats = HabitatLocation::getHabitatsForRegion($region, 1);
                $habitat = self::getClosestHabitat($coord, $habitats);
                if ($habitat) {
                    $habitatType = $habitat->habitatName;
                }
                else {
                    if (sizeof($habitats) >= 1) {
                        $habitatType = $habitats[0]->habitatName;
                    }
                }

                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = 'select * from ps_player_pet_view where is_wild = :wildFlag and enabled = true and habitat = :habitat order by rand() limit 1';
                $stmt = $pdo->prepare($sql);
                $flag = true;
                $stmt->bindParam(':wildFlag', $flag, PDO::PARAM_BOOL);
                $stmt->bindParam(':habitat', $habitatType, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $obj = WildPet::loadFromRow ($row);
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }


        public static function getRandomWildPetForHabitat(string $habitatType, string $grade): WildPet | null
        {
            $obj= null;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = "select * from ps_player_pet_view 
                        where is_wild = :wildFlag 
                          and enabled = true 
                          and attribute in (select attribute from ps_attribute_habitat where habitat = :habitat) 
                          and ('any' = :grade1 or grade = :grade2) 
                        order by rand() limit 1";
                $stmt = $pdo->prepare($sql);
                $flag = true;
                $stmt->bindParam(':wildFlag', $flag, PDO::PARAM_BOOL);
                $stmt->bindParam(':habitat', $habitatType, PDO::PARAM_STR);
                $stmt->bindParam(':grade1', $grade, PDO::PARAM_STR);
                $stmt->bindParam(':grade2', $grade, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $obj = WildPet::loadFromRow ($row);
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }



        public static function getClosestHabitat (string $coordinate, array $habitats) : HabitatLocation | null
        {
            $habitat = null;
            $habitatType = "Plain";
            $size = sizeof ($habitats);
            if ($size == 1)
            {
                $habitatType = $habitats[0]->type;
            }
            else if ($size > 1)
            {
                $p0 = self::string2Coordinate ($coordinate);


                $d = PHP_FLOAT_MAX;
                $i = 0;
                while ($i < $size)
                {
                    $pStr1 = $habitats[$i]->regionCoord;
                    $p1 = self::string2Coordinate($pStr1);
                    $d1 = self::calcDist($p0, $p1);

                    if ($d1 < $d)
                    {
                        $d = $d1;
                        $habitat = $habitats[$i];
                    }
                    $i++;
                }
            }

            return ($habitat);
        }



        public static function calcDist (array $p1, array $p2) : float
        {
            $x = Pow ($p2[0] - $p1[0], 2);
            $y = Pow ($p2[1] - $p1[1], 2);
            $z = Pow ($p2[2] - $p1[2], 2);
            $d = sqrt ( $x + $y + $z);
            return ($d);
        }


        public static function string2Coordinate (string $str) : array
        {
            $str = str_replace ("<", "", $str);
            $str = str_replace (">", "", $str);
            $parts = explode (",", $str);
            $parts[0] =  trim ($parts[0]);
            $parts[1] =  trim ($parts[1]);
            $parts[2] =  trim ($parts[2]);

            $px = floatval ($parts[0]);
            $py = floatval ($parts[1]);
            $pz = floatval ($parts[2]);

            return ([$px, $py, $pz]);
        }


        /**
         * @throws Exception
         */
        public static function generateWildPets (array $species, string $grade) : void
        {
            for ($i = 0; $i < sizeof($species); $i++)
            {
                $name = $species[$i];
                $template = PetTemplate::getPetTemplate($name);
                $p = Pet::cloneFromTemplate($template, $grade, "");
                $p->owner = "";
                $wp = WildPet::cast2Pet ($p);
                WildPet::savePet($wp);
            }
        }


        public static function savePet (WildPet $pet) : WildPet
        {
            $result = $pet;
            $pdo = null;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $pdo->beginTransaction();

                $sql = 'update ps_player_pet set 
                        avuuid = :av, stage = :stage, pet_id = :petId, parent_a = :parentA, parent_b = :parentB, 
                        health = :health, habitat = :habitat, personality = :personality, fatigue = :fatigue,  
                        fitness_rank_tier = :fitnessRankTier, constitution = :constitution, strength = :strength, agility = :agility, 
                        wizardry_rank_tier = :wizardryRankTier, intelligence = :intelligence, wisdom = :wisdom, sorcery = :sorcery, 
                        charisma_rank_tier = :charismaRankTier, charm = :charm, confidence = :confidence, empathy = :empathy, 
                        nature_rank_tier = :natureRankTier, loyalty = :loyalty, spirituality = :spirituality, karma = :karma,
                        pet_number = :petNumber, is_wild = true, enabled = :enabled
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
                $stmt->bindParam(':petNumber', $pet->petNumber, PDO::PARAM_INT);
                $stmt->bindParam(':enabled', $pet->enabled, PDO::PARAM_INT);
                $stmt->bindParam(':id', $pet->id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    if ($pdo->commit()) {
                        $result = WildPet::getWildPet($pet->id);
                    }
                }
            } catch (PDOException $e) {
                $pdo?->rollBack();
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }



        private static function getRandomGrade (string $dispenserType) : string
        {
            $gradeName = "";
            $randValue = mt_rand(0, 1000) / 10;
            if ($dispenserType == "affiliate")
            {
                // Common: 59%
                if ($randValue <= 59.0)
                {
                    $gradeName = "Common";
                }
                //Uncommon: 32%
                else if ($randValue <= 91.0)
                {
                    $gradeName = "Uncommon";
                }
                //Rare: 6%
                else if ($randValue <= 97.0)
                {
                    $gradeName = "Rare";
                }

                /*
                //Epic: 2%
                else if ($randValue <= 99.0)
                {
                    $gradeName = "Epic";
                }
                //Legendary: 1%
                else
                {
                    $gradeName = "Legendary";
                }
                */
                else {
                    $gradeName = "Common";
                }

            }
            else if ($dispenserType == "partner") {
                // Common:
                if ($randValue <= 53.0)
                {
                    $gradeName = "Common";
                }
                //Uncommon: 30%
                else if ($randValue <= 83.0)
                {
                    $gradeName = "Uncommon";
                }
                //Rare: 17%
                else
                {
                    $gradeName = "Rare";
                }
                /*
                //Epic: 7%
                else if ($randValue <= 96.0)
                {
                    $gradeName = "Epic";
                }
                //Legendary: 3%
                else if ($randValue <= 99.0)
                {
                    $gradeName = "Legendary";
                }
                //Ancient: 0.8%
                else if ($randValue <= 99.8)
                {
                    $gradeName = "Ancient";
                }
                //Mythical: 0.2%
                else
                {
                    $gradeName = "Mythical";
                }
                */
            }
            else
            {
                // Common: 72%
                if ($randValue < 72.0)
                {
                    $gradeName = "Common";
                }
                //Uncommon: 27%
                else if ($randValue < 99.0)
                {
                    $gradeName = "Uncommon";
                }
                //Rare: 1%
                else
                {
                    $gradeName = "Rare";
                }
            }

            return ($gradeName);
        }


        private static function cast2Pet (Pet $pet) : WildPet
        {
            $obj = new WildPet ();
            $obj->id = $pet->id;
            $obj->petNumber = 0;
            $obj->enabled = $pet->enabled;
            $obj->updateTime = $pet->updateTime;
            $obj->petId = $pet->petId;
            $obj->parentA = $pet->parentA;
            $obj->parentB = $pet->parentA;
            $obj->owner = "";
            $obj->birthDate = $pet->birthDate;
            $obj->age = $pet->age;
            $obj->stage = $pet->stage;
            $obj->health = $pet->health;
            $obj->habitat = $pet->habitat;
            $obj->personality = $pet->personality;
            $obj->isWild = true;
            // Misc attributes
            $obj->fatigue = $pet->fatigue;
            // Fitness category
            $obj->fitnessRankTier = $pet->fitnessRankTier;
            $obj->fitness = $pet->fitness;
            $obj->constitution = $pet->constitution;
            $obj->strength = $pet->strength;
            $obj->agility = $pet->agility;
            // wizardry category
            $obj->wizardryRankTier = $pet->wizardryRankTier;
            $obj->wizardry = $pet->wizardry;
            $obj->intelligence = $pet->intelligence;
            $obj->wisdom = $pet->wisdom;
            $obj->sorcery = $pet->sorcery;
            // charisma category
            $obj->charismaRankTier = $pet->charismaRankTier;
            $obj->charisma = $pet->charisma;
            $obj->charm = $pet->charm;
            $obj->confidence = $pet->confidence;
            $obj->empathy = $pet->empathy;
            // nature category
            $obj->natureRankTier = $pet->natureRankTier;
            $obj->nature = $pet->nature;
            $obj->loyalty = $pet->loyalty;
            $obj->spirituality = $pet->spirituality;
            $obj->karma = $pet->karma;
            // odds and ends
            $obj->texture = $pet->texture;
            $obj->faceTexture = $pet->faceTexture;
            $obj->attributeTexture = $pet->attributeTexture;
            $obj->attributeColor = $pet->attributeColor;
            $obj->grade = $pet->grade;
            $obj->attribute = $pet->attribute;
            $obj->species = $pet->species;

            return ($obj);
        }

        private static function loadFromRow (array $row) : WildPet
        {
            $obj = new WildPet ();
            $obj->id = $row["id"];
            $obj->petNumber = $row["pet_number"];
            $obj->enabled = $row["enabled"];
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
            $obj->isWild = $row["is_wild"];
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
            $obj->faceTexture = $row["face_texture"];
            $obj->attributeTexture = $row["attribute_texture"];
            $obj->attributeColor = $row["attribute_color"];
            $obj->grade = $row["grade"];
            $obj->attribute = $row["attribute"];
            $obj->species = $row["species"];

            return ($obj);
        }


        // ----------------------------------------------
        // Pet properties
        public string $id;  // pet database id
        public string $species; // type of per (denormalized from det definition)
        public int $petNumber = 0; // pet number
        public bool $enabled = false; // is pet enabled
        public int | null $parentA;  // parent A
        public int | null $parentB; // parent B
        public int $petId;
        public int $isWild = 1;
        public string | null $owner;  // owner uuid
        public int $birthDate; // birthdate
        public int $updateTime; // last update time of object / pet
        public int $age = 0;  // age of the pet in days  (still need this?)
        public string $stage = "Adult";  // start of per growth, Juvenile, adult, senior
        public string $health = "Healthy"; // health of the pet currently
        public string $habitat; // pets normal habitat
        public string $personality; // personality of the pet

        // fitness category
        public string $fitnessRankTier;
        public int $fitness = 30;
        public int $constitution = 10;
        public int $strength = 10;
        public int $agility = 10;

        // wizardry category
        public string $wizardryRankTier;
        public int $wizardry = 30;
        public int $intelligence = 10;
        public int $wisdom = 10;
        public int $sorcery = 10;

        // charisma category
        public string $charismaRankTier;
        public int $charisma = 30;
        public int $charm = 10;
        public int $confidence = 10;
        public int $empathy = 10;

        // nature category
        public string $natureRankTier;
        public int $nature = 30; // current nature
        public int $loyalty = 10;  // loyalty
        public int $spirituality = 10; // oooh powers
        public int $karma = 10; // karma

        // Misc settings
        public int $fatigue; // current stress level of pet
        public string $texture;  // denormalized from attributed
        public string $faceTexture; // denormalized from ps_pet
        public string $attributeTexture; // denormalized from attributes table
        public string $attributeColor; // denormalized from attributed
        public string $grade; // denormalized from pet information
        public string $attribute;  // denormalized from attribute table
    }
}

?>