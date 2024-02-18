<?php

namespace {
    include_once __DIR__ . "/../inc/config.php";
    include_once __DIR__ . "/../modules/PetTemplate.php";
    include_once __DIR__ . "/../modules/Pet.php";
    include_once __DIR__ . "/../modules/Patreon.php";
}



namespace modules {

    use Exception;
    use modules\PetTemplate;
    use PDO;
    use PDOException;
    use modules\Pet;
    use modules\Patreon;

    class PetOwner
    {
        public int $id = 0;
        public string $avId = "";
        public string $avName = "";
        public int $food = 0;
        public int $actionPoints = 0;
        public string | null $region  = "";
        public string $coord = "";
        public string $parcelId = "";
        public string $hudVersion = "";
        public string $primUrl = "";
        public int $activityTime;
        public int $lastUpdateTime;
        public int $totalPets = 0;
        public int $apMax = 5;


        public static function getOwner(string $av) : PetOwner
        {
            // all return data will be pushed into this array
            $obj = new PetOwner ();

            try {
                $pdo = new PDO(\DB_DSN, \DB_USERNAME, \DB_PASSWORD, \DB_OPTIONS);

                $sql = 'select * from ps_avatar_info_view where avuuid = :avatar';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':avatar', $av, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $obj = PetOwner::loadFromRow ($row);

                    $obj->apMax = Patreon::getMaxApointsForAv ($av);
                }
            } catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($obj);
        }


