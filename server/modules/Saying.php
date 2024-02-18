<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace modules {

    use PDO;
    use PDOException;

    class Saying
    {
        public static function getOwner(int $id) : Saying
        {
            // all return data will be pushed into this array
            $obj = new Saying ();

            try {
                $pdo = new PDO(\DB_DSN, \DB_USERNAME, \DB_PASSWORD, \DB_OPTIONS);

                $sql = 'select * from ps_sayings where id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $obj = Saying::loadFromRow ($row);
                }
            } catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }



        public static function getRandomSaying (string $category) : Saying
        {
            $obj = new Saying ();
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $sql = 'select * from ps_sayings where category = :category order by id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':category', $category, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $count = $stmt->rowCount();
                    if ($count >= 1) {
                        $temp = random_int(0, $stmt->rowCount() - 1);
                        $i = 0;
                        while ($row = $stmt->fetch()) {
                            if ($i == $temp) {
                                $obj = Saying::loadFromRow($row);
                                return ($obj);
                            }
                            $i++;
                        }
                    }
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
            }
            return ($obj);
        }



        public static function getCountByCategory (string $category) : int
        {
            $count = 0;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = 'select count(*) as count from ps_sayings where caregory = :category';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':category', $category, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $count = $row['count'];
                }
            }
            catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
            }
            return ($count);
        }


        private static function loadFromRow (array $row) : Saying
        {
            $obj = new Saying();

            $obj->id = $row["id"];
            $obj->category = $row["category"];
            $obj->text = $row['text'];
            $obj->emoticon = $row['emoticon'];

            return ($obj);
        }


        public int $id = 0;
        public string $category = "";
        public string $text = "";
        public string $emoticon = "";
    }
}

?>