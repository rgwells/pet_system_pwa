<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace modules {

    use Exception;
    use PDO;
    use PDOException;

    class PetGene
    {
        public static function getGenome ($petId) : PetGene
        {
            $result = null;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = 'select * from ps_pet_genome_view where pet_id = :petId';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':petId', $petId, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $row = $stmt->fetch();
                    if ($row) {
                        $result = PetGene::loadFromRow($row);
                    }
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }


        /**
         * @throws Exception
         */
        public static function makeRandomGene () : PetGene
        {
            $obj = new PetGene ();

            $obj->constitutionDom = random_int(0, 1);
            $obj->strengthDom = random_int(0, 1);
            $obj->agilityDom = random_int(0, 1);

            $obj->charmDom = random_int(0, 1);
            $obj->confidenceDom = random_int(0, 1);
            $obj->empathyDom = random_int(0, 1);

            $obj->intelligenceDom = random_int(0, 1);
            $obj->wisdomDom = random_int(0, 1);
            $obj->sorceryDom = random_int(0, 1);

            $obj->karmaDom = random_int(0, 1);
            $obj->loyaltyDom = random_int(0, 1);
            $obj->spiritualityDom = random_int(0, 1);

            $obj->personalityDom = random_int(0, 1);

            return ($obj);
        }

        public static function saveRandomGene (Pet $pet) : PetGene | null
        {
            $result = null;
            try {
                $a = random_int(0, 1);
                $b = random_int(0, 1);
                $c = random_int(0, 1);
                $d = random_int(0, 1);
                $e = random_int(0, 1);
                $f = random_int(0, 1);
                $g = random_int(0, 1);
                $h = random_int(0, 1);
                $i = random_int(0, 1);
                $j = random_int(0, 1);
                $k = random_int(0, 1);
                $l = random_int(0, 1);
                $m = random_int(0, 1);

                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = 'insert into ps_pet_genome  
                       (pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
                       values
                       (:petId, :a, :b, :c, :d, :e, :f, :g, :h, :i, :j, :k, :l, :m)';

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':petId', $pet->id, PDO::PARAM_INT);
                $stmt->bindParam(':a', $a, PDO::PARAM_INT);
                $stmt->bindParam(':b', $b, PDO::PARAM_INT);
                $stmt->bindParam(':c', $c, PDO::PARAM_INT);
                $stmt->bindParam(':d', $d, PDO::PARAM_INT);
                $stmt->bindParam(':e', $e, PDO::PARAM_INT);
                $stmt->bindParam(':f', $f, PDO::PARAM_INT);
                $stmt->bindParam(':g', $g, PDO::PARAM_INT);
                $stmt->bindParam(':h', $h, PDO::PARAM_INT);
                $stmt->bindParam(':i', $i, PDO::PARAM_INT);
                $stmt->bindParam(':j', $j, PDO::PARAM_INT);
                $stmt->bindParam(':k', $k, PDO::PARAM_INT);
                $stmt->bindParam(':l', $l, PDO::PARAM_INT);
                $stmt->bindParam(':m', $m, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $result = PetGene::getGenome ($pet->id);
                }
            }
            catch (PDOException | Exception $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($result);
        }

        private static function loadFromRow (array $row) : PetGene
        {
            $obj = new PetGene ();

            $obj->fitnessMin = $row["fit_min_value"];
            $obj->fitnessMax = $row["fit_max_value"];
            $obj->fitnessRate = $row["fit_mutation_rate"];

            $obj->charismaMin = $row["chr_min_value"];
            $obj->charismaMax = $row["chr_max_value"];
            $obj->charismaRate = $row["chr_mutation_rate"];

            $obj->wizardryMin = $row["wiz_min_value"];
            $obj->wizardryMax = $row["wiz_max_value"];
            $obj->wizardryRate = $row["wiz_mutation_rate"];

            $obj->natureMin = $row["nat_min_value"];
            $obj->natureMax = $row["nat_max_value"];
            $obj->natureRate = $row["nat_mutation_rate"];

            $obj->constitutionMin = $row["con_min_value"];
            $obj->strengthMin = $row["str_min_value"];
            $obj->agilityMin = $row["agi_min_value"];
            $obj->charmMin = $row["cha_min_value"];
            $obj->confidenceMin = $row["cfd_min_value"];
            $obj->empathyMin = $row["emp_min_value"];
            $obj->intelligenceMin = $row["int_min_value"];
            $obj->wisdomMin = $row["wis_min_value"];
            $obj->sorceryMin = $row["src_min_value"];
            $obj->loyaltyMin = $row["loy_min_value"];
            $obj->spiritualityMin = $row["spr_min_value"];
            $obj->karmaMin = $row["kar_min_value"];

            $obj->constitutionMax = $row["con_max_value"];
            $obj->strengthMax = $row["str_max_value"];
            $obj->agilityMax = $row["agi_max_value"];
            $obj->charmMax = $row["cha_max_value"];
            $obj->confidenceMax = $row["cfd_max_value"];
            $obj->empathyMax = $row["emp_max_value"];
            $obj->intelligenceMax = $row["int_max_value"];
            $obj->wisdomMax = $row["wis_max_value"];
            $obj->sorceryMax = $row["src_max_value"];
            $obj->loyaltyMax = $row["loy_max_value"];
            $obj->spiritualityMax = $row["spr_max_value"];
            $obj->karmaMax = $row["kar_max_value"];

            $obj->constitutionRate = $row["con_mutation_rate"];
            $obj->strengthRate = $row["str_mutation_rate"];
            $obj->agilityRate = $row["agi_mutation_rate"];
            $obj->charmRate= $row["cha_mutation_rate"];
            $obj->confidenceRate = $row["cfd_mutation_rate"];
            $obj->empathyRate = $row["emp_mutation_rate"];
            $obj->intelligenceRate = $row["int_mutation_rate"];
            $obj->wisdomRate = $row["wis_mutation_rate"];
            $obj->sorceryRate = $row["src_mutation_rate"];
            $obj->loyaltyRate = $row["loy_mutation_rate"];
            $obj->spiritualityRate = $row["spr_mutation_rate"];
            $obj->karmaRate = $row["kar_mutation_rate"];

            $obj->constitutionDom = $row["constitution_dominant"];
            $obj->strengthDom = $row["strength_dominant"];
            $obj->agilityDom = $row["agility_dominant"];
            $obj->charmDom = $row["charm_dominant"];
            $obj->confidenceDom = $row["confidence_dominant"];
            $obj->empathyDom = $row["empathy_dominant"];
            $obj->intelligenceDom = $row["intelligence_dominant"];
            $obj->wisdomDom = $row["wisdom_dominant"];
            $obj->sorceryDom = $row["sorcery_dominant"];
            $obj->loyaltyDom = $row["loyalty_dominant"];
            $obj->spiritualityDom = $row["spirituality_dominant"];
            $obj->karmaDom = $row["karma_dominant"];

            $obj->personalityDom = $row["personality_dominant"];

            return ($obj);
        }

        public int|null $fitnessMax;
        public int|null $fitnessMin;
        public int|null $fitnessRate;

        public int|null $charismaMax;
        public int|null $charismaMin;
        public int|null $charismaRate;

        public int|null $wizardryMax;
        public int|null $wizardryMin;
        public int|null $wizardryRate;

        public int|null $natureMax;
        public int|null $natureMin;
        public int|null $natureRate;

        public int $constitutionMin;
        public int $strengthMin;
        public int $agilityMin;
        public int $charmMin;
        public int $confidenceMin;
        public int $empathyMin;
        public int $intelligenceMin;
        public int $wisdomMin;
        public int $sorceryMin;
        public int $loyaltyMin;
        public int $spiritualityMin;
        public int $karmaMin;
        public int $constitutionMax;
        public int $strengthMax;
        public int $agilityMax;
        public int $charmMax;
        public int $confidenceMax;
        public int $empathyMax;
        public int $intelligenceMax;
        public int $wisdomMax;
        public int $sorceryMax;
        public int $loyaltyMax;
        public int $spiritualityMax;
        public int $karmaMax;
        public int $constitutionRate;
        public int $strengthRate;
        public int $agilityRate;
        public int $charmRate;
        public int $confidenceRate;
        public int $empathyRate;
        public int $intelligenceRate;
        public int $wisdomRate;
        public int $sorceryRate;
        public int $loyaltyRate;
        public int $spiritualityRate;
        public int $karmaRate;
        public int $constitutionDom;
        public int $strengthDom;
        public int $agilityDom;
        public int $charmDom;
        public int $confidenceDom;
        public int $empathyDom;
        public int $intelligenceDom;
        public int $wisdomDom;
        public int $sorceryDom;
        public int $loyaltyDom;
        public int $spiritualityDom;
        public int $karmaDom;
        public int $personalityDom;
    }
}
?>