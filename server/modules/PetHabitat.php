<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace server\modules {


    use PDO;
    use PDOException;

    class PetHabitat
    {
        public static function getHabitatByAttribute(string $attrib): array
        {
            // all return data will be pushed into this array
            $result = [];

            try {
                $pdo = new PDO(\DB_DSN, \DB_USERNAME, \DB_PASSWORD, \DB_OPTIONS);

                $sql = 'select * from ps_attribute_habitat where attribute = :attrib';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':attrib', $attrib, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch()) {
                        $obj = new PetHabitat();
                        $obj->id = $row["id"];
                        $obj->attribute = $row["attribute"];
                        $obj->habitat = $row['habitat'];
                        array_push($result, $obj);
                    }
                }
            } catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($result);
        }

        public static function getRandomHabitat (string $attributeName) : string
        {
            $h = null;
            while ($h == null) {
                $habitats = PetHabitat::getHabitatByAttribute($attributeName);
                $temp = random_int(0, (count($habitats) - 1));
                $h = $habitats[$temp];
                if ($h->habitat == null) {
                    $h = null;
                }
            }
            return ($h->habitat);
        }



        public int $id;
        public string $attribute;
        public string $habitat;
    }
}
?>