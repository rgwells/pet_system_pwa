<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace modules {

    use PDO;
    use PDOException;

    class PetTemplate
    {
        function __construct()
        {
            $this->id = 0;
            $this->species = "";
            $this->ownerType  = "";
            $this->texture  = "";
            $this->faceTexture = "";
            $this->color  = "";
            $this->grade  = "";
            $this->attributeName = "";
            $this->attributeTexture = "";
        }


        public static function getPetTemplate(string $species): PetTemplate
        {
            // all return data will be pushed into this array
            $obj = new PetTemplate ();

            try {
                $pdo = new PDO(\DB_DSN, \DB_USERNAME, \DB_PASSWORD, \DB_OPTIONS);

                $sql = 'select * from ps_pet where species = :species';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':species', $species, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $obj->id = $row["id"];
                    $obj->species = $row["species"];
                    $obj->ownerType = $row['owner_type'];
                    $obj->texture = $row['texture'];
                    $obj->faceTexture = $row['face_texture'];
                    $obj->color = $row['color'];
                    $obj->grade = $row['grade'];
                    $obj->attributeName = $row['attribute_name'];
                    $obj->attributeTexture = $row['attribute_texture'];
                }
            } catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }

        public int $id = 0;
        public string $species = "";
        public string $ownerType  = "";
        public string $texture  = "";
        public string $faceTexture = "";
        public string $color  = "";
        public string $grade  = "";
        public string $attributeName = "";
        public string $attributeTexture = "";
    }
}
?>