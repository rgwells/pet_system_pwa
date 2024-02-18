<?php
namespace {
    include_once __DIR__ . "/../inc/config.php";
}

namespace modules {

    use PDO;
    use PDOException;

    class PetActivity
    {
        public static function addActivity (int $petId, string $activity) : bool
        {
            $result = false;
            $pdo = null;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $pdo->beginTransaction();

                $sql = 'insert into ps_pet_activity (pet_id, activity) values (:petId, :activity)';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':petId', $petId, PDO::PARAM_INT);
                $stmt->bindParam(':activity', $activity, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $count = $stmt->rowCount();
                    $id = $pdo->lastInsertId();
                    if ($pdo->commit()) {
                        $result = ($count == 1);
                    }
                }
            } catch (PDOException $e) {
                if (! is_null ($pdo)) {
                    $pdo->rollBack();
                }
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($result);
        }


        public static function getActivity (int $id) : PetActivity
        {
            $obj = new PetActivity();

            try {
                $pdo = new PDO(\DB_DSN, \DB_USERNAME, \DB_PASSWORD, \DB_OPTIONS);

                $sql = 'select * from ps_pet_activity where id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        $row = $stmt->fetch();

                        $obj->id = $row["id"];
                        $obj->petId = $row["pet_id"];
                        $obj->activity = $row['activity'];
                        $obj->activityDate = strtotime($row['activity_date']);
                    }
                }
            } catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }



        public static function getActivityByPet(int $id, int $limit, int $offset) : array
        {
            $result = [];

            try {
                $pdo = new PDO(\DB_DSN, \DB_USERNAME, \DB_PASSWORD, \DB_OPTIONS);

                $sql = 'select * from ps_pet_activity where pet_id = :id order by pet_id limit :offset, :limit';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    while ($row = $stmt->fetch()) {

                        $obj = new PetActivity();

                        $obj->id = $row["id"];
                        $obj->petId = $row["pet_id"];
                        $obj->activity = $row['activity'];
                        $obj->activityDate = strtotime($row['activity_date']);

                        array_push($result, $obj);
                    }
                }
            } catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($result);
        }


        public int $id;
        public int $petId;
        public string $activity;
        public int $activityDate;
    }
}

?>