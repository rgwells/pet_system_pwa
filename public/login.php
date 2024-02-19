<?php

use server\modules\PetOwner;
use server\modules\SessionData;

include_once __DIR__ . "/../server/inc/config.php";
include_once __DIR__ . "/../server/modules/PetOwner.php";
include_once __DIR__ . "/../server/modules/Pet.php";

list ($success, $uuid, $name, $url, $error, $altLogin) = SessionData::getValidSessionData();
error_log("login called " . $uuid . ", " . $name . ", " . $url);

if ($success) {
    session_start();
    $_SESSION['avId'] = $uuid;
    $_SESSION['avName'] = $name;
	$_SESSION['prim_url'] = $url;
	$owner = PetOwner::login ($uuid);
	$owner->primUrl = $url;
	$owner->avName = $name;
	$owner = PetOwner::saveOwner($owner);

    $_SESSION['owner'] = $owner;
	$_SESSION['attrib_filter'] = 'none';

	// page controls
    $_SESSION['page_total'] = $owner->totalPets;
    $_SESSION['page_offset'] = 0;
    $_SESSION['page_page'] = 0;

	// Screen and button data
	$_SESSION["activeScreen"] = 'none';
    $_SESSION["activeButton"] = 'none';

	// Food information
    $_SESSION["foodName"] = 'none';

	// training information
	$_SESSION["trainName"] = 'none';

    $_SESSION['quest_choice'] = 'none';

	// wild Pet
	$_SESSION ["wildPet"] = '';

} else {
    showError(
	"Authentication Error",
	 "You have been logged out.",
	"The link you followed is invalid, or it may have expired.<br/>Please get a new link in-world." . $error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>

	<script>

        let altLogin = '<?php echo $altLogin?>';

        if (altLogin === "1")
        {
            window.location.replace ('index.html');
		}
        else
        {
            // similar behavior as an HTTP redirect
            window.location.replace('index.php');
        }

	</script>
</head>
<body>

</body>
</html>

<?php
	die();
?>