        public static function addFoodAndAction(string $av, int $food, int $action) : int
        {

            try {
                $owner = PetOwner::getOwner($av);
                $pts = $owner->food + $food;
                if ($pts < 0)
                {
                    $food = $owner->food;
                }

                $pts = $owner->actionPoints + $action;
                if ($pts < 0)
                {
                    $action = $owner->actionPoints;
                }

                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = 'update ps_avatar_info ai set ai.food = ai.food + :food, ai.action_points = ai.action_points + :ap where ai.avuuid = :avatar';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':food', $food, PDO::PARAM_INT);
                $stmt->bindParam(':ap', $action, PDO::PARAM_INT);
                $stmt->bindParam(':avatar', $av, PDO::PARAM_STR);
                $stmt->execute();

                return ($stmt->rowCount());
            } catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        public static function addAction(string $av, int $action) : int
        {
            try {
                $owner = PetOwner::getOwner($av);
                $pts = $owner->actionPoints + $action;
                if ($pts < 0)
                {
                    $action = $owner->actionPoints;
                }

                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $pdo->beginTransaction();

                $sql = 'update ps_avatar_info ai set ai.action_points = ai.action_points + :ap where ai.avuuid = :avatar';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':ap', $action, PDO::PARAM_INT);
                $stmt->bindParam(':avatar', $av, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $pdo->commit();
                    $owner = PetOwner::getOwner($av);
                    eLog($owner->actionPoints);
                }
                return ($stmt->rowCount());
            } catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }


        public static function addLocation(string $av, string $region, string $coordinate, string $hudVersion, string $parcelId, string $url) : int
        {
            $count = 0;
            try
            {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $sql = "update ps_avatar_info set region = :region, coord = :coord, hud_version = :hudVer, parcel_id = :parcel, prim_url = :url where avuuid = :avatar";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':region', $region, PDO::PARAM_STR);
                $stmt->bindParam(':coord', $coordinate, PDO::PARAM_STR);
                $stmt->bindParam(':hudVer', $hudVersion, PDO::PARAM_STR);
                $stmt->bindParam(':parcel', $parcelId, PDO::PARAM_STR);
                $stmt->bindParam(':url', $url, PDO::PARAM_STR);
                $stmt->bindParam(':avatar', $av, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $count = $stmt->rowCount();
                }
            } catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
            return ($count);
        }


        public static function login (string $av) : PetOwner
        {
            $po = PetOwner::getOwner ($av);
            if ($po) {
                if (isSet ($po->id) && $po->id > 0) {
                    // there is an avatar info record.
                    // look at the activity date and determining if
                    // it is later than today.  If so, update the
                    // record and distribute activity points for the day

                    $cd = $po->lastUpdateTime;
                    $d1 = date ('Y-m-d', $cd);
                    $d2 = date ('Y-m-d');

                    //if ($d2 > $d1)
                    {
                        // dates are not the same, assume update
                        $pdo = null;
                        try {
                            $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                            $pdo->beginTransaction();

                            // perform a useless update to get the triggers to fire
                            // and update the timestamps
                            $sql = 'update ps_avatar_info ai set ai.activity_time = current_date where ai.avuuid = :avatar';
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':avatar', $av, PDO::PARAM_STR);
                            $stmt->execute();

                            $pdo->commit ();
                        }
                        catch (PDOException $e) {
                            if ($pdo) $pdo->rollBack();
                            eLog ($e->getMessage() . ', code = ' . $e->getCode());
                            throw new PDOException($e->getMessage(), (int)$e->getCode());
                        }
                    }
                }
                else {

                    $pdo = null;
                    try {
                        $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                        $pdo->beginTransaction();

                        $food = 100;
                        $aPoints = Patreon::getMaxApointsForAv ($av);

                        // insert a basic avatar record
                        $sql = 'insert into ps_avatar_info (avuuid, action_points, food) values (:avatar, :ap, :food)';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':avatar', $av, PDO::PARAM_STR);
                        $stmt->bindParam(':ap', $aPoints, PDO::PARAM_INT);
                        $stmt->bindParam(':food', $food, PDO::PARAM_INT);
                        $stmt->execute();

                        // perform a useless update to get the triggers to fire
                        // and update the timestamps
                        $sql = 'update ps_avatar_info ai set ai.activity_time = current_date where ai.avuuid = :avatar';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':avatar', $av, PDO::PARAM_STR);
                        $stmt->execute();
                        $pdo->commit();
                        $po = PetOwner::getOwner($av);
                    }
                    catch (PDOException $e) {
                        if ($pdo) $pdo->rollBack();
                        eLog ($e->getMessage() . ', code = ' . $e->getCode());
                        throw new PDOException($e->getMessage(), (int)$e->getCode());
                    }
                }


                if (isset ($po->avId)) {
                    // create 1st pet is needed.
                    $pet = new Pet ();
                    $cnt = Pet::getPetCountForOwner($po->avId, 'none');
                    if ($cnt <= 0) {
                        $petTemplate = PetTemplate::getPetTemplate("Bryony");
                        if ($petTemplate) {
                            $pet = Pet::cloneFromTemplate($petTemplate, "Common",  $av);

                        }
                    } else {
                        $pet = Pet::getFirstPetByOwner($av, 'none');
                    }

                    // save pet into the session
                    $_SESSION['pet'] = $pet;
                }
                else {
                    throw new Exception ('could not instantiate PetOwner object.');
                }
            }

            return ($po);
        }



        public static function saveOwner(PetOwner $owner) : PetOwner
        {
            $result = $owner;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                $pdo->beginTransaction();

                $owner = PetOwner::fixupStats ($owner);

                $sql = 'update ps_avatar_info 
                    set avname = :avName, food = :food, action_points = :actionPts, region = :region, coord = :coord, hud_version = :hudVer, parcel_id = :parcel, prim_url = :url 
                    where  avuuid = :avId';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':avId', $owner->avId, PDO::PARAM_STR);
                $stmt->bindParam(':avName', $owner->avName, PDO::PARAM_STR);
                $stmt->bindParam(':food', $owner->food, PDO::PARAM_INT);
                $stmt->bindParam(':actionPts', $owner->actionPoints, PDO::PARAM_INT);
                $stmt->bindParam(':region', $owner->region, PDO::PARAM_STR);
                $stmt->bindParam(':coord', $owner->coord, PDO::PARAM_STR);
                $stmt->bindParam(':hudVer', $owner->hudVersion, PDO::PARAM_STR);
                $stmt->bindParam(':parcel', $owner->parcelId, PDO::PARAM_STR);
                $stmt->bindParam(':url', $owner->primUrl, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    if ($pdo->commit()) {
                        $result = PetOwner::getOwner($owner->avId);
                    }
                }
            } catch (PDOException $e) {
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($result);
        }



        public static function getPetList (string $avId, int $pageNum, string $attrib) : array
        {
            $result = [];
            $pdo = null;
            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

                $limitValue = PETS_PER_PAGE;
                $offsetValue = ($pageNum * PETS_PER_PAGE);
                $sql = null;
                if ($attrib === 'none') {
                    $sql = 'select pp.id as id, p.id as pet_id, p.texture, pp.pet_number, pp.health from ps_player_pet_view pp inner join ps_pet p on  pp.pet_id = p.id where pp.avuuid = :avatar order by pp.pet_number limit :offset, :limit';
                }
                else {
                    $sql = 'select pp.id as id, p.id as pet_id, p.texture, pp.pet_number, pp.health from ps_player_pet_view pp inner join ps_pet p on  pp.pet_id = p.id where pp.avuuid = :avatar and pp.attribute = :attr order by pp.pet_number limit :offset, :limit';
                }
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':avatar', $avId, PDO::PARAM_STR);
                if ($attrib !== 'none') {
                    $stmt->bindParam(':attr', $attrib, PDO::PARAM_STR);
                }
                $stmt->bindParam(':limit', $limitValue, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offsetValue, PDO::PARAM_INT);
                $stmt->execute();
                $count = $stmt->rowCount();

                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION["page_total"] = $count;

                while ($row = $stmt->fetch()) {
                    array_push($result, array ("id"=>$row["id"], "pet_id"=>$row["pet_id"], "pet_number"=>$row["pet_number"], "texture"=>$row["texture"], "health"=>$row["health"]));
                }
            }
            catch (PDOException $e) {
                if ($pdo) $pdo->rollBack();
                eLog ($e->getMessage() . ', code = ' . $e->getCode());
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            return ($result);
        }


        private static function loadFromRow (array $row) : PetOwner
        {
            $obj = new PetOwner();

            $obj->id = $row["id"];
            $obj->avId = $row["avuuid"];
            $obj->avName = ($row["avname"]) ? ($row["avname"]) : ('');
            $obj->food = $row['food'];
            $obj->actionPoints = $row['action_points'];
            $obj->region = ($row['region']) ? ($row['region']) : ('');
            $obj->coord = ($row['coord']) ? ($row['coord']) : ('');
            $obj->parcelId = ($row['parcel_id']) ? ($row['parcel_id']) : ('');
            $obj->hudVersion = ($row['hud_version']) ? ($row['hud_version']) : ('');
            $obj->primUrl = ($row['prim_url']) ? ($row['prim_url']) : ('');
            $obj->activityTime = strtotime ($row['activity_time']);
            $obj->lastUpdateTime = strtotime ($row['update_time']);
            $obj->totalPets = $row['total_pets'];

            return ($obj);
        }


        public static function fixupStats (PetOwner $owner) : PetOwner
        {
            if ($owner->food < 0)  $owner->food = 0;
            if ($owner->actionPoints < 0)  $owner->actionPoints = 0;

            return ($owner);
        }
    }
}

?>