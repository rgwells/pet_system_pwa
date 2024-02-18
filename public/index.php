<?php

use modules\SessionData;
include_once __DIR__ . "/../modules/SessionData.php";
include_once __DIR__ . "/../modules/Pet.php";
include_once __DIR__ . "/../modules/PetOwner.php";
include_once __DIR__ . "/../modules/Food.php";
include_once __DIR__ . "/../modules/Train.php";
include_once __DIR__ . "/../modules/Saying.php";

use modules\PetOwner;
use modules\Food;
use modules\Train;

SessionData::getSessionData();

$avName = $_SESSION['avName'];
$owner = PetOwner::getOwner($_SESSION['avId']);
$page = $_SESSION['page_page'];
$attribFilter = $_SESSION["attrib_filter"];
$primUrl = $_SESSION["prim_url"];

// NOTE:  if an attribute filter is set, then it can change the page,
// so reload it after getting the pet list
$petList = PetOwner::getPetList($owner->avId, $page, $attribFilter);
$foodInfo = Food::getFoodList();
$trainInfo = Train::getTrainList ();

$pet = $_SESSION["pet"];
$wildPet = $_SESSION["wildPet"];
$pageOffset = $_SESSION['page_offset'];
$pageTotal = $_SESSION['page_total'];
$page = $_SESSION['page_page'];

// load the currently active screen and button information.
$state = $_SESSION["activeScreen"];
$activeButton = $_SESSION["activeButton"];

// Bootstrap the food and training functions
$foodName = $_SESSION['foodName'];
$trainName = $_SESSION['trainName'];

$questChoiceName =  $_SESSION['quest_choice'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Milonga&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
	<script src="js/typewriter.js"></script>
	<script src="js/random_utility.js"></script>
    <title>Pandemon</title>

	<script>

		let healthColors = { };

        let screenInfo = [
            {name: "profile", ids: ['petmenu-profile']},
            {name: "stats", ids: ['petmenu-stats', 'modal-stats-fitness', 'modal-stats-wizardry', 'modal-stats-charisma', 'modal-stats-nature']},
            {name: "health", ids: ['petmenu-health', 'petmenu-release', 'petmenu-release-error']},
            {name: "action", ids: ['petmenu-action', 'petmenu-action-scene']},
            {name: "train", ids: ['globalmenu-training1', 'globalmenu-training2', 'globalmenu-training3', 'globalmenu-training4', 'globalmenu-training5', 'globalmenu-qchoice', 'globalmenu-qdialogue']},
            {name: "forage", ids: ['globalmenu-foraging1', 'globalmenu-foraging2', 'globalmenu-foraging3', 'globalmenu-foraging4', 'globalmenu-foraging5', 'globalmenu-qchoice', 'globalmenu-qdialogue']},
            {name: "rest", ids: ['globalmenu-rest1', 'globalmenu-rest2', 'globalmenu-qchoice', 'globalmenu-qdialogue']},
            {name: "quest", ids: ['globalmenu-qopening1', 'globalmenu-qchoice', 'globalmenu-qdialogue', 'globalmenu-qerror', 'pet-face', 'pet-emoticon', 'qchoice-choices4', 'qchoice-choices3', 'qchoice-choices2']}
        ];


        // list of all control and their active images.
        let buttonData = [
            ["pm-profile", "img/pet-menu/petmenu-profile.webp", "img/pet-menu/petmenu-profile-active.webp"],
            ["pm-stats", "img/pet-menu/petmenu-stats.webp", "img/pet-menu/petmenu-stats-active.webp"],
            ["pm-health", "img/pet-menu/petmenu-health.webp", "img/pet-menu/petmenu-health-active.webp"],
            ["pm-action", "img/pet-menu/petmenu-action.webp", "img/pet-menu/petmenu-action-active.webp"],

            ["adv_train", "img/global-button/button-train.webp", "img/global-button/button-train-active.webp"],
            ["adv_quest", "img/global-button/button-quest.webp", "img/global-button/button-quest-active.webp"],
            ["chore_forage", "img/global-button/button-forage.webp", "img/global-button/button-forage-active.webp"],
            ["chore_rest", "img/global-button/button-rest.webp", "img/global-button/button-rest-active.webp"],
        ];


        let emote2Name = {
            "%CONFIDENT%": "img\\global-expression\\expression-confident.webp",
            "%CRITICAL%": "img\\global-expression\\expression-critical.webp",
            "%DISAPPOINTED%": "img\\global-expression\\expression-disappointed.webp",
			"%EXCITED%": "img\\global-expression\\expression-excited.webp",
			"%HAPPY%": "img\\global-expression\\expression-happy.webp",
			"%NERVOUS%": "img\\global-expression\\expression-nervous.webp",
			"%SICK%": "img\\global-expression\\expression-sick.webp",
			"%SURPRISED%": "img\\global-expression\\expression-surprised.webp",
			"%TIRED%": "img\\global-expression\\expression-tired.webp",
        };

        appVersion = '1.0.0.125';

        let typewriterSpeed = 120;
        let typewriterRepeat = false;
        let typewriterDelay = 500;

        let MAX_PLAYER_PETS = 8;

        let food = {};
        let train = {};
        let quest = {};
        let oldPet = {};
        let oldOwner = {};
        let accumStat = {
            constitution: 0,
			strength: 0,
			agility: 0,
			charm: 0,
			confidence: 0,
			empathy: 0,
			intelligence: 0,
			wisdom: 0,
            sorcery: 0,
			loyalty: 0,
			spirituality: 0,
			karma: 0,
			food: 0,
			fatigue: 0
		};
        let questChoice = {};
        let statTest = {};
        let statCost = {};
        let typeWriter = null;
        let timerId;
        let questInfo = { category: "" };

		let pet = <?php echo json_encode($pet)?>;
        let wildPet = <?php echo json_encode($wildPet)?>;
        let owner = <?php echo json_encode($owner)?>;
        let petList = <?php echo json_encode($petList)?>;
        let state = '<?php echo $state?>';
        let activeButton = '<?php echo $activeButton?>';
        let activeMenu = "none";
        let foodName = '<?php echo $foodName?>';
        food = getFoodDetail(foodName);
        let trainName = '<?php echo $trainName?>';
        train = getTrainDetail (trainName);
        let habitat = {};
		//console.log ("food: " + food.type + ", train: " + train.type);

        let petTotal = <?php echo $owner->totalPets?>;
        let pageOffset = <?php echo $pageOffset?>;
        let pageTotal = <?php echo $pageTotal?>;
        let pageIndex = <?php echo $page?>;
		let PETS_PET_PAGE = <?php echo PETS_PER_PAGE?>;

        let questChoiceName = '<?php echo $questChoiceName?>';
        //alert (questChoiceName);

		//alert ("page " + pageIndex + "\n" +
        //    "page total " + pageTotal + "\n" +
        //    "pet total " + petTotal + "\n" +
        //    "offset " + pageOffset + "\n"
        //);

        //alert (JSON.stringify (petList));

        let modalDialog;
        let closeModalBtn;

        function loadContext ()
        {
			// initialize health colors
            healthColors.Healthy = getComputedStyle (document.querySelector('.c-healthy')).color;
            healthColors.Tired = getComputedStyle (document.querySelector('.c-tired')).color;
            healthColors["Run Down"] = getComputedStyle (document.querySelector('.c-rundown')).color;
            healthColors.Sick = getComputedStyle (document.querySelector('.c-sick')).color;
            healthColors.Critical = getComputedStyle (document.querySelector('.c-critical')).color;
            healthColors.Dead = getComputedStyle (document.querySelector('.c-dead')).color;

            modalDialog = document.getElementById("modal_dialog");
            closeModalBtn = document.getElementById("modal_dialog_close_btn");


			// toggle the button state to active to the
			// active button, indicated by "activeButton"
			if (activeButton !== 'none')
            {
                //alert ("button : " + activeButton);
                let e = document.getElementById(activeButton);
                if (activeButton === 'pm-profile')  e.src = "img/pet-menu/petmenu-profile-active.webp";
                else if (activeButton === 'pm-stats')  e.src = "img/pet-menu/petmenu-stats-active.webp";
                else if (activeButton === 'pm-health')  e.src = "img/pet-menu/petmenu-health-active.webp";
                else if (activeButton === 'pm-action')  e.src = "img/pet-menu/petmenu-action-active.webp";
                else if (activeButton === 'adv_train')  e.src = "img/global-button/button-train-active.webp";
                //else if (activeButton === 'adv_quest')  e.src = "img/global-button/button-quest-active.webp";
                else if (activeButton === 'chore_forage')  e.src = "img/global-button/button-forage-active.webp";
                else if (activeButton === 'chore_rest')  e.src = "img/global-button/button-rest-active.webp";
			}

			// HACK
			if (state === 'globalmenu-qchoice')
            {
                setStateInfo('none');
                setButtonInfo ('none');
                document.getElementById('qchoice-p1').setAttribute("hidden", "");
			}


            if (state !== 'none')
            {
                // what is the active screen that should be showing
            	document.getElementById(state).removeAttribute("hidden");

                // look at where the pet portrait should be hidden
                if ((state === 'globalmenu-foraging1') ||
                    (state === 'globalmenu-foraging2') ||
                    (state === 'globalmenu-foraging3') ||
                    (state === 'globalmenu-foraging4') ||
                    (state === 'globalmenu-foraging5') ||
                    (state === 'globalmenu-training1') ||
                    (state === 'globalmenu-training2') ||
                    (state === 'globalmenu-training3') ||
                    (state === 'globalmenu-training4') ||
                    (state === 'globalmenu-training5') ||
                    (state === 'globalmenu-rest1'))
                {
                    // hide pet portrait
                    document.getElementById('pet-portrait-texture').src = '';
                    if (state === 'globalmenu-rest1')
                    {
                        document.getElementById('pet-portrait-texture').src = 'img/global-menu/rest-sleeping.webp';
                    }
                }
			}


			// Load training if we have any open.
    		if (trainName !== 'none')
            {
                let html = `<p class="c-price">Price ${Math.abs(train.cost)} Food<p>`;
                html += `<br/>`;
                html += `<p class="c-plus">${getUnAdjustedObject(train, 'pos')}</p>`;
                html += `<p class="c-minus">${getUnAdjustedObject(train, 'neg')}</p>`;
                html += `<p class="c-fatigue">${getUnAdjustedObject(train, 'fatigue')}</p>`;

                let e = document.getElementById('train2-traininfo');
                e.innerHTML = html;

                e = document.getElementById('globalmenu-training2-texture');
                e.src = `${train.texture}`;

                e = document.getElementById('globalmenu-training2-name');
                e.innerHTML = train.type;
            }

			// Load food data if any is needed.
            if (foodName !== 'none')
            {
                let factor = pet.confidence / 10;
                if (! factor)   factor = 1;
                let cost = Math.floor (food.cost + factor);
                food.cost = cost;


                let html = `<p class="c-price">Acquires ${cost} Food<p>`;
                html += `<br/>`;
                html += `<p class="c-plus">${getUnAdjustedObject(food, 'pos')}</p>`;
                html += `<p class="c-minus">${getUnAdjustedObject(food, 'neg')}</p>`;
                html += `<p class="c-fatigue">${getUnAdjustedObject(food, 'fatigue')}</p>`

                let e = document.getElementById('forage2-foodinfo');
                e.innerHTML = html;

                e = document.getElementById('forage2_food_image');
                e.src = food.texture;

                e = document.getElementById('foraging2-foodname');
                e.innerHTML = food.type;
            }

            // update the pet selection part of the screen
            updatePetSelector ();

            // if no screens are showing then the default pet screen is up.
            // get and show a random saying
            if ((state === 'none') && (activeButton !== 'none'))
            {
                setTimeout(function ()
                {
                    getSaying(pet);
                }, 2000);
            }
		}


        function openModal ()
        {
            //console.log ("open dialog");

            document.getElementById("modal_dialog_text").innerHTML = 'Close this window? You are not done yet.<br/>(No refunds for already spent AP or Food)';

            modalDialog.style.display = 'block';
            modalDialog.removeAttribute("hidden");
		}

        function closeModal ()
        {
            //console.log ("close dialog");
            modalDialog.style.display = 'none';
		    modalDialog.setAttribute("hidden", "");
		}


        function processModal (flag)
        {
            if (flag)
            {
                //console.log ("shutdown here: " + state + ", " + activeButton);

                document.getElementById(state).setAttribute("hidden", "");
                document.getElementById('globalmenu-training5').setAttribute("hidden", "");

                document.getElementById('pet-portrait-texture').src = `${pet.texture}`;

                toggleButtonImageOff ('chore_forage', 'img/global-button/button-forage.webp');
                toggleButtonImageOff ('chore_rest', 'img/global-button/button-rest.webp');
                toggleButtonImageOff ('adv_train', 'img/global-button/button-train.webp');
                toggleButtonImageOff ('adv_quest', 'img/global-button/button-quest.webp');
                showEmoticon ("");
                showPetFace ("");

                setStateInfo ("none");
                setButtonInfo("none");
			}

        	closeModal ();
		}


        function toggleButtonImageOff (activeButtonId, inActiveButtonImg)
		{
            let e = document.getElementById (activeButtonId);
            e.setAttribute ("src", inActiveButtonImg);
		}



        function toggleButtonImage (menuName, activeButtonId, screenId, inActiveButtonImg, activeButtonImg)
        {
            //console.log ("state: " + state + ", button: " + activeButton);
            //console.log ("menu: " + menuName + ", button: " + activeButtonId + ", screen: " + screenId);

            // save off the active button, if any
            let oldActiveButtonId = "";
            for (let i = 0; i < buttonData.length; i++)
            {
                let aid = buttonData[i][0];
                let e = document.getElementById(aid);
                // alert (aid + ", " + e.getAttribute("src"));
                if (buttonData[i][2] === e.getAttribute("src"))
                {
                    oldActiveButtonId = aid;
				}
            }

            let ok = false;
            if ((oldActiveButtonId === 'adv_quest') ||
                (oldActiveButtonId === 'adv_train') ||
                (oldActiveButtonId === 'chore_forage') ||
                (oldActiveButtonId === 'chore_rest'))
            {
                if ((oldActiveButtonId === "") || (activeButtonId === oldActiveButtonId))
                {
                    ok = true;
                    //console.log ('toggle same button');
					openModal();
					return;
				}
			}
            else
            {
                ok = true;
			}

            let active = false;
            if (ok)
            {
                // hide all the screens that might be showing
                for (let i = 0; i < screenInfo.length; i++)
                {
                    for (let j = 0; j < screenInfo[i].ids.length; j++)
                    {
                        let value = screenInfo[i].ids[j];
                        //console.log (value);
                        let e = document.getElementById(value);

                        // HACK handle the modal
						if ((value === 'modal-stats-fitness') ||
                            (value === 'modal-stats-wizardry') ||
                            (value === 'modal-stats-charisma') ||
                            (value === 'modal-stats-nature'))
                        {
                            e.style.display = 'none';
						}
                        else if (e)
                        {
                            e.setAttribute("hidden", "1");
                        }
                    }
                }
				//console.log ("hide pet msg");
                document.getElementById('pet-portrait-msg').setAttribute("hidden", "");
                showEmoticon("none");
                showPetFace ("none");

                //let active = false;
                // set the toggle buttons to inactive.
                for (let i = 0; i < buttonData.length; i++)
                {
                    let aid = buttonData[i][0];
                    if (activeButtonId !== aid)
                    {
                        let e = document.getElementById(aid);
                        let name = buttonData[i][1];
                        // alert (name);
                        e.setAttribute("src", name);
                    }
                }


                // toggle on the button image
                let e = document.getElementById(activeButtonId);
                let temp = e.getAttribute('src');
                if (temp === inActiveButtonImg)
                {
                    // alert ("active image " + temp);
                    active = true;
                    e.setAttribute("src", activeButtonImg);
                }
                else
                {
                    document.getElementById('pet-portrait-texture').src = `${pet.texture}`;
                    setPetPortraitFilter(pet);
                    e.setAttribute("src", inActiveButtonImg);
                }

                // show the screen needed if any
                // alert ("elem" + screenId + "," + e + ", " + active);
                e = document.getElementById(screenId);
                if (e)
                {
                    if (active)
                    {
                        if ((screenId === 'globalmenu-foraging1') ||
                            (screenId === 'globalmenu-foraging2') ||
                            (screenId === 'globalmenu-foraging3') ||
                            (screenId === 'globalmenu-foraging4') ||
                            (screenId === 'globalmenu-foraging5') ||
                            (screenId === 'globalmenu-training1') ||
                            (screenId === 'globalmenu-training2') ||
                            (screenId === 'globalmenu-training3') ||
                            (screenId === 'globalmenu-training4') ||
                            (screenId === 'globalmenu-training5') ||
                            (screenId === 'globalmenu-rest1') ||
                            (screenId === 'globalmenu-qopening1') ||
                            (screenId === 'globalmenu-qchoice') ||
                            (screenId === 'globalmenu-qdialogue'))
                        {
                            document.getElementById('pet-portrait-texture').src = '';
                            if (screenId === 'globalmenu-rest1')
                            {
                                document.getElementById('pet-portrait-texture').src = 'img/global-menu/rest-sleeping.webp';
                                document.getElementById('pet-portrait-texture').setAttribute("style", '');
                            }
                        }
                        else
                        {
                            document.getElementById('pet-portrait-texture').src = `${pet.texture}`;
                            document.getElementById('pet-portrait-texture').setAttribute("style", '');
                        }

                        e.removeAttribute("hidden");
                        setStateInfo(screenId);
                        setButtonInfo (activeButtonId);
                        activeMenu = menuName;
                    }
                    else
                    {
                        e.setAttribute("hidden", "1");
                        setStateInfo('none');
                        setButtonInfo ('none');
                        activeMenu = 'none';
                    }
                }
            }
        }


        function stopTypewriter ()
        {
            if (typeWriter)
            {
                typeWriter.stop();
                typeWriter = null;
            }
        }

        function setStateInfo (stateName)
        {
            state = stateName;
            setSessionInfo ('state', 'screen', stateName);
        }

        function setButtonInfo (buttonName)
        {
            activeButton = buttonName;
            setSessionInfo ('button', 'name', buttonName);
        }

        function setFoodInfo (name)
        {
            foodName = name;
            setSessionInfo ('food', 'name', name);
		}

        function setTrainInfo (name)
        {
            trainName = name;
            setSessionInfo ('train', 'name', name);
        }

        function setQuestInfo (name)
        {
            setSessionInfo ('quest', 'choice', name);
        }

        function setSessionInfo (typeName, keyName, valueName)
        {
            let xhr = new XMLHttpRequest ();

            // setup host name and the rest of the url by building parts
            // and replacing others.
            let host = location.protocol.concat("//").concat(window.location.host);
            let path = window.location.pathname;
            path = path.replace("public/index.php", "");
            path = path + "api/state.php";
            let url = host + path + `?type=${typeName}&${keyName}=` + valueName;

            xhr.open ('GET', url);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.send ();
		}



        function setPetPortraitFilter (thePet) {

            if (thePet?.health === 'Dead')
            {
                document.getElementById('pet-portrait-texture').setAttribute("style", "filter:none;-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);");
            }
            else
            {
                document.getElementById('pet-portrait-texture').setAttribute("style", '');
            }
		}


        function saveFood (foodAmt)
        {
            //console.log ("save food: " + foodAmt);
            let xhr = new XMLHttpRequest ();

            // setup host name and the rest of the url by building parts
            // and replacing others.
            let host = location.protocol.concat("//").concat(window.location.host);
            let path = window.location.pathname;
            path = path.replace("public/index.php", "");
            path = path + "api/owner_data.php";
            let url = host + path;

            let data = {
                type: 'save_food',
                food: foodAmt,
            };

            xhr.open ('POST', url);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.send (JSON.stringify (data));
            xhr.onreadystatechange = function ()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    // alert (this.responseText);
                    owner = JSON.parse(this.responseText);
                    loadOwnerData();
                }
            }

        }


        function saveActivity (thePet, theActivity)
        {
            // apply the new stats x healthFactor
            let data = {
                type: 'save_activity',
                petId: thePet.id,
                activity: theActivity,
            };

            let xhr = new XMLHttpRequest();
            let host = location.protocol.concat("//").concat(window.location.host);
            let path = window.location.pathname;
            path = path.replace("public/index.php", "");
            path = path + "api/pet_data.php";
            let url = host + path;
            xhr.open ('POST', url);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.send (JSON.stringify (data));
		}

        function savePet (thePet)
        {
            thePet.type = "save_pet_owner";
            let xhr = new XMLHttpRequest();
            let host = location.protocol.concat("//").concat(window.location.host);
            let path = window.location.pathname;
            path = path.replace("public/index.php", "");
            path = path + "api/pet_data.php";
            let url = host + path;
            xhr.open ('POST', url);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.send (JSON.stringify (thePet));

            xhr.onreadystatechange = function ()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    let a = JSON.parse(this.responseText);
                    //alert (JSON.stringify(a[1], null, 2));
                    //alert (a.length);

                    let ok = a[0];
                    if (ok)
                    {
                        pet = a[0];
                        loadPetData();
                    }

                    ok = a[1];
                    if (ok)
                    {
	                    //console.log (a[i]);
                    	owner = a[1];
                    	loadOwnerData();
					}
                }
            }
        }


        function getSaying (thePet)
        {
            if (activeButton === 'none')
            {
				// determine the category for the saying to retrieve
				// the category is the personality of the pet OR
				// the pet's health if it is unhealthy.
                let catagory = thePet.personality;
                if (thePet.health !== "Healthy")
                {
                    catagory = thePet.health;
                }

                let xhr = new XMLHttpRequest();

                // setup host name and the rest of the url by building parts
                // and replacing others.
                let host = location.protocol.concat("//").concat(window.location.host);
                let path = window.location.pathname;
                path = path.replace("public/index.php", "");
                path = path + "api/pet_data.php";
                let url = host + path + "?type=get_saying&category=" + catagory;

                xhr.open('GET', url);
                xhr.setRequestHeader("Content-type", "application/json");
                xhr.send();
                xhr.onreadystatechange = function ()
                {
                    if (this.readyState === 4 && this.status === 200)
                    {
                        //alert (this.responseText);
                        let obj = JSON.parse(this.responseText);
                        let msg = obj.text.trim();
                        let emote = obj.emoticon;
                        let face = obj.faceImg;
                        if (msg.length > 0)
                        {
                            let e = document.getElementById('pet-portrait-msg');

                            showEmoticon(emote);
                            showPetFace (face);
                            showPetFace (questChoice.faceImg);
                            stopTypewriter();

                            if ((thePet.health === 'Critical') ||
                                (thePet.health === 'Sick') ||
                                (thePet.health === 'Run Down') ||
                                (thePet.health === 'Dead'))
                            {
                                e.classList.remove("c-white");
                                e.classList.add("c-notwell");
                            }
                            else
                            {
                                e.classList.remove("c-notwell");
                                e.classList.add("c-white");
                            }

                            e.innerHTML = "";
                            e.setAttribute("data-typewriter", "");

                            msg = msg.replace("%PET_NAME%", pet.species);
                            e.setAttribute("data-typewriter", msg);

                            typeWriter = new Typewriter(e, {
                                speed: typewriterSpeed,
                                repeat: typewriterRepeat,
                                delay: typewriterDelay
                            });
                            //console.log ("show pet msg.");
                            e.removeAttribute("hidden");
                        }
                    }
                }

                if (timerId)
                {
                    //console.log ("cancel timer " + timerId);
                    clearTimeout(timerId);
                    timerId = null;
                }

                timerId = setTimeout(() =>
                {
                    document.getElementById('pet-portrait-msg').setAttribute("hidden", "");
                    showEmoticon('none');
                    showPetFace ('none');
                    timerId = null;
                }, 30000);
            }
		}



        // ----------------------------------------------------------------------------
		// Release Pet support
		function showReleasePet (hideId, showId)
        {
            document.getElementById(hideId).setAttribute("hidden", "1");

            if (owner.totalPets <= 1)
            {
             	document.getElementById('petmenu-release-error').removeAttribute('hidden');
			}
            else
            {
                document.getElementById(showId).removeAttribute("hidden");
            }
		}

        function releasePet (id, releasePet, closeScreen)
        {
			if (releasePet === true)
            {
                let xhr = new XMLHttpRequest ();

                // setup host name and the rest of the url by building parts
				// and replacing others.
                let host = location.protocol.concat("//").concat(window.location.host);
                let path = window.location.pathname;
                path = path.replace("public/index.php", "");
                path = path + "api/pet_data.php";
                let url = host + path + "?type=delete_pet&pet_id=" + pet.id;

                xhr.open ('GET', url);
                xhr.setRequestHeader("Content-type", "application/json");
                xhr.send ();
                xhr.onreadystatechange = function ()
                {
                    if (this.readyState === 4 && this.status === 200)
                    {
                        //alert (this.responseText);

                        let a = JSON.parse(this.responseText);
                        //alert (JSON.stringify(a[1], null, 2));
                        //alert (a.length);

                        let ok = a[0];
                        if (ok && a[1])
                        {
							pet = a[1];
                            loadPetData();
                        }

                        location.reload();
                    }
                }

                setStateInfo ('none');
                setButtonInfo ('none');
                document.getElementById(id).setAttribute("hidden", "1");
			}
			else
            {
                if (closeScreen)
                {
                    document.getElementById('petmenu-release-error').setAttribute("hidden", "1");
                    toggleButtonImage('pm-health', 'pm-health', 'petmenu-health', 'img/pet-menu/petmenu-health.webp', 'img/pet-menu/petmenu-health-active.webp');
                }
                else
                {
                    // go back to health screen
                    toggleButtonImage('pm-health', 'pm-health', 'petmenu-health', 'img/pet-menu/petmenu-health.webp', 'img/pet-menu/petmenu-health-active.webp');
                    toggleButtonImage('pm-health', 'pm-health', 'petmenu-health', 'img/pet-menu/petmenu-health.webp', 'img/pet-menu/petmenu-health-active.webp');
                }
            }
		}


        // --------------------------------------------------------------
		// Foraging support.

        function selectForage1 (idx, name)
        {
            //console.log ("state: " + state + ", button: " + activeButton);

            // hide food selection screen
            let e = document.getElementById('globalmenu-foraging1');
            e.setAttribute("hidden", "1");

            food = getFoodDetail (name);
            // console.log ("food: " + JSON.stringify(food));

            stopTypewriter ();

        	if (owner.actionPoints < 1)
            {
                //console.log ("selectForage1");
                document.getElementById('pet-portrait-texture').src = `${food.texture}`;

                // Not enough AP, goto the error forage page
                let html = 'You do not have enough AP for this task! You could have gained the following: <br/>';
                html += `<p class="c-plus">${getUnAdjustedObject(food, 'pos')}</p>`;
                html += `<p class="c-minus">${getUnAdjustedObject(food, 'neg')}</p>`;
                html += `<p class="c-fatigue">${getUnAdjustedObject(food, 'fatigue')}</p>`;
                html += `<br/><br/>`;
                html += `<p>AP replenishes daily, Return tomorrow!</p>`;
                html += `<p> <br/>&lt;Click the Text to Close&gt;</p>`;

                let e = document.getElementById('globalmenu-foraging5-msg');
                e.innerHTML = html;

                e = document.getElementById('globalmenu-foraging5');
                e.removeAttribute("hidden");
                setStateInfo('globalmenu-foraging5');
            }
            else
            {
                // show current screen
                e = document.getElementById('globalmenu-foraging2');
                e.removeAttribute("hidden");

                e = document.getElementById('foraging2-foodname');
                e.innerHTML = name;


                // forage cost factor
                let factor = pet.confidence / 10;
                if (! factor)   factor = 1;
                food.cost = Math.floor (food.cost + factor);


                let html = `<p class="c-price">Acquires ${food.cost} Food<p>`;
                html += `<br/>`;
                html += `<p class="c-plus">${getUnAdjustedObject(food, 'pos')}</p>`;
                html += `<p class="c-minus">${getUnAdjustedObject(food, 'neg')}</p>`;
                html += `<p class="c-fatigue">${getUnAdjustedObject(food, 'fatigue')}</p>`

                e = document.getElementById('forage2-foodinfo');
                e.innerHTML = html;
                e = document.getElementById('forage2_food_image');
                e.src = food.texture;

                setStateInfo('globalmenu-foraging2');
                setButtonInfo ('chore_forage');
                foodName = name;
                setFoodInfo (name);
            }

		}


		function selectForageClose ()
        {
            let e = document.getElementById('globalmenu-foraging1');
            e.setAttribute("hidden", "1");

            e = document.getElementById('globalmenu-foraging2');
            e.setAttribute("hidden", "1");

            document.getElementById('pet-portrait-texture').src = `${pet.texture}`;
            toggleButtonImageOff ('chore_forage', 'img/global-button/button-forage.webp');
            setStateInfo ('none');
            setButtonInfo ('none');
		}

        function selectForage2 (hideId, showId, flag)
        {
            //console.log (hideId + ", " + showId + ", " + flag);
            let e = document.getElementById(hideId);
            e.setAttribute("hidden", "1");

            if (flag)
            {
                // show current screen
                e = document.getElementById(showId);
                e.removeAttribute("hidden");

                e = document.getElementById('foraging3-foodname');
                if (e)  e.innerHTML = foodName;

                // HACK
                // leave this alone for now, it allows the pet selector to be active.
                setStateInfo ('globalmenu-foraging3');
            }
            else
            {
                // hide / show screen
                document.getElementById('globalmenu-foraging2').setAttribute("hidden", "1");
                document.getElementById('globalmenu-foraging1').removeAttribute("hidden");

                setStateInfo ('globalmenu-foraging1');
                setButtonInfo ('chore-forage');
			}

		}


        function selectForageError (hideId)
        {
            //console.log ("selectForageError");

            let e = document.getElementById(hideId);
            e.setAttribute("hidden", "1");
            document.getElementById('pet-portrait-texture').src = `${pet.texture}`;
            document.getElementById("chore_forage").src = "img/global-button/button-forage.webp";
            setStateInfo ('none');
            setButtonInfo ('none');
            food = {};
        }


        function checkForageRequirement (thePet, theFood)
        {
            let result = false;
        	if ((theFood.reqFitness <= thePet["fitness"]) &&
                (theFood.reqWizardry <= thePet["wizardry"]) &&
                (theFood.reqCharisma <= thePet["charisma"]) &&
                (theFood.reqNature <= thePet["nature"]))
            {
				result = true;
			}
            else
            {
                // give chance even if pet does not meet requirements.
				let value = diceRoll (10, 10);
                if (value <= 25)
                {
                    console.log ("Forage, random override.")
                    result = true;
				}

			}

            // console.log ("forage res: " + result);
			return (result);
		}


        // sigmoidCurve (x, k, x0)
        function testStats (thePet, obj)
        {
            let count = 0;
            let chance = 0.0;
            let trans = 50.0;
			let steep = 0.20;

            // get the sigmoid value for each non-zero stat
            if (obj.constitution !== 0) { count++; chance += sigmoidCurve ((thePet.constitution - obj.constitution), steep, trans); }
            if (obj.strength !== 0) { count++; chance += sigmoidCurve ((thePet.strength - obj.strength), steep, trans); }
            if (obj.agility !== 0) { count++; chance += sigmoidCurve ((thePet.agility - obj.agility), steep, trans); }

            if (obj.charm !== 0) { count++; chance += sigmoidCurve ((thePet.charm - obj.charm), steep, trans); }
            if (obj.confidence !== 0) { count++; chance += sigmoidCurve ((thePet.confidence - obj.confidence), steep, trans); }
            if (obj.empathy !== 0) { count++; chance += sigmoidCurve ((thePet.empathy - obj.empathy), steep, trans); }

            if (obj.intelligence !== 0) { count++; chance += sigmoidCurve ((thePet.intelligence - obj.intelligence), steep, trans); }
            if (obj.wisdom !== 0) { count++; chance += sigmoidCurve ((thePet.wisdom - obj.wisdom), steep, trans); }
            if (obj.sorcery !== 0) { count++; chance += sigmoidCurve ((thePet.sorcery - obj.sorcery), steep, trans); }

            if (obj.loyalty !== 0) { count++; chance += sigmoidCurve ((thePet.loyalty - obj.loyalty), steep, trans); }
            if (obj.spirituality !== 0) { count++; chance += sigmoidCurve ((thePet.spirituality - obj.spirituality), steep, trans); }
            if (obj.karma !== 0) { count++; chance += sigmoidCurve ((thePet.karma - obj.karma), steep, trans); }

            // average the chances
            let aChance = ((chance * 100) / count);
            let rnd = Math.random();

            console.log ("test: " + chance.toFixed(5) + ", " + aChance.toFixed(5) + ", " + rnd.toFixed(5) + ", " + (rnd < aChance));
            return (rnd < aChance);
        }

		function getHealthFactor (thePet)
        {
            // calculate the health factor.  This is applied to reduce
            // the stat gain
            let healthFactor = 1.0;
            if (thePet.health === 'Dead')   healthFactor = 0.0;
            else if (thePet.health === 'Critical') healthFactor = 0.10;
            else if (thePet.health === 'Sick') healthFactor = 0.50;
            else if (thePet.health === 'Run Down') healthFactor = 0.75;
            else if (thePet.health === 'Tired') healthFactor = 0.90;

            return (healthFactor);
		}


        function saveStatsData (thePet, obj)
        {
            // calculate the health factor.
            let healthFactor = getHealthFactor (thePet);

            // apply the new stats x healthFactor
            let data = {
                type: 'save_stats',
				petId: thePet.id,
				cost: (Math.floor (obj.cost * healthFactor)),
                strength: (Math.floor (obj.strength * healthFactor)),
                constitution: (Math.floor (obj.constitution * healthFactor)),
                agility: (Math.floor (obj.agility * healthFactor)),
                charm: (Math.floor (obj.charm * healthFactor)),
                confidence: (Math.floor (obj.confidence * healthFactor)),
                empathy: (Math.floor (obj.empathy * healthFactor)),
                intelligence: (Math.floor (obj.intelligence * healthFactor)),
                wisdom: (Math.floor (obj.wisdom * healthFactor)),
                sorcery: (Math.floor (obj.sorcery * healthFactor)),
                loyalty: (Math.floor (obj.loyalty * healthFactor)),
                spirituality: (Math.floor (obj.spirituality * healthFactor)),
                karma: (Math.floor (obj.karma * healthFactor)),
				fatigue: (Math.floor ((obj.fatigue) ? (obj.fatigue) : (0))),
				actionPoints: (Math.floor ((obj.actionPoints) ? (obj.actionPoints) : (0))),
			}

            //console.log ("hf: " + healthFactor + "\n" + pet.karma + " / " + pet.loyalty + " | "+ data.karma + " / " + data.loyalty);

            let xhr = new XMLHttpRequest();
            let host = location.protocol.concat("//").concat(window.location.host);
            let path = window.location.pathname;
            path = path.replace("public/index.php", "");
            path = path + "api/pet_data.php";
            let url = host + path;
            xhr.open ('POST', url);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.send (JSON.stringify (data));
            xhr.onreadystatechange = function ()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    //console.log ("saving stats data:  " + this.responseText);
                    //alert ("saving stats data:  " + this.responseText);
                    let a = JSON.parse(this.responseText);
                    //alert (JSON.stringify(a[1], null, 2));
                    //alert (a.length);
					if (a.length >= 1)
                    {
                        pet = a[0];
                        //console.log ("saved stats data:  "  + pet.karma + " / " + pet.loyalty);
                        //console.log ("old pet:  "  + oldPet.karma + " / " + oldPet.loyalty);
                        loadPetData ();
					}


                    if (a.length > 1)
                    {
                        //console.log (JSON.stringify(a[1], null, 2));
                        //alert (JSON.stringify(a[1], null, 2));
                        owner = a[1];
                        loadOwnerData ();
					}
                }
            }
		}

        function emote2FileName (name)
        {
            let fName = emote2Name [name];
            if (fName === undefined)
            {
                fName = '';
            }
            return (fName);
        }

        function showEmoticon (name)
        {
            // Emote processing
            // console.log ("emote: " + name);
            let fName = emote2FileName (name);
            if (fName !== '')
            {
                document.getElementById('pet-emoji').src = `${fName}`;
                document.getElementById('pet-emoticon').style.display = 'block';

                document.getElementById('pet-face-img').src = `${pet.faceTexture}`;
                document.getElementById('pet-face').removeAttribute("hidden");
            }
            else
            {
                document.getElementById('pet-emoticon').style.display = 'none';
                document.getElementById('pet-face').setAttribute("hidden", "");
            }
		}


        function showPetFace (name)
        {
            // face processing
            // console.log ("facee: " + name);
            if (name === '%PET_FACE%')
            {
                document.getElementById('pet-face-img').src = `${pet.faceTexture}`;
                document.getElementById('pet-face').removeAttribute("hidden");
            }
            else
            {
                document.getElementById('pet-face').setAttribute("hidden", "");
            }
        }

        function getAdjustmentObject2 (thePet, obj, attribType)
        {
            //let healthFactor = getHealthFactor (thePet);

            let result = '';
            // console.log ("obj: " + JSON.stringify(obj));
            if (attribType === "pos")
            {
                /*
                if (obj.constitution > 0)  result += `CON ${thePet.constitution} -> ${thePet.constitution + Math.floor (obj.constitution * healthFactor)}<br/>`;
                if (obj.strength > 0)  result += `STR ${thePet.strength} -> ${thePet.strength + Math.floor (obj.strength * healthFactor)}<br/>`;
                if (obj.agility > 0)  result += `AGI  ${thePet.agility} -> ${thePet.agility + Math.floor (obj.agility * healthFactor)}<br/>`;
                if (obj.charm > 0)   result += `CHA ${thePet.charm} -> ${thePet.charm + Math.floor (obj.charm * healthFactor)}<br/>`;
                if (obj.confidence > 0)   result += `CFI ${thePet.confidence} -> ${thePet.confidence + Math.floor (obj.confidence * healthFactor)}<br/>`;
                if (obj.empathy > 0)   result += `EMP ${thePet.empathy} -> ${thePet.empathy + Math.floor (obj.empathy * healthFactor)}<br/>`;
                if (obj.intelligence > 0)   result += `INT ${thePet.intelligence} -> ${thePet.intelligence + Math.floor (obj.intelligence * healthFactor)}<br/>`;
                if (obj.wisdom > 0)   result += `WIS ${thePet.wisdom} -> ${thePet.wisdom + Math.floor (obj.wisdom * healthFactor)}<br/>`;
                if (obj.sorcery > 0)   result += `SOR ${thePet.sorcery} -> ${thePet.sorcery + Math.floor (obj.sorcery * healthFactor)}<br/>`;
                if (obj.loyalty > 0)   result += `LOY ${thePet.loyalty} -> ${thePet.loyalty + Math.floor (obj.loyalty * healthFactor)}<br/>`;
                if (obj.spirituality > 0)   result += `SPI ${thePet.spirituality} -> ${thePet.spirituality + Math.floor (obj.spirituality * healthFactor)}<br/>`;
                if (obj.karma > 0)   result += `KAR ${thePet.karma} -> ${thePet.karma + Math.floor (obj.karma * healthFactor)}<br/>`;
				*/

                if (obj.constitution > 0)  result += `CON ${thePet.constitution} -> ${thePet.constitution + obj.constitution}<br/>`;
                if (obj.strength > 0)  result += `STR ${thePet.strength} -> ${thePet.strength + obj.strength}<br/>`;
                if (obj.agility > 0)  result += `AGI  ${thePet.agility} -> ${thePet.agility + obj.agility}<br/>`;
                if (obj.charm > 0)   result += `CHA ${thePet.charm} -> ${thePet.charm + obj.charm}<br/>`;
                if (obj.confidence > 0)   result += `CFI ${thePet.confidence} -> ${thePet.confidence + obj.confidence}<br/>`;
                if (obj.empathy > 0)   result += `EMP ${thePet.empathy} -> ${thePet.empathy + obj.empathy}<br/>`;
                if (obj.intelligence > 0)   result += `INT ${thePet.intelligence} -> ${thePet.intelligence + obj.intelligence}<br/>`;
                if (obj.wisdom > 0)   result += `WIS ${thePet.wisdom} -> ${thePet.wisdom + obj.wisdom}<br/>`;
                if (obj.sorcery > 0)   result += `SOR ${thePet.sorcery} -> ${thePet.sorcery + obj.sorcery}<br/>`;
                if (obj.loyalty > 0)   result += `LOY ${thePet.loyalty} -> ${thePet.loyalty + obj.loyalty}<br/>`;
                if (obj.spirituality > 0)   result += `SPI ${thePet.spirituality} -> ${thePet.spirituality + obj.spirituality}<br/>`;
                if (obj.karma > 0)   result += `KAR ${thePet.karma} -> ${thePet.karma + obj.karma}<br/>`;
            }
            else if (attribType === "neg")
            {
                /*
                if (obj.constitution < 0)   result += `CON ${thePet.constitution} -> ${thePet.constitution + Math.floor (obj.constitution * healthFactor)},br/>`;
                if (obj.strength < 0)   result += `STR ${thePet.strength} -> ${thePet.strength + Math.floor (obj.strength * healthFactor)}<br/>`
                if (obj.agility < 0)   result += `AGI  ${thePet.agility} -> ${thePet.agility + Math.floor (obj.agility * healthFactor)}<br/>`;
                if (obj.charm < 0)   result += `CHA ${thePet.charm} -> ${thePet.charm + Math.floor (obj.charm * healthFactor)}<br/>`;
                if (obj.confidence < 0)   result += `CFI ${thePet.confidence} -> ${thePet.confidence + Math.floor (obj.confidence * healthFactor)}<br/>`;
                if (obj.empathy < 0)    result += `EMP ${thePet.empathy} -> ${thePet.empathy + Math.floor (obj.empathy * healthFactor)}<br/>`;
                if (obj.intelligence < 0)   result += `INT ${thePet.intelligence} -> ${thePet.intelligence + Math.floor (obj.intelligence * healthFactor)}<br/>`;
                if (obj.wisdom < 0)   result += `WIS ${thePet.wisdom} -> ${thePet.wisdom + Math.floor (obj.wisdom * healthFactor)}<br/>`;
                if (obj.sorcery < 0)   result += `SOR ${thePet.sorcery} -> ${thePet.sorcery + Math.floor (obj.sorcery * healthFactor)}<br/>`;
                if (obj.loyalty < 0)    result += `LOY ${thePet.loyalty} -> ${thePet.loyalty + Math.floor (obj.loyalty * healthFactor)}<br/>`;
                if (obj.spirituality < 0)   result += `SPI ${thePet.spirituality} -> ${thePet.spirituality + Math.floor (obj.spirituality * healthFactor)}<br/>`;
                if (obj.karma < 0)   result += `KAR ${thePet.karma} -> ${thePet.karma + Math.floor (obj.karma * healthFactor)}<br/>`;
                */

                if (obj.constitution < 0)   result += `CON ${thePet.constitution} -> ${thePet.constitution + obj.constitution},br/>`;
                if (obj.strength < 0)   result += `STR ${thePet.strength} -> ${thePet.strength + obj.strength}<br/>`
                if (obj.agility < 0)   result += `AGI  ${thePet.agility} -> ${thePet.agility + obj.agility}<br/>`;
                if (obj.charm < 0)   result += `CHA ${thePet.charm} -> ${thePet.charm + obj.charm}<br/>`;
                if (obj.confidence < 0)   result += `CFI ${thePet.confidence} -> ${thePet.confidence + obj.confidence}<br/>`;
                if (obj.empathy < 0)    result += `EMP ${thePet.empathy} -> ${thePet.empathy + obj.empathy}<br/>`;
                if (obj.intelligence < 0)   result += `INT ${thePet.intelligence} -> ${thePet.intelligence + obj.intelligence}<br/>`;
                if (obj.wisdom < 0)   result += `WIS ${thePet.wisdom} -> ${thePet.wisdom + obj.wisdom}<br/>`;
                if (obj.sorcery < 0)   result += `SOR ${thePet.sorcery} -> ${thePet.sorcery + obj.sorcery}<br/>`;
                if (obj.loyalty < 0)    result += `LOY ${thePet.loyalty} -> ${thePet.loyalty + obj.loyalty}<br/>`;
                if (obj.spirituality < 0)   result += `SPI ${thePet.spirituality} -> ${thePet.spirituality + obj.spirituality}<br/>`;
                if (obj.karma < 0)   result += `KAR ${thePet.karma} -> ${thePet.karma + obj.karma}<br/>`;

            }
            else if (attribType === "food")
            {
                if ((! isNaN(obj.food)) && (obj.food !== 0)) result = `Food ${thePet.food} -> ${thePet.food + obj.food}<br/>`;
            }
            else if (attribType === "fatigue")
            {
				if (obj.fatigue !== 0)
                {
                    let calc = Math.floor (thePet.fatigue + obj.fatigue);
                    if (calc < 0)  calc = 0;
                    result = `Fatigue ${thePet.fatigue} -> ${calc}<br/>`;
                }
            }

            return (result);
		}


        function getUnAdjustedObject (obj, attribType)
        {
            let result = '';
            if (attribType === "pos")
            {
                if (Math.floor (obj.constitution) > 0)  result += `CON ${formatNum (Math.floor (obj.constitution))}, `;
                if (Math.floor (obj.strength) > 0)  result += `STR ${formatNum (Math.floor (obj.strength))}, `;
                if (Math.floor (obj.agility) > 0)  result += `AGI ${formatNum (Math.floor (obj.agility))}, `;
                if (Math.floor (obj.charm) > 0)   result += `CHA ${formatNum (Math.floor (obj.charm))}, `;
                if (Math.floor (obj.confidence) > 0)   result += `CFI ${formatNum (Math.floor (obj.confidence))}, `;
                if (Math.floor (obj.empathy) > 0)   result += `EMP ${formatNum (Math.floor (obj.empathy))}, `;
                if (Math.floor (obj.intelligence) > 0)   result += `INT ${formatNum (Math.floor (obj.intelligence))}, `;
                if (Math.floor (obj.wisdom) > 0)   result += `WIS ${formatNum (Math.floor (obj.wisdom))}, `;
                if (Math.floor (obj.sorcery) > 0)   result += `SOR ${formatNum (Math.floor (obj.sorcery))}, `;
                if (Math.floor (obj.loyalty) > 0)   result += `LOY ${formatNum (Math.floor (obj.loyalty))}, `;
                if (Math.floor (obj.spirituality) > 0)   result += `SPI ${formatNum (Math.floor (obj.spirituality))}, `;
                if (Math.floor (obj.karma) > 0)   result += `KAR ${formatNum (Math.floor (obj.karma))}, `;
            }
            else if (attribType === "neg")
            {
                if (Math.floor (obj.constitution) < 0)   result += `CON ${formatNum (Math.floor (obj.constitution))}, `;
                if (Math.floor (obj.strength) < 0)   result += `STR ${formatNum (Math.floor (obj.strength))}, `;
                if (Math.floor (obj.agility) < 0)   result += `AGI ${formatNum (Math.floor (obj.agility))} ,`;
                if (Math.floor (obj.charm) < 0)   result += `CHA ${formatNum (Math.floor (obj.charm))}, `;
                if (Math.floor (obj.confidence) < 0)   result += `CFI ${formatNum (Math.floor (obj.confidence))}, `;
                if (Math.floor (obj.empathy) < 0)   result += `EMP ${formatNum (Math.floor (obj.empathy))}, `;
                if (Math.floor (obj.intelligence) < 0)   result += `INT ${formatNum (Math.floor (obj.intelligence))}, `;
                if (Math.floor (obj.wisdom) < 0)   result += `WIS ${formatNum (Math.floor (obj.wisdom))} ,`;
                if (Math.floor (obj.sorcery) < 0)   result += `SOR ${formatNum (Math.floor (obj.sorcery))} `;
                if (Math.floor (obj.loyalty) < 0)   result += `LOY ${formatNum (Math.floor (obj.loyalty))} `;
                if (Math.floor (obj.spirituality) < 0)   result += `SPI ${formatNum (Math.floor (obj.spirituality))},`;
                if (Math.floor (obj.karma) < 0)   result += `KAR ${formatNum (Math.floor (obj.karma))}, `;
            }
            else if (attribType === "fatigue")
            {
                if (obj.fatigue !== 0) result = `Fatigue ${formatNum (Math.floor (obj.fatigue))}`;
            }

            return (result);
        }

        function getAdjustmentObject (obj, attribType)
        {
            // get the health factor for the pet
            let healthFactor = getHealthFactor (pet);

        	let result = '';
            if (attribType === "pos")
            {
                if (Math.floor (obj.constitution * healthFactor) > 0)  result += `CON ${formatNum (Math.floor (obj.constitution * healthFactor))}, `;
                if (Math.floor (obj.strength * healthFactor) > 0)  result += `STR ${formatNum (Math.floor (obj.strength * healthFactor))}, `;
                if (Math.floor (obj.agility * healthFactor) > 0)  result += `AGI ${formatNum (Math.floor (obj.agility * healthFactor))}, `;
                if (Math.floor (obj.charm * healthFactor) > 0)   result += `CHA ${formatNum (Math.floor (obj.charm * healthFactor))}, `;
                if (Math.floor (obj.confidence * healthFactor) > 0)   result += `CFI ${formatNum (Math.floor (obj.confidence * healthFactor))}, `;
                if (Math.floor (obj.empathy * healthFactor) > 0)   result += `EMP ${formatNum (Math.floor (obj.empathy * healthFactor))}, `;
                if (Math.floor (obj.intelligence * healthFactor) > 0)   result += `INT ${formatNum (Math.floor (obj.intelligence * healthFactor))}, `;
                if (Math.floor (obj.wisdom * healthFactor) > 0)   result += `WIS ${formatNum (Math.floor (obj.wisdom * healthFactor))}, `;
                if (Math.floor (obj.sorcery * healthFactor) > 0)   result += `SOR ${formatNum (Math.floor (obj.sorcery * healthFactor))}, `;
                if (Math.floor (obj.loyalty * healthFactor) > 0)   result += `LOY ${formatNum (Math.floor (obj.loyalty * healthFactor))}, `;
                if (Math.floor (obj.spirituality * healthFactor) > 0)   result += `SPI ${formatNum (Math.floor (obj.spirituality * healthFactor))}, `;
                if (Math.floor (obj.karma * healthFactor) > 0)   result += `KAR ${formatNum (Math.floor (obj.karma * healthFactor))}, `;
            }
            else if (attribType === "neg")
            {
                if (Math.floor (obj.constitution * healthFactor) < 0)   result += `CON ${formatNum (Math.floor (obj.constitution * healthFactor))}, `;
                if (Math.floor (obj.strength * healthFactor) < 0)   result += `STR ${formatNum (Math.floor (obj.strength * healthFactor))}, `;
                if (Math.floor (obj.agility * healthFactor) < 0)   result += `AGI ${formatNum (Math.floor (obj.agility * healthFactor))} ,`;
                if (Math.floor (obj.charm * healthFactor) < 0)   result += `CHA ${formatNum (Math.floor (obj.charm * healthFactor))}, `;
                if (Math.floor (obj.confidence * healthFactor) < 0)   result += `CFI ${formatNum (Math.floor (obj.confidence * healthFactor))}, `;
                if (Math.floor (obj.empathy * healthFactor) < 0)   result += `EMP ${formatNum (Math.floor (obj.empathy * healthFactor))}, `;
                if (Math.floor (obj.intelligence * healthFactor) < 0)   result += `INT ${formatNum (Math.floor (obj.intelligence * healthFactor))}, `;
                if (Math.floor (obj.wisdom * healthFactor) < 0)   result += `WIS ${formatNum (Math.floor (obj.wisdom * healthFactor))} ,`;
                if (Math.floor (obj.sorcery * healthFactor) < 0)   result += `SOR ${formatNum (Math.floor (obj.sorcery * healthFactor))} `;
                if (Math.floor (obj.loyalty * healthFactor) < 0)   result += `LOY ${formatNum (Math.floor (obj.loyalty * healthFactor))} `;
                if (Math.floor (obj.spirituality * healthFactor) < 0)   result += `SPI ${formatNum (Math.floor (obj.spirituality * healthFactor))},`;
                if (Math.floor (obj.karma * healthFactor) < 0)   result += `KAR ${formatNum (Math.floor (obj.karma * healthFactor))}, `;
			}
            else if (attribType === "fatigue")
            {
                if (obj.fatigue !== 0) result = `Fatigue ${formatNum (Math.floor (obj.fatigue))}`;
			}

            return (result);
		}


        function formatNum (n) {
            return (n > 0 ? '+' : '') + n;
        }

        function getFoodDetail (name)
        {
            let obj;
            <?php
			for ($i = 0; $i < sizeof ($foodInfo); $i++)
            {
				$food = $foodInfo[$i];
				?>
			   	if (name === '<?php echo $food->type?>')
                {
                    obj = {
                    	type : '<?php echo $food->type?>',
						cost : <?php echo $food->cost?>,
						texture : '<?php echo $food->texture?>',
						reqFitness : <?php echo $food->reqFitness?>,
						reqCharisma : <?php echo $food->reqCharisma?>,
						reqWizardry : <?php echo $food->reqWizardry?>,
						reqNature : <?php echo $food->reqNature?>,
						constitution : <?php echo $food->constitution?>,
						strength : <?php echo $food->strength?>,
						agility : <?php echo $food->agility?>,
						charm : <?php echo $food->charm?>,
						confidence : <?php echo $food->confidence?>,
						empathy : <?php echo $food->empathy?>,
						intelligence : <?php echo $food->intelligence?>,
						wisdom : <?php echo $food->wisdom?>,
						sorcery : <?php echo $food->sorcery?>,
						loyalty : <?php echo $food->loyalty?>,
						spirituality : <?php echo $food->spirituality?>,
						karma : <?php echo $food->karma?>,
						fatigue : <?php echo $food->fatigue?>,
						actionPoints : <?php echo $food->actionPoints?>,
                    }
                }
				<?php
			}
			?>

			return (obj);
		}

        function getTrainDetail (name)
        {
            let obj;
            <?php
            for ($i = 0; $i < sizeof ($trainInfo); $i++)
            {
				$train = $trainInfo[$i];
				?>
				if (name === '<?php echo $train->type?>')
				{
					obj = {
						type : '<?php echo $train->type?>',
						cost : <?php echo $train->cost?>,
						texture : '<?php echo $train->texture?>',
						constitution : <?php echo $train->constitution?>,
						strength : <?php echo $train->strength?>,
						agility : <?php echo $train->agility?>,
						charm : <?php echo $train->charm?>,
						confidence : <?php echo $train->confidence?>,
						empathy : <?php echo $train->empathy?>,
						intelligence : <?php echo $train->intelligence?>,
						wisdom : <?php echo $train->wisdom?>,
						sorcery : <?php echo $train->sorcery?>,
						loyalty : <?php echo $train->loyalty?>,
						spirituality : <?php echo $train->spirituality?>,
						karma : <?php echo $train->karma?>,
						fatigue : <?php echo $train->fatigue?>
					}
				}
            	<?php
            }
            ?>

            return (obj);
        }


        
        function selectTrain1 (id, name, cost)
        {
            //console.log ("state: " + state + ", button: " + activeButton);

        	//alert (id + " " + name + " " + cost);
            setStateInfo ('globalmenu-training2');
            setButtonInfo ('adv_train');
            setTrainInfo (name);
            stopTypewriter ();

            train = getTrainDetail (name);

            let e = document.getElementById('globalmenu-training1');
            e.setAttribute("hidden", "1");

            //alert (
            //    "cost: " + train.cost +
			//	", food: " +  owner.food +
			//	", total: " + (train.cost + owner.food));
			// NOTE:  train cost is a negative number
            if ((train.cost + owner.food) < 0)
            {
                // Not enough food, goto the error train page
                let html = 'You do not have enough food for this training! You could have gained the following: <br/>';
                html += `<p class="c-plus">${getUnAdjustedObject(train, 'pos')}</p>`;
                html += `<p class="c-minus">${getUnAdjustedObject(train, 'neg')}</p>`;
                html += `<p class="c-fatigue">${getUnAdjustedObject(train, 'fatigue')}</p>`;
                html += `<p> <br/>&lt;Click the Text Here to Go Back&gt; </p>`;

                e = document.getElementById('globalmenu-training5-text');
                e.innerHTML = html;

                e = document.getElementById('globalmenu-training5');
                e.removeAttribute("hidden");
                document.getElementById('pet-portrait-texture').src = `${train.texture}`;
			}
			else
            {
                e = document.getElementById('globalmenu-training2');
                e.removeAttribute("hidden");

                e = document.getElementById('globalmenu-training2-name');
                e.innerHTML = name;

                e = document.getElementById('globalmenu-training2-texture');
                e.src = `${train.texture}`;

                let html = `<p class="c-price">Price ${Math.abs(cost)} Food<p>`;
                html += `<br/>`;
                html += `<p class="c-plus">${getUnAdjustedObject(train, 'pos')}</p>`;
                html += `<p class="c-minus">${getUnAdjustedObject(train, 'neg')}</p>`;
                html += `<p class="c-fatigue">${getUnAdjustedObject(train, 'fatigue')}</p>`;

                e = document.getElementById('train2-traininfo');
                e.innerHTML = html;

                /*
                <p class="c-price">Price: 20 Food<p>
                <br/>
                <p class="c-plus">CON +9</p> <!-- if there is + to stat, then use c-plus, if - to stat, then use c-minus. refer to "global menu font color" in css-->
                <p class="c-plus">STR +5</p> <!-- if there is + to stat, then use c-plus, if - to stat, then use c-minus -->
                <p class="c-fatigue">Fatigue +3</p> <!-- if it is fatigue, then use  c-fatigue class -->
                 */
            }
		}


        function selectTrainClose ()
        {
            document.getElementById('globalmenu-training1').setAttribute("hidden", "1");

            document.getElementById('pet-portrait-texture').src = `${pet.texture}`;
            toggleButtonImageOff ('adv_train', 'img/global-button/button-train.webp');
            setStateInfo ('none');
            setButtonInfo ('none');
		}

        function selectTrain2(id, flag)
        {
            if (flag)
            {
                let e = document.getElementById(id);
                e.setAttribute("hidden", "1");

                e = document.getElementById('globalmenu-training3-name');
                if (e) 	e.innerHTML = train.type;

                e = document.getElementById('globalmenu-training3');
                e.removeAttribute("hidden");
                setStateInfo ('globalmenu-training3');
            }
            else
            {
                document.getElementById('globalmenu-training1').removeAttribute("hidden");
                document.getElementById('globalmenu-training2').setAttribute("hidden", "1");
                setStateInfo ('globalmenu-training1');
                setButtonInfo ('adv-train');

                //console.log ("selectTrain2");
                //document.getElementById('pet-portrait-texture').src = `${pet.texture}`;
                //toggleButtonImageOff ('adv_train', 'img/global-button/button-train.webp');
                //setStateInfo ('none');
                //setButtonInfo ('none');
			}
		}

        // -----------------------------------------------------------------------
		// Rest screens
        function selectRest1(id, flag)
        {
            //console.log ("state: " + state + ", button: " + activeButton);

            let e = document.getElementById(id);
            e.setAttribute("hidden", "1");
			if (flag)
            {
                stopTypewriter ();
                if (owner.actionPoints < 1)
                {
                    // not enough action points to do a global rest.

                    e = document.getElementById('globalmenu-rest2');
                    e.removeAttribute("hidden");
                    setStateInfo('globalmenu-rest2');
                    setButtonInfo('chore_rest');
					document.getElementById('train2-message').innerHTML = 'You do not have enough AP to perform this task. <br/>&lt;Click the Text to Close&gt;';
				}
                else if (pet.health === "Dead")
                {
                    e = document.getElementById('globalmenu-rest2');
                    e.removeAttribute("hidden");
                    setStateInfo('globalmenu-rest2');
                    setButtonInfo('chore_rest');
                    document.getElementById('train2-message').innerHTML = 'Regrettably, you pet is dead and incapable of performing this action.';
				}
                else
                {
                    let xhr = new XMLHttpRequest();
                    // setup host name and the rest of the url by building parts
                    // and replacing others.
                    let host = location.protocol.concat("//").concat(window.location.host);
                    let path = window.location.pathname;
                    path = path.replace("public/index.php", "");
                    path = path + "api/pet_data.php";
                    let url = host + path;

                    xhr.open('POST', url);
                    xhr.setRequestHeader("Content-type", "application/json");
                    let body = {
                        type: 'save_rest',
                        avId: `${owner.avId}`,
						petId: `${pet.id}`,
                        fatigue: -10,
                        actionPts: -1,
                    }

                    //console.log ("resting pet: " + pet.id)
                    xhr.send(JSON.stringify(body));
                    xhr.onreadystatechange = function ()
                    {
                        if (this.readyState === 4 && this.status === 200)
                        {
                            //alert (JSON.stringify(this.responseText));
                            let a = JSON.parse(this.responseText);

                            if (a.length >= 2)
                            {
                                pet = a[0];
                                //console.log ("Rest:  loading pet data...");
                                loadPetData();

                                owner = a[1];
                                loadOwnerData();
                            }
                        }
                    }

                    setTimeout (function() {
                        //console.log ("delayed pet list update.");
                        updatePetSelector ();
                    }, 1000);

                    // screen stuff
                    setStateInfo('globalmenu-rest2');
                    setButtonInfo('chore_rest');

                    questInfo.category = "Rest";
                    selectActionStart('globalmenu-rest2', true, 'get_rest_quest');
                }
			}
            else
            {
                document.getElementById('pet-portrait-texture').src = `${pet.texture}`;
                //document.getElementById('pet-portrait-texture').setAttribute("style", '');
                setPetPortraitFilter(pet);
                document.getElementById("chore_rest").src = "img/global-button/button-rest.webp";
                setStateInfo('none');
                setButtonInfo ('none');
			}
		}

        function selectRest2(id)
        {
            let e = document.getElementById(id);
            e.setAttribute("hidden", "1");

            setStateInfo ('none');
            setButtonInfo ('none');
            updatePetSelector ();
            document.getElementById('pet-portrait-texture').src = `${pet.texture}`;
			setPetPortraitFilter(pet);
            document.getElementById("chore_rest").src = "img/global-button/button-rest.webp";
        }


		function  selectVacation1 (hideId, showId)
        {
            document.getElementById(hideId).setAttribute("hidden", "1");
            document.getElementById(showId).removeAttribute("hidden");

            setStateInfo(showId);
            setButtonInfo('pm_action');

            document.getElementById('pet-portrait-texture').src = `img/pet-menu/petmenu-action-healing.webp`;

            let e = document.getElementById('globalmenu-action-result');
            e.removeAttribute("hidden");
            document.getElementById('globalmenu-action-result2').setAttribute("hidden", "1");

            let str = '<p class="tcenter c-result">Spend 20 food for %PET_NAME%\'s vacation, cutting fatigue 100!<br/>Would you like to continue?</p>';
            str += '<div class="row">';
            str += '<div class="column5" id="pet_vacation_yes" ><a href="#" class="c-yes" onclick="selectVacation2 (\'petmenu-action\', \'petmenu-action-scene\', true);" style="display:inline-block;"><u>Yes</u></a></div>';
            str += '<div class="column5" id="pet_vacation_no"><a href="#" class="c-no" onclick="selectVacation2(\'petmenu-action\', \'petmenu-action-scene\', false);" style="display:inline-block;"><u>No</u></a></div>';
            str += '</div>';

            str = formatQuestText(str, 0, 0);
            e.innerHTML = str;

        }

        function  selectVacation2 (hideId, showId, flag)
        {
            console.log ("selectVacation2: " + hideId + ", " + showId + ", " + flag);
            if (flag)
            {
                // -100 Fatigue (20 food)
                //IF VACATION PRESSED:
                //<p id="globalmenu-action-result" class="tcenter c-vacation">You do not have enough food to go on a vacation.</p>
                //<p id="globalmenu-action-result" class="tcenter c-vacation">Your beloved pet finds rejuvenation in a blissful vacation paradise, shedding fatigue.</p>

                let e = document.getElementById(hideId);
                e.setAttribute("hidden", "1");
                document.getElementById('pet-portrait-texture').src = `img/pet-menu/petmenu-action-vacation.webp`;

                e = document.getElementById(showId);
                e.removeAttribute("hidden");
                setStateInfo(showId);
                setButtonInfo('pm_action');

                if (20 >= owner.food)
                {
                    e = document.getElementById('globalmenu-action-result2');
                    e.removeAttribute("hidden");
                    e.innerHTML = 'You do not have enough food to go on a vacation. &lt;Click the Text to Close&gt;';

                    e.setAttribute(
                        "onclick", "selectVacation3 (\'petmenu-action\', \'petmenu-action-scene\'); return false;");

                    document.getElementById('globalmenu-action-result').setAttribute("hidden", "1");

                }
                else
                {
                    document.getElementById('globalmenu-action-result2').setAttribute("hidden", "1");
                    e = document.getElementById('globalmenu-action-result');
                    e.removeAttribute("hidden");

                    if (pet.health === "Dead")
                    {
                        document.getElementById('globalmenu-action-result').setAttribute("hidden", "1");
                        document.getElementById('globalmenu-action-result2').removeAttribute("hidden");

                        document.getElementById('globalmenu-action-result2').innerHTML = 'Regrettably, you pet is dead and incapable of performing this action.';
                        document.getElementById('globalmenu-action-result2').setAttribute(
                            "onclick", "selectVacation3 (\'petmenu-action\', \'petmenu-action-scene\'); return false;");
                    }
                    else
                    {
                        let str = '%PET_NAME% finds rejuvenation in a blissful vacation paradise, shedding 100 fatigue.';
                        str = formatQuestText(str, 0, 0);
                        e.innerHTML = str;

                        let xhr = new XMLHttpRequest();

                        // setup host name and the rest of the url by building parts
                        // and replacing others.
                        let host = location.protocol.concat("//").concat(window.location.host);
                        let path = window.location.pathname;
                        path = path.replace("public/index.php", "");
                        path = path + "api/pet_data.php";
                        let url = host + path;

                        xhr.open('POST', url);
                        xhr.setRequestHeader("Content-type", "application/json");
                        let body = {
                            type: 'do_vacation',
                            petId: pet.id,
                            avId: `${owner.avId}`,
                            food: -20,
                            fatigue: -100
                        }

                        xhr.send(JSON.stringify(body));
                        xhr.onreadystatechange = function ()
                        {
                            if (this.readyState === 4 && this.status === 200)
                            {
                                //alert (JSON.stringify(this.responseText));
                                let a = JSON.parse(this.responseText);

                                if (a.length >= 2)
                                {
                                    pet = a[0];
                                    loadPetData();

                                    owner = a[1];
                                    loadOwnerData();


                                    e = document.getElementById('globalmenu-action-result');
                                    e.setAttribute(
                                        "onclick", "selectVacation3 (\'petmenu-action\', \'petmenu-action-scene\'); return false;");

                                }
                            }
                        }
                    }
                }
            }
            else
            {
                stopAction(showId);
			}
        }


        function  selectVacation3 (hideId, showId)
        {
            console.log ("selectVacation3: " + hideId + ", " + showId);
            stopAction(showId);
        }


        // -----------------------------------------------------------------------------
		// Healing / Rejuvenation

        function  selectHealing1 (hideId, showId)
        {
            document.getElementById(hideId).setAttribute("hidden", "1");
            document.getElementById(showId).removeAttribute("hidden");

            setStateInfo(showId);
            setButtonInfo('pm_health');

            document.getElementById('pet-portrait-texture').src = `img/pet-menu/petmenu-action-healing.webp`;

            let e = document.getElementById('globalmenu-action-result');
            let str = '<p class="tcenter c-result">Clearing %PET_NAME%\'s fatigue is 5,000 Soul Coins.<br>(An extra 5,000 if they are deceased.)<br/>Will you pay?</p>';
			str += '<div class="row">';
            str += '<div class="column5" id="pet_heal_yes" ><a href="#" class="c-yes" onclick="selectHealing2 (\'petmenu-action\', \'petmenu-action-scene\', true); return false;" style="display:inline-block;"><u>Yes</u></a></div>';
            str += '<div class="column5" id="pet_heal_no"><a href="#" class="c-no" onclick="selectHealing2(\'petmenu-action\', \'petmenu-action-scene\', false); return false;" style="display:inline-block;"><u>No</u></a></div>';
			str += '</div>';

            str = formatQuestText(str, 0, 0);
            e.innerHTML = str;
        }

        function  selectHealing2 (hideId, showId, flag)
        {
            //console.log ("selectHealing2: " + hideId + ", " + showId + ", " + flag);
			if (flag)
            {
                let e = document.getElementById(hideId);
                e.setAttribute("hidden", "1");
                e = document.getElementById(showId);
                e.removeAttribute("hidden");
                setStateInfo(showId);
                setButtonInfo('pm_health');

                document.getElementById('pet-portrait-texture').src = `img/pet-menu/petmenu-action-healing.webp`;
                e = document.getElementById('globalmenu-action-result');
                e.innerHTML = '';

                let healthCost = 5000;
                let petHealth = pet.health;
                if (petHealth === 'Dead')
                {
                    healthCost += 5000;
                }

                let xhr = new XMLHttpRequest();

                // setup host name and the rest of the url by building parts
                // and replacing others.
                let host = location.protocol.concat("//").concat(window.location.host);
                let path = window.location.pathname;
                path = path.replace("public/index.php", "");
                path = path + "api/health_data.php";
                let url = host + path;

                xhr.open('POST', url);
                xhr.setRequestHeader("Content-type", "application/json");
                let body = {
                    type: 'healing',
                    amount: healthCost,
                    petId: pet.id,
                };

                xhr.send(JSON.stringify(body));
                xhr.onreadystatechange = function ()
                {
                    //alert("state change " + this.readyState + ", " + this.status + ", " + this.responseText);
                    if (this.readyState === XMLHttpRequest.DONE)
                    {
                        if (this.status === 0 || (this.status >= 200 && this.status < 400))
                        {
                            let resp = this.responseText;
                            let a = JSON.parse(resp);
                            resp = a[0];
                            pet = a[1];

                            //alert("resp: " + this.responseText);

                            if ((resp === "ok") || (resp === "1") || (resp === "4"))
                            {
                                e = document.getElementById('globalmenu-action-result');
                                let str = 'Guided by forest whispers, %PET_NAME% enters, embraced by healing energy, rejuvenated.<br/>You have been charged 5,000 Soul Coins for rejuvenation.';
                                str = formatQuestText(str, 0, 0);
                                if (petHealth === 'Dead')
                                {
                                    str += '  You spent 5,000 extra Soul Coins to revive your pet';
                                }
                                e.innerHTML = str;
                            }
                            else
                            {
                                e = document.getElementById('globalmenu-action-result');
                                e.innerHTML = 'You do not have enough SC to visit the Rejuvenation Cave. Or an error occurred getting your balance.';
                            }


                            e = document.getElementById('globalmenu-action-result');
                            e.setAttribute(
                                "onclick", "selectHealing3 (\'petmenu-action\', \'petmenu-action-scene\'); return false;");
                        }
                    }
                }
            }
            else
            {
            	stopAction(showId);
			}
            return false;
        }

        function selectHealing3 (hideId, showId)
        {
            //console.log ("selectHealing3: " + hideId + ", " + showId);
            loadPetData ();
            stopAction (showId);
        }



        // ==================================================
		// Breeding

		function selectBreeding (hideId, showId)
        {
            let e = document.getElementById(hideId);
            e.setAttribute("hidden", "1");
            e = document.getElementById(showId);
            e.removeAttribute("hidden");

            setStateInfo (showId);
            setButtonInfo ('pm_action');
            document.getElementById('pet-portrait-texture').src = `img/pet-menu/petmenu-action-breeding.webp`;

            if ((pet.health === 'Healthy') ||
                (pet.health === 'Tired'))
            {
                e = document.getElementById('globalmenu-action-result');
                e.innerHTML = 'Breeding Cave will become available in the next release.';
			}
            else
            {
                e = document.getElementById('globalmenu-action-result');
                e.innerHTML = `Your pet is not allowed to breed at this time.  They are too ${pet.health}.`;
            }
        }


        function stopAction (hideId)
        {
            let e = document.getElementById(hideId);
            e.setAttribute("hidden", "1");
            setStateInfo ("none");
            setButtonInfo ('none');
            document.getElementById('pet-portrait-texture').src = `${pet.texture}`;
            document.getElementById("pm-action").src = "img/pet-menu/petmenu-action.webp";
		}


        // -----------------------------------------------------------------------

		function setupTrainQuest (flag)
        {
            if (flag)
            {
                saveActivity (pet, 'train');
                updatePetSelector ();
                questInfo.category = "Train";

                accumStat = {
                    constitution: 0,
                    strength: 0,
                    agility: 0,
                    charm: 0,
                    confidence: 0,
                    empathy: 0,
                    intelligence: 0,
                    wisdom: 0,
                    sorcery: 0,
                    loyalty: 0,
                    spirituality: 0,
                    karma: 0,
                    food: 0,
                    fatigue: 0
                };

                selectActionStart('globalmenu-training3', flag, 'get_train_quest');
            }
            else
            {
                //console.log ("setupTrainQuest false");

                let e = document.getElementById('globalmenu-training3');
                e.setAttribute("hidden", "1");

                toggleButtonImageOff ('adv_train', 'img/global-button/button-train.webp');
                document.getElementById('pet-portrait-texture').src = `${pet.texture}`;

                setStateInfo ("none");
                setButtonInfo ('none');
            }
		}



		function setupForageQuest (flag)
        {
            saveActivity (pet, 'forage');
            questInfo.category = "Forage";
            selectActionStart('globalmenu-foraging3', flag, 'get_forage_quest');
		}


        // -----------------------------------------------------------------------
        function selectActionStart (hideId, flag, requestType)
        {
            if (flag)
            {
                let e = document.getElementById(hideId);
                e.setAttribute("hidden", "1");
                document.getElementById('qchoice-p1').innerHTML = "";

                {
                    oldPet = pet;
                    oldOwner = owner;
                    accumStat.food = 0;
                    e = document.getElementById('globalmenu-qchoice');
                    e.removeAttribute("hidden");

                    e = document.getElementById('qchoice-name');
                    if (e)
                    {
                        e.innerHTML = `${pet.species}`;
                    }

                    setStateInfo('globalmenu-qchoice');
                    setButtonInfo('adv_quest');


                    let xhr = new XMLHttpRequest ();

                    // setup host name and the rest of the url by building parts
                    // and replacing others.
                    let host = location.protocol.concat("//").concat(window.location.host);
                    let path = window.location.pathname;
                    path = path.replace("public/index.php", "");
                    path = path + "api/quest_data.php";
                    let url = host + path + "?type=" + requestType;
                    xhr.open ('GET', url);
                    xhr.setRequestHeader("Content-type", "application/json");
                    xhr.send ();
                    xhr.onreadystatechange = function ()
                    {
                        if (this.readyState === 4 && this.status === 200)
                        {
                            //alert ("quest : " + this.responseText);
                            let a = JSON.parse(this.responseText);
                            quest = a[0];
                            questChoice = a[1];

                            document.getElementById('pet-portrait-texture').src = updateQuestPic (`${questChoice.texture}`);
                            document.getElementById('pet-portrait-texture').setAttribute("style", '');
                            document.getElementById('pet-portrait-texture').removeAttribute("hidden");

                            setQuestText (questChoice.message, true);
                            document.getElementById('qchoice-p1').setAttribute(
                                "onclick", `selectQuestChoice ('${questChoice.actions[0]}'); return false;`);

                            setQuestInfo (quest.nextAction);
                            setStateInfo ('globalmenu-qchoice');
                        }
                    }
                }
            }
            else
            {
                let e = document.getElementById(hideId);
                e.setAttribute("hidden", "1");
                document.getElementById('pet-portrait-texture').src = `${pet.texture}`;
                //toggleButtonImage ('forage', 'chore_forage', 'globalmenu-foraging1', 'img/global-button/button-forage.webp', 'img/global-button/button-forage-active.webp');
				//console.log ("selectActionStart false")
                toggleButtonImageOff("chore_forage", 'img/global-button/button-forage.webp');
                toggleButtonImageOff ('adv_train', 'img/global-button/button-train.webp');

                setStateInfo ('none');
                setButtonInfo ('none');
            }
        }


        // ------------------------------------------------------------------------
		// Quest functions

		function selectQuestStart (hideId, flag)
        {
			//console.log ("state: " + state + ", button: " + activeButton);
            if (flag)
            {
                questInfo.category = 'Quest';
                saveActivity (pet, 'quest');
                stopTypewriter ();

                let e = document.getElementById(hideId);
                e.setAttribute("hidden", "1");
                document.getElementById('qchoice-p1').innerHTML = "";

                if (owner.food < 50)
                {
                    e = document.getElementById('globalmenu-qerror');
                    e.removeAttribute("hidden");

                    document.getElementById('pet-portrait-texture').src = updateQuestPic (`${questChoice.texture}`);
                    document.getElementById('pet-portrait-texture').setAttribute("style", '');
                    document.getElementById('pet-portrait-texture').removeAttribute("hidden");

                    setStateInfo('globalmenu-qerror');
                    setButtonInfo('adv_quest');
                }
                else
                {
                    oldPet = pet;
                    oldOwner = owner;
                    accumStat.food = -50;
                    //console.log ("saving food value");
                    saveFood (accumStat.food);

                    e = document.getElementById('globalmenu-qchoice');
                    e.removeAttribute("hidden");

                    // -------------------------------------------------------------
                    // Emote & Face processing
                    showEmoticon (questChoice.emoticon);
                    showPetFace (questChoice.faceImg);

                    e = document.getElementById('qchoice-name');
                    if (e)
                    {
                        e.innerHTML = `${pet.species}`;
                    }

                    setStateInfo('globalmenu-qchoice');
                    setButtonInfo('adv_quest');


                    let xhr = new XMLHttpRequest ();

                    // setup host name and the rest of the url by building parts
                    // and replacing others.
                    let host = location.protocol.concat("//").concat(window.location.host);
                    let path = window.location.pathname;
                    path = path.replace("public/index.php", "");
                    path = path + "api/quest_data.php";
                    let url = host + path + "?type=get_random_quest";
                    xhr.open ('GET', url);
                    xhr.setRequestHeader("Content-type", "application/json");
                    xhr.send ();
                    xhr.onreadystatechange = function ()
                    {
                        if (this.readyState === 4 && this.status === 200)
                        {
                            //console.log ("quest : " + this.responseText);
							let a = JSON.parse(this.responseText);
                            quest = a[0];
                            questChoice = a[1];
							//console.log ("selectQuestState: " + JSON.stringify(questChoice));

                            document.getElementById('pet-portrait-texture').src = updateQuestPic (`${questChoice.texture}`);
                            document.getElementById('pet-portrait-texture').setAttribute("style", '');
                            document.getElementById('pet-portrait-texture').removeAttribute("hidden");

                            setQuestText (questChoice.message, true);
                            document.getElementById('qchoice-p1').setAttribute(
                                "onclick", `selectQuestChoice ('${questChoice.actions[0]}'); return false;`);

                            setQuestInfo (quest.nextAction);
                            setStateInfo ('globalmenu-qchoice');
                        }
                    }
                }
            }
            else
            {
                let e = document.getElementById(hideId);
                e.setAttribute("hidden", "1");
                document.getElementById('pet-portrait-texture').src = `${pet.texture}`;
                toggleButtonImageOff ('adv_quest', 'img/global-button/button-quest.webp');
                setStateInfo ('none');
                setButtonInfo ('none');
			}
		}


        function selectQuestError (hideId)
        {
            let e = document.getElementById(hideId);
            e.setAttribute("hidden", "1");
            document.getElementById('pet-portrait-texture').src = `${pet.texture}`;
			setPetPortraitFilter(pet);

            toggleButtonImageOff ('adv_quest', 'img/global-button/button-quest.webp');
            toggleButtonImageOff ('adv_train', 'img/global-button/button-train.webp');

            setStateInfo ('none');
            setButtonInfo ('none');
		}

		// quest processing - player clicks text or action.
        function selectQuestChoice (choice)
        {
            // console.log("choice name : '" + choice + "', '" + questChoiceName + "'");
            if ((choice === "") && (questChoiceName !== ""))
            {
                choice = questChoiceName
			}


            if (choice === 'done')
            {
                console.log ("quest done");
                processQuestDone();
            }
            else if (choice !== "none")
            {
                let xhr = new XMLHttpRequest ();

                // setup host name and the rest of the url by building parts
                // and replacing others.
                let host = location.protocol.concat("//").concat(window.location.host);
                let path = window.location.pathname;
                path = path.replace("public/index.php", "");
                path = path + "api/quest_data.php";
                let url = host + path + `?type=get_quest_choice&quest_id=${quest.id}&action_name=${choice}`;
                xhr.open ('GET', url);
                xhr.setRequestHeader("Content-type", "application/json");
                xhr.send ();
                xhr.onreadystatechange = function ()
                {
                    if (this.readyState === XMLHttpRequest.DONE)
                    {
                        if (this.status === 0 || (this.status >= 200 && this.status < 400))
                        {
                            //console.log ("choice: " + this.responseText);
                            let a = JSON.parse(this.responseText);
                            questChoice = a[0];
                            statTest = a[1];
                            statCost = a[2];
                            //console.log ("loaded choice: " + questChoice.id + ", '" + choice + "'");
                            //console.log (JSON.stringify(questChoice));
							//console.log ("loaded cost (statCost) : " + JSON.stringify(statCost));

                            document.getElementById('pet-portrait-texture').src = updateQuestPic (`${questChoice.texture}`);
                            document.getElementById('pet-portrait-texture').setAttribute("style", '');
                            //console.log ("count :" + questChoice.choiceCount);

							if (questChoice.type === "choice")
                            {
                                document.getElementById('globalmenu-qdialogue').hidden = true;
                                document.getElementById('globalmenu-qchoice').removeAttribute("hidden");

                                let base = 'qchoice-choice4';
                                let choicesId = 'qchoice-choices4';
                                if (questChoice.choiceCount === 3)
                                {
                                    base = 'qchoice-choice3';
                                    choicesId = 'qchoice-choices3';
                                }
                                else if (questChoice.choiceCount === 2)
                                {
                                    base = 'qchoice-choice2';
                                    choicesId = 'qchoice-choices2';
                                }

                                document.getElementById('qchoice-choices2').hidden = true;
                                document.getElementById('qchoice-choices3').hidden = true;
                                document.getElementById('qchoice-choices4').hidden = true;

                                for (let i = 0; i < questChoice.choices.length; i++)
                                {
                                    let id = `${base}_${i + 1}`;
                                    let e = document.getElementById(id);
                                    if (e !== null)
                                    {
                                        let actionName = questChoice.actions[i];
                                        if (actionName !== '')
                                        {
                                            //console.log ("action: " + actionName);
                                            e.innerHTML = questChoice.choices[i];
                                            e.setAttribute('onclick', `selectQuestChoice ('${actionName}'); return false;`);
                                            e.removeAttribute('hidden');
                                        }
                                        else
                                        {
                                            e.setAttribute('hidden', '');
                                        }
                                    }
                                }

                                console.log("action: " + questChoice.action);
                                setQuestText(questChoice.message, true);

                                if (questChoice.choiceCount <= 1)
                                {
                                    // when there is only 1 action
                                    // put the action into the onclick handler for the text
                                    // and hide the choices
                                    document.getElementById('qchoice-p1').setAttribute(
                                        "onclick", `selectQuestChoice ('${questChoice.actions[0]}'); return false;`);

                                    document.getElementById(choicesId).setAttribute('hidden', "1");
                                }
                                else
                                {
                                    document.getElementById('qchoice-p1').removeAttribute('hidden');
                                    document.getElementById(choicesId).removeAttribute('hidden');
                                }

                                setStateInfo('globalmenu-qchoice');
                            }
                            else if (questChoice.type === "ask")
                            {
                                document.getElementById('globalmenu-qchoice').hidden = true;
                                document.getElementById('globalmenu-qdialogue').removeAttribute("hidden");

                                document.getElementById('qdialogue-choice1').hidden = true;
                                document.getElementById('qdialogue-choice2').hidden = true;
                                document.getElementById('qdialogue-choice3').hidden = true;
                                document.getElementById('qdialogue-choice4').hidden = true;
                                document.getElementById('qdialogue-choice5').hidden = true;

                                for (let i = 0; i < questChoice.choiceCount; i++)
                                {
									let name = 'qdialogue-choice' + (i + 1);
                                    let e = document.getElementById(name);
                                    let actionName = questChoice.actions[i];
                                    e.innerHTML = questChoice.choices[i];
                                    e.setAttribute('onclick', `selectQuestChoice ('${actionName}'); return false;`);
                                    e.removeAttribute('hidden');
                                }

                                document.getElementById('qdialogue_desc').innerHTML = questChoice.message;

                                setStateInfo('globalmenu-qdialogue');
							}

                            // -------------------------------------------------------------
							// Emote & face processing
                            showEmoticon (questChoice.emoticon);
                            showPetFace (questChoice.faceImg);


                            // --------------------------------------------------------------
							// Cost processing
                            //console.log ("cost obj: " + JSON.stringify(questChoice.actionCost));
                            if (questChoice.actionCost !== '')
                            {
                                console.log ("cost action: " + questChoice.actionCost);
                                if (questChoice.actionCost === '%FORAGE_COST_WIN%')
                                {
                                    statCost = food;
                                    statCost.food = food.cost;
                                    //console.log ("stat / food:  " + JSON.stringify(statCost));
 								}
                                if (questChoice.actionCost === '%FORAGE_COST_LOSE%')
                                {
                                    // if the pet looses the foraging test, then it still
									// get the stat gains but gets no food.
                                    food.cost = 0;
                                    statCost = food;
                                    statCost.food = food.cost;
                                    //console.log ("stat / food:  " + JSON.stringify(statCost));
                                }
                                else if (questChoice.actionCost === '%TRAIN_COST%')
                                {
                                    statCost = train;
                                    //console.log ("stat / train:  " + JSON.stringify(statCost));
								}

                                console.log ("cost: " + statCost.food + ", " + statCost.fatigue);
                                accumStat = accumulateQuestData(accumStat, statCost);
								processCost(statCost);
                            }

							// ---------------------------------------------------------
							// Command processing
                            if ((questChoice?.actionCmd !== '') && (wildPet?.id !== 0))
                            {
                                console.log ("action cmd: " + questChoice?.actionCmd);
								if (questChoice.actionCmd === "%GET_WILD_PET%")
                                {
                                    requestWildPet();
                                }
							}

                            // --------------------------------------------------------------
							// Test processing
                            if (questChoice.actionTest !== '')
                            {
                                console.log ("test: " + questChoice.actionTest);
                                let theAction;

                                if (questChoice.actionTest === "%ENTICE_WILD_PET%")
                                {
                                    let result = enticeWildPet(pet, wildPet);
                                    //result = true;
                                    //console.log ("wild pet entice: " + result);
									// check that the pet succeeded in the enticement and
									// that there space for the pet in the system.

                                    //console.log ("owner pets : " + owner.totalPets + ", " + (owner.totalPets < MAX_PLAYER_PETS));
                                    if ((result) && (owner.totalPets < MAX_PLAYER_PETS))
                                    {
                                        theAction = 'pet_entice_win';
                                        wildPet.isWild = false;
										wildPet.avuuid = owner.avId;
                                        wildPet.enabled = true;
										//savePet (wildPet);
                                    }
                                 	else
                                    {
                                         theAction = 'pet_entice_lose';
                                    }
                                }
                                else if (questChoice.actionTest === "%SPEAK_WILD_PET%")
                                {
                                    let result = speakWildPet(pet, wildPet);
                                    //result = false;
                                    //console.log ("wild pet speak: " + result);
                                    // check that the pet succeeded in the enticement and
                                    // that there space for the pet in hte system.
                                    if ((result) && (owner.totalPets < MAX_PLAYER_PETS))
                                    {
                                        theAction = 'pet_speak_win';
                                        /*
                                        wildPet.isWild = false;
                                        wildPet.avuuid = owner.avId;
                                        savePet (wildPet);
                                        */
                                    }
                                    else
                                    {
                                        theAction = 'pet_speak_lose';
                                    }
                                }
                                else if (questChoice.actionTest === "%FIGHT_WILD_PET%")
                                {
                                    let result = fightWildPet(pet, wildPet);
                                    //console.log ("fight result: " + result);
                                    // check that the pet succeeded in the fight and
                                    // that there space for the pet in hte system.
                                    if ((result) && (owner.totalPets < MAX_PLAYER_PETS))
                                    {
                                        theAction = 'pet_fight_win';
                                        wildPet.isWild = false;
                                        wildPet.avuuid = owner.avId;
                                        wildPet.enabled = true;
                                        //savePet (wildPet);
                                    }
                                    else
                                    {
                                        theAction = 'pet_fight_lose';
                                    }
                                }
                                else if (questChoice.actionTest === "%FORAGE_TEST%")
                                {
                                    //console.log ("action:  FOOD_TEST / " + questChoice.actionCost);
                                    if (checkForageRequirement (pet, food))
                                    {
                                        theAction = 'forage_win1';
                                    }
                                    else
                                    {
                                        // if unhealthy
                                        if (pet.health !== "Healthy")
                                        {
                                            theAction = 'forage_unhealthy1';
                                        }
                                        else
                                        {
                                            theAction = 'forage_lose1';
                                        }
                                    }
                                }
                                else if (questChoice.actionTest === "%TRAIN_TEST%")
                                {
                                    //console.log ("action:  TRAIN_TEST / " + questChoice.actionCost);
                                    if (pet.health === 'Healthy')
                                    {
                                        theAction = 'train_win1';
                                    }
                                    else
                                    {
										theAction = 'train_lose1';
                                    }
                                }
								else
                                {
                                    theAction = processTest(statTest);
                                }

                                if (theAction !== '')
                                {
                                    //console.log ("next action; " + theAction);
                                    questChoiceName = theAction;
                                    setQuestInfo (questChoiceName);
								}
							}

                            if (questChoice.questDone)
                            {
                                //console.log ("calling processQuestDone()");
                                processQuestDone ();
							}
                        }
                    }
                }
			}
            else
            {
                // default action ?
				//console.log ("set default action: '" + questChoice.actions[0] + "'");

                if (questChoice.actions[0] !== "")
                {
                    questChoiceName = questChoice.actions[0];
                    setQuestInfo(questChoiceName);
                    selectQuestChoice(questChoiceName);
                }
                else
                {
                    processQuestDone();
				}
			}

            return "false";
		}


        function accumulateQuestData (stats, obj)
        {
            let healthFactor = getHealthFactor (pet);

            stats.constitution += (obj.constitution) ? Math.floor (obj.constitution * healthFactor) : 0;
            stats.strength += (obj.strength) ? Math.floor (obj.strength * healthFactor) : 0;
            stats.agility += (obj.agility) ? Math.floor (obj.agility * healthFactor) : 0;
            stats.charm += (obj.charm) ? Math.floor (obj.charm * healthFactor) : 0;
            stats.confidence += (obj.confidence) ? Math.floor (obj.confidence * healthFactor) : 0;
            stats.empathy += (obj.empathy) ? Math.floor (obj.empathy * healthFactor) : 0;
            stats.intelligence += (obj.intelligence) ? Math.floor (obj.intelligence * healthFactor) : 0;
            stats.wisdom += (obj.wisdom) ? Math.floor (obj.wisdom * healthFactor) : 0;
            stats.sorcery += (obj.sorcery) ? Math.floor (obj.sorcery * healthFactor) : 0;
            stats.loyalty += (obj.loyalty) ? Math.floor (obj.loyalty * healthFactor) : 0;
            stats.spirituality += (obj.spirituality) ? Math.floor (obj.spirituality * healthFactor) : 0;
            stats.karma += (obj.karma) ? Math.floor (obj.karma * healthFactor) : 0;
            stats.food += (obj.food) ? Math.floor (obj.food * healthFactor) : 0;

            stats.fatigue += (obj.fatigue) ? obj.fatigue : 0;

            /*
			stats.constitution += (obj.constitution) ? obj.constitution * healthFactor) : 0;
            stats.strength += (obj.strength) ? obj.strength : 0;
            stats.agility += (obj.agility) ? obj.agility : 0;
            stats.charm += (obj.charm) ? obj.charm : 0;
            stats.confidence += (obj.confidence) ? obj.confidence : 0;
            stats.empathy += (obj.empathy) ? obj.empathy : 0;
            stats.intelligence += (obj.intelligence) ? obj.intelligence : 0;
            stats.wisdom += (obj.wisdom) ? obj.wisdom : 0;
            stats.sorcery += (obj.sorcery) ? obj.sorcery : 0;
            stats.loyalty += (obj.loyalty) ? obj.loyalty : 0;
            stats.spirituality += (obj.spirituality) ? obj.spirituality : 0;
            stats.karma += (obj.karma) ? obj.karma : 0;
            stats.food += (obj.food) ? obj.food : 0;
            stats.fatigue += (obj.fatigue) ? obj.fatigue : 0;
			*/
            //console.log ("accumulate obj : " + JSON.stringify(obj));
            //console.log ("accumulate stats : " + JSON.stringify(stats));
			return (stats);
		}

		function setQuestText (text, flag)
        {
            if (text.includes("%RANDOM_SAYING%", 0))
            {
                let xhr = new XMLHttpRequest ();

                // setup host name and the rest of the url by building parts
                // and replacing others.
                let host = location.protocol.concat("//").concat(window.location.host);
                let path = window.location.pathname;
                path = path.replace("public/index.php", "");
                path = path + "api/pet_data.php";
                let url = host + path + "?type=get_saying&category=" + questInfo.category;

                xhr.open ('GET', url, false);
                xhr.setRequestHeader("Content-type", "application/json");
                xhr.send (null);
                if ((xhr.status >= 200) && (xhr.status < 400))
                {
                    //console.log ("sync saying: " + xhr.responseText);
                    if (xhr.responseText !== undefined)
                    {
                        let obj = JSON.parse(xhr.responseText);
                        text = text.replace("%RANDOM_SAYING%", obj.text.trim());
                    }
                }
            }


            text = formatQuestText(text, accumStat.food, accumStat.fatigue);
	        let e = document.getElementById('qchoice-p1');
            if (flag)
            {
                stopTypewriter ();

                e.innerHTML = "";
                e.setAttribute("data-typewriter", text);

                typeWriter = new Typewriter(e, { speed: typewriterSpeed, repeat: typewriterRepeat, delay: typewriterDelay });
                e.removeAttribute("hidden");
			}
            else
            {
                e.innerHTML = text;
            }
		}


        function formatQuestText (str, foodCost, fatigueCost)
        {
            //console.log ("string: " + str);
            if (str)
            {
                if (pet.health !== "Healthy")
                {
                	str = str.replaceAll ("%FOOD_MSG_SICK%", "Regrettably, %PET_NAME%'s little paws grew tired and couldn't collect all the food.");
                }
                else
                {
                    str = str.replaceAll ("%FOOD_MSG_SICK%", "");
                }

                str = str.replaceAll("%PET_NAME%", pet.species);
                str = str.replaceAll("%FOOD_COST%", Math.abs ((foodCost ? foodCost : 0)));
                str = str.replaceAll("%FOOD_NAME%", food?.type);
                str = str.replaceAll("%TRAIN_NAME%", train?.type);
				str = str.replaceAll("%FATIGUE_COST%", (fatigueCost ? fatigueCost : 0));
                str = str.replaceAll("%REGION_NAME%", owner.region);

                if (str.includes('%FATIGUE_MSG%', 0))
                {
                    let fatigue = (fatigueCost ? fatigueCost : 0);
                    if (fatigue >= 0)
                    {
                        str = str.replaceAll ('%FATIGUE_MSG%', `Your pet has gained ${fatigue} fatigue points for completing this quest.`);
                    }
                    else if (fatigue < 0)
                    {
                        str = str.replaceAll ('%FATIGUE_MSG%', `Your pet has lost ${Math.abs(fatigue)} fatigue points for completing this quest.`);
                    }
                }

                if (str.includes("%STAT_COST%", 0))
                {
                    //console.log ("quest accumulation: " + JSON.stringify(accumStat));
                    let s = '<br/>';
                    s += `${getAdjustmentObject2(oldPet, accumStat, 'pos')} `;
                    s += `${getAdjustmentObject2(oldPet, accumStat, 'neg')} `;
                    str = str.replaceAll ("%STAT_COST%", s);
                }

                if (str.includes("%FOOD_STAT_COST%", 0))
                {
                    //console.log ("food stat cost here");
                    let s = '';
                    s += `${getAdjustmentObject2(oldOwner, accumStat, 'food')} `;
                    str = str.replaceAll ("%FOOD_STAT_COST%", s);
                }

                if (str.includes("%FATIGUE_STAT_COST%", 0))
                {
                    let s = '';
                    s += `${getAdjustmentObject2(oldPet, accumStat, 'fatigue')} `;
                    str = str.replaceAll ("%FATIGUE_STAT_COST%", s);
                }

                if (str.includes ("%HABITAT_NAME%", 0))
                {
                    if (! habitat.name)
                    {
                    	habitat.name = "Plain";
					}
                    str = str.replaceAll("%HABITAT_NAME%", habitat.name);

				}
            }
            return (str);
		}


        function updateQuestPic (picName)
        {
            if (picName)
            {
                if (picName === "%RANDOM_HABITAT_TEXTURE%") {

                    //console.log ("region: " + owner.region);
                    let xhr = new XMLHttpRequest ();

                    // setup host name and the rest of the url by building parts
                    // and replacing others.
                    let host = location.protocol.concat("//").concat(window.location.host);
                    let path = window.location.pathname;
                    path = path.replace("public/index.php", "");
                    path = path + "api/location.php";
                    let url = host + path

                    let data = {
                    	type: "get_random_habitat_pic",
						region: `${owner.region}`
					};
                    xhr.open ('POST', url, false);
                    xhr.setRequestHeader("Content-type", "application/json");
                    xhr.send (JSON.stringify (data));
                    if ((xhr.status >= 200) && (xhr.status < 400))
                    {
                        // console.log ("sync habitat: '" + xhr.responseText + "'");
                        if ((xhr.responseText !== undefined) && (xhr.responseText.length > 0))
                        {
                            habitat = JSON.parse(xhr.responseText);
                            //console.log ("habitat load: " + JSON.stringify (habitat));
                        }

                        picName = picName.replace("%RANDOM_HABITAT_TEXTURE%", habitat.texture);
                    }
				}

                picName = picName.replace("%WILD_PET_TEXTURE%", wildPet.texture);
                picName = picName.replace("%FOOD_TEXTURE%", food?.texture);
                picName = picName.replace("%TRAIN_TEXTURE%", train?.texture);
                picName = picName.replace("%HABITAT_TEXTURE%", habitat?.texture);
            }
            return (picName);
        }


        function processQuestDone ()
        {
            document.getElementById('pet-portrait-texture').src = `${pet.texture}`;
            setPetPortraitFilter(pet);
            document.getElementById('qchoice-p1').hidden = true;
            document.getElementById('qchoice-choices2').hidden = true;
            document.getElementById('qchoice-choices3').hidden = true;
            document.getElementById('qchoice-choices4').hidden = true;

            //console.log ("active button: " + activeButton);
            //console.log ("active state: " + state);
            setStateInfo ('none');
            setButtonInfo ('none');

            // if the wild pet has been assigned to the player
			// then save the pet and update the selector
            if (wildPet.isWild === false)
            {
                // console.log ("saving wild pet.");
				wildPet.id = 0;
                wildPet.avuuid = owner.avId;
                wildPet.enabled = true;

                // set wild pet back to 10's
				wildPet.constitution = 10;
				wildPet.strength = 10;
				wildPet.agility = 10;

				wildPet.wisdom = 10;
				wildPet.intelligence = 10;
				wildPet.sorcery = 10;

				wildPet.charm = 10;
				wildPet.confidence = 10;
				wildPet.empathy = 10;

				wildPet.loyalty = 10;
				wildPet.spirituality = 10;
				wildPet.karma = 10;

                savePet(wildPet);
                updatePetSelector();
            }

            toggleButtonImageOff ('adv_quest', 'img/global-button/button-quest.webp');
            //console.log ('quest cat: ' + questInfo.category);
            if (questInfo.category === "Train")
            {
                toggleButtonImageOff ('adv_train', 'img/global-button/button-train.webp');
			}
			else if (questInfo.category === "Forage")
            {
                toggleButtonImageOff ('chore_forage', 'img/global-button/button-forage.webp');
            }
			else if (questInfo.category === "Rest")
            {
                toggleButtonImageOff ('chore_rest', 'img/global-button/button-rest.webp');
            }

            // remove any food or training data once the quest is over.
            oldPet = {};
            oldOwner = {};

            quest = {};
            accumStat = {
                constitution: 0,
                strength: 0,
                agility: 0,
                charm: 0,
                confidence: 0,
                empathy: 0,
                intelligence: 0,
                wisdom: 0,
                sorcery: 0,
                loyalty: 0,
                spirituality: 0,
                karma: 0,
                food: 0,
                fatigue: 0
            };
            questChoice = {};
            statTest = {};
            statCost = {};
            questInfo = {};
			food = {};
            train = {};

            setTimeout(function ()
            {
                getSaying(pet);
            }, 2000);
		}



        function processTest (test)
        {
            //console.log ("processing test: " + test.action);
            let actionName = test.winAction;
			let win = testStats (pet, test);
            if (win === false)
            {
                actionName = test.loseAction;
			}

            return (actionName);
		}


        function processCost (qCost)
        {
            //console.log ("processing cost:  save - " + JSON.stringify(qCost));
            saveStatsData (pet, qCost);
		}

        function requestWildPet ()
        {
            let xhr = new XMLHttpRequest ();

            // setup host name and the rest of the url by building parts
            // and replacing others.
            let host = location.protocol.concat("//").concat(window.location.host);
            let path = window.location.pathname;
            path = path.replace("public/index.php", "");
            path = path + "api/pet_data.php";
            let url = host + path + "?type=get_wild_pet";

            xhr.open ('GET', url);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.send ();
            xhr.onreadystatechange = function ()
            {
                if (this.readyState === XMLHttpRequest.DONE)
                {
                    if (this.status === 0 || (this.status >= 200 && this.status < 400))
                    {
                        //console.log ("wild_pet: " + this.responseText);
                        wildPet = JSON.parse(this.responseText);
					}
                }
            }
		}




        // ----------------------------------------------------------------------
        // formulas
        // -----------------------------------------------------------------------

        function sigmoidCurve (x, k, x0, xScale = 1, yScale = 1, xShift = 0, yShift = 0)
        {
            // k = steepness of curve
			// x0 = transition point of curve
			// xScale, yScale = scale function on X or Y axis
			// xShift, yShift = shift plot on specified axis
			const exponent = -k * xScale *  (x - x0 - xShift);
            return ((100 / (1 + Math.exp(exponent))) * yScale) + yShift;
		}


        // ----------------------------------------------------------------------
        function fightWildPet (thePet, aWildPet)
        {
            let steepness = 0.015;
            let transition_point = 85;
            // fighting stats  STR, AGI, WIS, & SOR
            let strNd = sigmoidCurve (thePet.strength - aWildPet.strength, steepness, transition_point);
            let agiNd = sigmoidCurve (thePet.agility - aWildPet.agility, steepness, transition_point);
            let wizNd = sigmoidCurve (thePet.wisdom - aWildPet.wisdom, steepness, transition_point);
            let sorNd = sigmoidCurve (thePet.sorcery - aWildPet.sorcery, steepness, transition_point);

            let chance = (((strNd + agiNd + wizNd + sorNd) / 4.0) / 100);
            let rnd = Math.random();

            console.log ("fight pet :" + (rnd < chance) + ", " + chance.toFixed(5) + ", " + rnd.toFixed(5));

            return (rnd < chance);
        }

        // -----------------------------------------------------------------------
        function enticeWildPet (thePet, aWildPet)
        {
            let steepness = 0.015;
            let transition_point = 85;

            // charisma stats  CHA, CFD, EMP
            let x = sigmoidCurve ((thePet.charm * 2) - (aWildPet.charm * 2), steepness, transition_point);
            let y = sigmoidCurve ((thePet.confidence) - (aWildPet.confidence), steepness, transition_point);
            let z = sigmoidCurve (thePet.empathy - aWildPet.empathy, steepness, transition_point);

            let chance = (((x + y + z) / 4.0) / 100);
            let rnd = Math.random();

            console.log ("entice pet :" + (rnd < chance) + ", " + chance.toFixed(5) + ", " + rnd.toFixed(5));

            return (rnd < chance);
        }

        // -----------------------------------------------------------------------
        function speakWildPet (thePet, aWildPet)
        {
            let steepness = 0.012;
            let transition_point = 10;

            // speaking stats CFI, EMP
            let x = sigmoidCurve ((thePet.confidence * 4) - (aWildPet.confidence * 4), steepness, transition_point);
            let y = sigmoidCurve ((thePet.empathy) - (aWildPet.empathy), steepness, transition_point);

            let chance = (((x + y) / 5.0) / 100.0);
            let rnd = Math.random();

            console.log ("speak pet :" + (rnd < chance) + ", " + chance.toFixed(5) + ", " + rnd.toFixed(5));

            return (rnd < chance);
        }





        // ------------------------------------------------------------------------
		// Pet inventory control
        function petSelect(element, id, petId, listIdx)
        {
            //console.log (id + ", " + petId + ", " + listIdx);
            if (petId)
            {
                if ((state === 'none') ||
                    (state === 'globalmenu-training3') ||
                    (state === 'globalmenu-foraging3') ||
                    (state === 'globalmenu-qopening1') ||
                    (state === 'petmenu-profile') ||
                    (state === 'petmenu-stats') ||
                    (state === 'petmenu-health') ||
                    (state === 'petmenu-action'))
                {
                    // ajax call to get new pet.
                    loadPet(petId, listIdx);

                    // loop through all the pets shown and
                    // set the active border or the inactive border for each pet.
                    for (let i = 1; i < PETS_PET_PAGE; i++)
                    {
                        let cId = 'pet-thumb-frame-' + i;
                        let e = document.getElementById(cId);
                        if (e)
                        {
                            if (id === cId) e.src = "img/pet-selector/petslot-active.webp";
                            else e.src = "img/pet-selector/petslot-inactive.webp";
                        }
                    }
                }
            }
            return false;
        }

        function doPage (element, currentPage, pageInc)
        {

            if ((state === 'none') ||
                (state === 'globalmenu-training3') ||
                (state === 'globalmenu-foraging3') ||
                (state === 'globalmenu-qopening1') ||
                (state === 'petmenu-profile') ||
                (state === 'petmenu-stats') ||
                (state === 'petmenu-health') ||
                (state === 'petmenu-action'))
            {
                let xhr = new XMLHttpRequest();

                //alert ("current page: " + currentPage + "\n" +
                //	"page inc: " + pageInc + "\n" +
                //    "page offset: " + pageOffset + "\n" +
                //	"page total: " + pageTotal + "\n" +
                //    "page: " + pageIndex + "\n" +
                //	"pet total : " + petTotal);


                // setup host name and the rest of the url by building parts
                // and replacing others.
                let host = location.protocol.concat("//").concat(window.location.host);
                let path = window.location.pathname;
                path = path.replace("public/index.php", "");
                path = path + "api/pet_data.php";
                let url = host + path + "?type=page&current_page=" + currentPage + "&page_inc=" + pageInc;

                xhr.open('GET', url);
                xhr.setRequestHeader("Content-type", "application/json");
                xhr.send();
                xhr.onreadystatechange = function ()
                {
                    if (this.readyState === 4 && this.status === 200)
                    {
                        //alert (this.responseText);
                        location.reload();
                    }
                }
            }
        }

        function loadPet (petId, index)
        {
            if (petId)
            {
                let xhr = new XMLHttpRequest();

                // or as you probably should do
                let host = location.protocol.concat("//").concat(window.location.host);
                let path = window.location.pathname;
                path = path.replace("public/index.php", "");
                path = path + "api/pet_data.php";
                let url = host + path + "?type=get&pet_id=" + petId + "&index=" + index;

                //alert (url);

                xhr.open('GET', url);
                xhr.setRequestHeader("Content-type", "application/json");
                xhr.send();
                xhr.onreadystatechange = function ()
                {
                    if (this.readyState === 4 && this.status === 200)
                    {
                        //alert (this.responseText);
                        //console.log("pet id " + petId + ", " + index);
                        // console.log ("hide pet msg. " + activeButton);
                        document.getElementById('pet-portrait-msg').setAttribute("hidden", "");
                        showEmoticon("none");
                        showPetFace ("none");
                        pet = JSON.parse(this.responseText);
                        loadPetData(pet)
                    }
                }
            }


        }

        function loadPetData ()
        {
			// alert ("loadPetData " + JSON.stringify(pet));
			if ((state === 'none') ||
				(state === 'petmenu-profile') ||
				(state === 'petmenu-stats') ||
				(state === 'petmenu-health') ||
				(state === 'petmenu-action'))
			{
				document.getElementById('pet-portrait-texture').src = `${pet.texture}`;
            	setPetPortraitFilter(pet);
			}

            // main pet information
            document.getElementById('pet-name-text').innerHTML = `${pet.species}`;
            document.getElementById('pet-id-text').innerHTML = `#${pet.petNumber}`;
            document.getElementById('pet-frame').src = `${pet.attributeTexture}`;

            // ------------------------------------------------------------
			// forage id values
			document.getElementById('forage-texture').src = `${pet.texture}`;

            if (pet.health === "Dead")
            {
                // id="train-pet-buttons" - need to hide if dead
                document.getElementById('forage-button-div1').setAttribute("hidden", "1");
                document.getElementById('forage-button-div2').setAttribute("hidden", "1");

                // <p id="train-msg" class="c-title">Choose the pet you wish to train for <span class="c-title2">Endurance Training</span>.<p>
                document.getElementById('forage-msg').innerHTML = "You can't select a dead pet for this action. Please choose another pet.";

                // greyscale if dead
                //  "filter:none;-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);";
                document.getElementById('forage-texture').style = "border: 0.35vw solid #f1de6f;border-radius: 2vw; filter:none;-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);";
            }
            else
            {
                document.getElementById('forage-button-div1').removeAttribute("hidden");
                document.getElementById('forage-button-div2').removeAttribute("hidden");

                document.getElementById('forage-texture').style = "border: 0.35vw solid #f1de6f;border-radius: 2vw;";

                // <p id="train-msg" class="c-title">Choose the pet you wish to train for <span class="c-title2">Endurance Training</span>.<p>
                document.getElementById('forage-msg').innerHTML = 'Choose the pet you wish to forage for <span id="foraging3-foodname" class="c-title2"><?php echo $foodName?></span>.';
                let e = document.getElementById('foraging3-foodname');
                if (e) 	e.innerHTML = foodName;
            }


			document.getElementById('forage-species').innerHTML = `${pet.species}`;
			document.getElementById('forage-petNumber').innerHTML = `${pet.petNumber}`;

			document.getElementById('forage-fitness').innerHTML = `max ${pet.fitnessMax}`;
			document.getElementById('forage-constitution').innerHTML = `${pet.constitution}`;
			document.getElementById('forage-strength').innerHTML = `${pet.strength}`;
			document.getElementById('forage-agility').innerHTML = `${pet.agility}`;

			document.getElementById('forage-wizardry').innerHTML = `max ${pet.wizardryMax}`;
			document.getElementById('forage-wisdom').innerHTML = `${pet.wisdom}`;
			document.getElementById('forage-intelligence').innerHTML = `${pet.intelligence}`;
			document.getElementById('forage-sorcery').innerHTML = `${pet.sorcery}`;

			document.getElementById('forage-charisma').innerHTML = `max ${pet.charismaMax}`;
			document.getElementById('forage-charm').innerHTML = `${pet.charm}`;
			document.getElementById('forage-confidence').innerHTML = `${pet.confidence}`;
			document.getElementById('forage-empathy').innerHTML = `${pet.empathy}`;

			document.getElementById('forage-nature').innerHTML = `max ${pet.natureMax}`;
			document.getElementById('forage-loyalty').innerHTML = `${pet.loyalty}`;
			document.getElementById('forage-spirituality').innerHTML = `${pet.spirituality}`;
			document.getElementById('forage-karma').innerHTML = `${pet.karma}`;
            document.getElementById('forage-fatigue').innerHTML = `${pet.fatigue}`;

            // ---------------------------------------------------
			// training id values
            document.getElementById('train-texture').src = `${pet.texture}`;

            if (pet.health === "Dead")
            {
                // id="train-pet-buttons" - need to hide if dead
                document.getElementById('train_pet_div1').setAttribute("hidden", "1");
                document.getElementById('train_pet_div2').setAttribute("hidden", "1");

                // <p id="train-msg" class="c-title">Choose the pet you wish to train for <span class="c-title2">Endurance Training</span>.<p>
                document.getElementById('train-msg').innerHTML = "You can't select a dead pet for this action. Please choose another pet.";

                // greyscale if dead
                // document.getElementById('pet_image_<?php echo $i + 1?>').style = "filter:none;-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);";
                document.getElementById('train-texture').style = "border: 0.35vw solid #f1de6f;border-radius: 2vw; filter:none;-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);";
            }
            else
            {
                // restore possible items that may have been changed if pet is not dead
                document.getElementById('train_pet_div1').removeAttribute("hidden");
                document.getElementById('train_pet_div2').removeAttribute("hidden");

                document.getElementById('train-texture').style = "border: 0.35vw solid #f1de6f;border-radius: 2vw;";

                // <p id="train-msg" class="c-title">Choose the pet you wish to train for <span class="c-title2">Endurance Training</span>.<p>
                document.getElementById('train-msg').innerHTML = "Choose the pet you wish to train for <span id='globalmenu-training3-name' class='c-title2'>Endurance Training</span>.";
                let e = document.getElementById('globalmenu-training3-name');
                if (e) 	e.innerHTML = trainName;
            }

			document.getElementById('train-species').innerHTML = `${pet.species}`;
			document.getElementById('train-petNumber').innerHTML = `${pet.petNumber}`;

			document.getElementById('train-fitness').innerHTML = `max ${pet.fitnessMax}`;
			document.getElementById('train-constitution').innerHTML = `${pet.constitution}`;
			document.getElementById('train-strength').innerHTML = `${pet.strength}`;
			document.getElementById('train-agility').innerHTML = `${pet.agility}`;

			document.getElementById('train-wizardry').innerHTML = `max ${pet.wizardryMax}`;
			document.getElementById('train-wisdom').innerHTML = `${pet.wisdom}`;
			document.getElementById('train-intelligence').innerHTML = `${pet.intelligence}`;
			document.getElementById('train-sorcery').innerHTML = `${pet.sorcery}`;

			document.getElementById('train-charisma').innerHTML = `max ${pet.charismaMax}`;
			document.getElementById('train-charm').innerHTML = `${pet.charm}`;
			document.getElementById('train-confidence').innerHTML = `${pet.confidence}`;
			document.getElementById('train-empathy').innerHTML = `${pet.empathy}`;

			document.getElementById('train-nature').innerHTML = `max ${pet.natureMax}`;
			document.getElementById('train-loyalty').innerHTML = `${pet.loyalty}`;
			document.getElementById('train-spirituality').innerHTML = `${pet.spirituality}`;
			document.getElementById('train-karma').innerHTML = `${pet.karma}`;
            document.getElementById('train-fatigue').innerHTML = `${pet.fatigue}`;

            // -----------------------------------------------------------------
			// stats page
			document.getElementById('stat-species').innerHTML = `${pet.species}`;
			document.getElementById('stat-petNumber').innerHTML = `${pet.petNumber}`;

			document.getElementById('stat-grade').innerHTML = `${pet.grade}`;
			document.getElementById('stat-personality').innerHTML = `${pet.personality}`;
			document.getElementById('stat-attribute').innerHTML = `${pet.attribute}`;
			document.getElementById('stat-fitnessRankTier').innerHTML = `${pet.fitnessRankTier}`;
			document.getElementById('stat-wizardryRankTier').innerHTML = `${pet.wizardryRankTier}`;
			document.getElementById('stat-charismaRankTier').innerHTML = `${pet.charismaRankTier}`;
			document.getElementById('stat-natureRankTier').innerHTML = `${pet.natureRankTier}`;

			document.getElementById('stat-fitness').innerHTML = `max ${pet.fitnessMax}`;
			document.getElementById('stat-constitution').innerHTML = `${pet.constitution}`;
			document.getElementById('stat-strength').innerHTML = `${pet.strength}`;
			document.getElementById('stat-agility').innerHTML = `${pet.agility}`;

			document.getElementById('stat-wizardry').innerHTML = `max ${pet.wizardryMax}`;
			document.getElementById('stat-wisdom').innerHTML = `${pet.wisdom}`;
			document.getElementById('stat-intelligence').innerHTML = `${pet.intelligence}`;
			document.getElementById('stat-sorcery').innerHTML = `${pet.sorcery}`;

			document.getElementById('stat-charisma').innerHTML = `max ${pet.charismaMax}`;
			document.getElementById('stat-charm').innerHTML = `${pet.charm}`;
			document.getElementById('stat-confidence').innerHTML = `${pet.confidence}`;
			document.getElementById('stat-empathy').innerHTML = `${pet.empathy}`;

			document.getElementById('stat-nature').innerHTML = `max ${pet.natureMax}`;
			document.getElementById('stat-loyalty').innerHTML = `${pet.loyalty}`;
			document.getElementById('stat-spirituality').innerHTML = `${pet.spirituality}`;
			document.getElementById('stat-karma').innerHTML = `${pet.karma}`;

            // --------------------------------------------------------------------
			// quest page

			document.getElementById('quest-species').innerHTML = `${pet.species}`;
			document.getElementById('quest-petNumber').innerHTML = `${pet.petNumber}`;
            document.getElementById('quest-texture').src = `${pet.texture}`;

            if (pet.health === "Dead")
            {
                // id="train-pet-buttons" - need to hide if dead
                document.getElementById('quest-button-div1').setAttribute("hidden", "1");
                document.getElementById('quest-button-div2').setAttribute("hidden", "1");

                // <p id="train-msg" class="c-title">Choose the pet you wish to train for <span class="c-title2">Endurance Training</span>.<p>
                document.getElementById('quest-msg').innerHTML = "You can't select a dead pet for this action. Please choose another pet.";

                // greyscale if dead
                // "filter:none;-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);";
                document.getElementById('quest-texture').style = "border: 0.35vw solid #f1de6f;border-radius: 2vw; filter:none;-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);";
            }
            else
            {
                // restore possible items that may have been changed if pet is not dead
                document.getElementById('quest-button-div1').removeAttribute("hidden");
                document.getElementById('quest-button-div2').removeAttribute("hidden");

                document.getElementById('quest-texture').style = "border: 0.35vw solid #f1de6f;border-radius: 2vw;";

                // <p id="train-msg" class="c-title">Choose the pet you wish to train for <span class="c-title2">Endurance Training</span>.<p>
                document.getElementById('quest-msg').innerHTML = 'Select the pet of your choice to embark on a <span class="c-title2">random quest</span>. <span class="c-title3">(-50 Food)</span>';
            }


			document.getElementById('quest-fitness').innerHTML = `max ${pet.fitnessMax}`;
			document.getElementById('quest-constitution').innerHTML = `${pet.constitution}`;
			document.getElementById('quest-strength').innerHTML = `${pet.strength}`;
			document.getElementById('quest-agility').innerHTML = `${pet.agility}`;

			document.getElementById('quest-wizardry').innerHTML = `max ${pet.wizardryMax}`;
			document.getElementById('quest-wisdom').innerHTML = `${pet.wisdom}`;
			document.getElementById('quest-intelligence').innerHTML = `${pet.intelligence}`;
			document.getElementById('quest-sorcery').innerHTML = `${pet.sorcery}`;

			document.getElementById('quest-charisma').innerHTML = `max ${pet.charismaMax}`;
			document.getElementById('quest-charm').innerHTML = `${pet.charm}`;
			document.getElementById('quest-confidence').innerHTML = `${pet.confidence}`;
			document.getElementById('quest-empathy').innerHTML = `${pet.empathy}`;

			document.getElementById('quest-nature').innerHTML = `max ${pet.natureMax}`;
			document.getElementById('quest-loyalty').innerHTML = `${pet.loyalty}`;
			document.getElementById('quest-spirituality').innerHTML = `${pet.spirituality}`;
			document.getElementById('quest-karma').innerHTML = `${pet.karma}`;

			// release screen
			document.getElementById("release_pet_name").innerHTML = `${pet.species} (#${pet.petNumber})`;

            // health page
            document.getElementById("health-health").innerHTML = `${pet.health}`;

            // calculate the pet specific health ranges.
            let healthy = '0';
            let tired = Math.floor((pet.constitution + (pet.loyalty * 0.25)) * 1.0).toString();
            let rundown = Math.floor((pet.constitution + (pet.loyalty * 0.25)) * 2.0).toString();
            let sick = Math.floor((pet.constitution + (pet.loyalty * 0.25)) * 3.0).toString();
            let critical = Math.floor((pet.constitution + (pet.loyalty * 0.25)) * 4.0).toString();
            let dead = Math.floor((pet.constitution + (pet.loyalty * 0.25)) * 5.0).toString();

            //console.log ("pet health: '" + pet.health + "'");
            if (pet.health === "Healthy") { healthy = healthy + "*"; }
            else if (pet.health === "Tired")  { tired = tired + "*"; }
            else if (pet.health === "Run Down")  { rundown = rundown + "*"; }
            else if (pet.health === "Sick")  { sick = sick + "*"; }
            else if (pet.health === "Critical")  { critical = critical + "*"; }
            else if (pet.health === "Dead")  { dead = dead + "*"; }

            document.getElementById('gps_healthy').innerHTML = ` ${healthy}`;
            document.getElementById('gps_tired').innerHTML = ` - ${tired}`;
            document.getElementById('gps_rundown').innerHTML = ` - ${rundown}`;
            document.getElementById('gps_sick').innerHTML = ` - ${sick}`;
            document.getElementById('gps_critical').innerHTML = ` - ${critical}`;
            document.getElementById('gps_dead').innerHTML = ` - ${dead}`;

            let e = document.getElementById("health-fatigue");
            e.innerHTML = `${pet.fatigue}`;
            e.style.color = healthColors[pet.health];
            document.getElementById('health-fatigue_text').style.color = healthColors[pet.health];
            document.getElementById('health-health').style.color = healthColors[pet.health];
            document.getElementById('health-health_text').style.color = healthColors[pet.health];

            updatePetSelector ();

            if (activeButton === 'none')
            {
                getSaying(pet);
            }
		}

        function loadOwnerData ()
        {

            let e = document.getElementById('global_action_points');
            e.innerHTML = `${owner.actionPoints + " / " + owner.apMax}`;
            e = document.getElementById('global_food');
            e.innerHTML = `${owner.food}`;
            e = document.getElementById('global_total_pets');
            e.innerHTML = `${owner.totalPets}`;
        }

		function updatePetSelector ()
        {
            let xhr = new XMLHttpRequest();

            // create URL
            let host = location.protocol.concat("//").concat(window.location.host);
            let path = window.location.pathname;
            path = path.replace("public/index.php", "");
            path = path + "api/pet_data.php";
            let url = host + path + "?type=get_pet_list&current_page=" + pageIndex;

            xhr.open('GET', url);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.send();
            xhr.onreadystatechange = function ()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    //console.log ("petList: " + this.responseText);
                    petList = JSON.parse(this.responseText);

                    //console.log ("pet list len: " + petList.length);
                    for (let i = 0; i < petList.length; i++)
                    {
                        //console.log ("list: " + petList[i].id + ", " + pet.id);
                        let pi = petList[i];
                        let cId;

                        // toggle the active frame for the pet selector
						// if not the actively slected pet, change to the inactive border all the time.
                        cId = 'pet-thumb-frame-' + (i + 1);
                        if (pi.id == pet.id)
                        {
                            document.getElementById(cId).src = "img/pet-selector/petslot-active.webp";
                        }
                        else
                        {
                            document.getElementById(cId).src = "img/pet-selector/petslot-inactive.webp";
						}

                        // always set the onclick handler, since the coce coule have juat
						// added a pet to the selector.
                        document.getElementById(cId).onclick = function (e) { petSelect(this, cId, pi.id, i); return false; };


                        cId = 'pet_image_' + (i + 1);
                        document.getElementById(cId).src = `${pi.texture}`;

                        cId = 'pet-number-' + (i + 1);
                        document.getElementById(cId).innerHTML = `${i + 1}`

                        // check the pet health and change the color of the pet number to indicate health level
                        let health = pi["health"];
                        //console.log ("sick pet: " + pi.id + ", " + health);
                        let e = document.getElementById(`pet-number-${i+1}`);
                        if (e)
                        {
                            if (health === "Sick")
                            {
                                e.style.color = "#ff0000";
                            }
                            else if (health === "Critical")
                            {
                                e.style.color = "#bf00ff";
                            }
                            else
                            {
                                // restore color back to normal white.
                                e.style.color = "#ffffff";
                            }
                        }

                        if (health === 'Dead')
                        {
							// greyscale if dead
							//  "filter:none;-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);";
                            document.getElementById(`pet_image_${i+1}`).setAttribute("style", "filter:none;-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);");
                        }
                        else
                        {
                            e = document.getElementById(`pet_image_${i+1}`);
                            e.setAttribute("style", "");
						}
                    }
                }
            }
		}


        // attribute filter
        function filterSelect (element, attribute)
        {

            if ((state === 'none') ||
                (state === 'globalmenu-training3') ||
                (state === 'globalmenu-foraging3') ||
                (state === 'globalmenu-qopening1') ||
                (state === 'petmenu-profile') ||
                (state === 'petmenu-stats') ||
                (state === 'petmenu-health') ||
                (state === 'petmenu-action'))
            {
                let filter = attribute;
                //alert (filter + ", " + '< ?php echo $attribFilter?>');

                if (filter === '<?php echo $attribFilter?>')
                {
                    filter = 'none';
                }

                let xhr = new XMLHttpRequest();

                // create URL
                let host = location.protocol.concat("//").concat(window.location.host);
                let path = window.location.pathname;
                path = path.replace("public/index.php", "");
                path = path + "api/pet_data.php";
                let url = host + path + "?type=filter&attr=" + filter;

                xhr.open('GET', url);
                xhr.setRequestHeader("Content-type", "application/json");
                xhr.send();
                xhr.onreadystatechange = function ()
                {
                    if (this.readyState === 4 && this.status === 200)
                    {
                        //alert (this.responseText);
                        petList = JSON.parse(this.responseText);
                        //console.log (JSON.stringify($obj, null, 2));
                        location.reload();
                        updatePetSelector ();
                    }
                }
            }
        }


	</script>
</head>
<body onload="loadContext()">
<section class="top-convas">

<!-- ############################################################ -->
<!-- PET MENU:PROFILE -->
    <div hidden id="petmenu-profile" class="petmenu roboto ts-screen tlh-120">
        <p style="color: #fff;">Species: <span id="stat-species"><?php echo $pet->species?></span> (#<span id="stat-petNumber"><?php echo $pet->petNumber?></span>)</p>
        <p class="c-common">Grade: <span id="stat-grade"><?php echo $pet->grade?></span></p>
        <p style="color: #f49bff">Personality: <span id="stat-personality"><?php echo $pet->personality?></span></p>
        <p class="c-plant">Attribute: <span id="stat-attribute"><?php echo $pet->attribute?></span></p>
        <br>
        <p style="color: #fff;"><u>Talent Ratings:</u></p>
        <div class="row">
            <div class="column5">
                <p class="c-fitness">Fitness: <span id="stat-fitnessRankTier"><?php echo $pet->fitnessRankTier ?></span></p>
                <p class="c-wizardry">Wizardry: <span id="stat-wizardryRankTier"><?php echo $pet->wizardryRankTier ?></span></p>
            </div>
            <div class="column5">
                <p class="c-charisma">Charisma: <span id="stat-charismaRankTier"><?php echo $pet->charismaRankTier ?></span></p>
                <p class="c-nature">Nature:  <span id="stat-natureRankTier"><?php echo $pet->natureRankTier ?></span></p>
            </div>
        </div>
    </div>

<!-- PET MENU:STATS -->
    <div hidden id="petmenu-stats" class="petmenu roboto ts-stats tlh-120">
        <div class="row">
            <div class="column5">
                <p class="c-fitness" ><u>Fitness</u>: <span id="stat-fitness"><?php echo 'max '.$pet->fitnessMax?></span></p>
                <p class="c-fitness2">Constitution: <span id="stat-constitution"><?php echo $pet->constitution ?></span></p>
                <p class="c-fitness2">Strength: <span id="stat-strength"><?php echo $pet->strength ?></span></p>
                <p class="c-fitness2">Agility: <span id="stat-agility"><?php echo $pet->agility ?></span></p>
                <p class="info-button c-fitness2" onclick="document.getElementById('modal-stats-fitness').style.display = 'block';" style="background-color: #ff3b3b;">ℹ️</p>
            </div>
            <div class="column5">
				<p class="c-charisma"><u>Charisma</u>: <span id="stat-charisma"><?php echo 'max '.$pet->charismaMax?></span></p>
                <p class="c-charisma2">Charm: <span id="stat-charm"><?php echo $pet->charm ?></span></p>
                <p class="c-charisma2">Confidence: <span id="stat-confidence"><?php echo $pet->confidence ?></span></p>
                <p class="c-charisma2">Empathy: <span id="stat-empathy"><?php echo $pet->empathy ?></span></p>
                <p class="info-button c-charisma2" onclick="document.getElementById('modal-stats-charisma').style.display = 'block';" style="background-color: #ffc000;">ℹ️</p>
            </div>
        </div>
        <br/>
        <div class="row">
        <div class="column5">
                <p class="c-wizardry"><u>Wizardry</u>: <span id="stat-wizardry"><?php echo 'max '.$pet->wizardryMax?></span></p>
                <p class="c-wizardry2">Intelligence: <span id="stat-intelligence"><?php echo $pet->intelligence ?></span></p>
                <p class="c-wizardry2">Wisdom: <span id="stat-wisdom"><?php echo $pet->wisdom ?></span></p>
                <p class="c-wizardry2">Sorcery: <span id="stat-sorcery"><?php echo $pet->sorcery ?></span></p>
                <p class="info-button c-wizardry2" onclick="document.getElementById('modal-stats-wizardry').style.display = 'block';" style="background-color: #21f7f7;">ℹ️</p>
            </div>
            <div class="column5">
                <p class="c-nature"><u>Nature</u>: <span id="stat-nature"><?php echo 'max '.$pet->natureMax?></span></p>
                <p class="c-nature2">Loyalty: <span id="stat-loyalty"><?php echo $pet->loyalty ?></span></p>
                <p class="c-nature2">Spirituality: <span id="stat-spirituality"><?php echo $pet->spirituality ?></span></p>
                <p class="c-nature2">Karma: <span id="stat-karma"><?php echo $pet->karma ?></span></p>
                <p class="info-button c-nature2" onclick="document.getElementById('modal-stats-nature').style.display = 'block';" style="background-color: #3bef7a;">ℹ️</p>
            </div>
        </div>
    </div>

<!-- PET MENU:HEALTH -->
    <div hidden id="petmenu-health" class="petmenu roboto ts-screen tlh-120">
        <p id="health-health_text">Current Health: <span id="health-health" class="c-sick"><?php echo $pet->health ?></span></p>
		<script>
			document.getElementById("health-health").innerHTML = `${pet.health}`;
		</script>
		<p id="health-fatigue_text">Fatigue: <span id="health-fatigue"><?php echo $pet->fatigue; ?></span></p><br/>
		<p style="color: #4CAF50;">GPS: <span class="c-healthy" id="gps_healthy">0</span><span id="gps_tired" class="c-tired"> - 30</span><span id="gps_rundown" class="c-rundown"> - 60</span><span id="gps_sick" class="c-sick"> - 90</span><span id="gps_critical" class="c-critical"> - 120</span><span id="gps_dead" class="c-dead"> - 150</span></p>
		<script>

			// calculate the pet specific health ranges.
            let healthy = '0';
            let tired = Math.floor((pet.constitution + (pet.loyalty * 0.25)) * 1.0).toString();
            let rundown = Math.floor((pet.constitution + (pet.loyalty * 0.25)) * 2.0).toString();
            let sick = Math.floor((pet.constitution + (pet.loyalty * 0.25)) * 3.0).toString();
            let critical = Math.floor((pet.constitution + (pet.loyalty * 0.25)) * 4.0).toString();
            let dead = Math.floor((pet.constitution + (pet.loyalty * 0.25)) * 5.0).toString();

            //console.log ("pet health: '" + pet.health + "'");
            if (pet.health === "Healthy") { healthy = healthy + "*"; }
			else if (pet.health === "Tired")  { tired = tired + "*"; }
            else if (pet.health === "Run Down")  { rundown = rundown + "*"; }
            else if (pet.health === "Sick")  { sick = sick + "*"; }
            else if (pet.health === "Critical")  { critical = critical + "*"; }
            else if (pet.health === "Dead")  { dead = dead + "*"; }

            document.getElementById('gps_healthy').innerHTML = ` ${healthy}`;
            document.getElementById('gps_tired').innerHTML = ` - ${tired}`;
            document.getElementById('gps_rundown').innerHTML = ` - ${rundown}`;
            document.getElementById('gps_sick').innerHTML = ` - ${sick}`;
            document.getElementById('gps_critical').innerHTML = ` - ${critical}`;
            document.getElementById('gps_dead').innerHTML = ` - ${dead}`;

            let e = document.getElementById("health-fatigue");
            e.innerHTML = `${pet.fatigue}`;
            e.style.color = healthColors[pet.health];
            document.getElementById('health-fatigue_text').style.color = healthColors[pet.health];
            document.getElementById('health-health').style.color = healthColors[pet.health];
            document.getElementById('health-health_text').style.color = healthColors[pet.health];
		</script>
        <br>
        <p style="color: #b2d3ff;">Acquisition Date: <span id="health-birthdate"><?php echo date("Y-m-d", $pet->birthDate) ?></span></p>
		<p style="color: #d8b2ff;">Breeding Chances: <span id="health-breeding"><?php echo 3 - $pet->breedingCount; ?>/3</span></p>
        <br>
        <br>
        <a href="#" onclick="showReleasePet ('petmenu-health', 'petmenu-release'); return false;"><p class="tright" style="color: #ff4800;"><u>>> RELEASE THIS PET?</u></p></a>
    </div>

    <div hidden id="petmenu-release" class="petmenu roboto ts-screen tlh-120 tcenter">
        <p style="color: #ff4700;">(!) WARNING (!)</p>
        <br>
        <p style="color: #ff4700;" id="pet_release_msg">You are about to release:</p>
        <p style="color: #fff;" id="release_pet_name"><?php echo "$pet->species (#$pet->petNumber)"?></p><!-- display the pet to release -->
        <br>
        <p style="color: #ff4700;" id="pet_release_msg2">ARE YOU SURE?</p>
        <br>
        <div class="row">
            <div class="column5" id="pet_release_yes" ><a href="#" onclick="releasePet ('petmenu-release', true, false); return false;" style="display:inline-block;color: #ff0000;"><u>Yes</u></a></div>
            <div class="column5" id="pet_release_no"><a href="#" onclick="releasePet ('petmenu-release', false, false); return false;" style="display:inline-block;color: #ffff00;"><u>No</u></a></div>
        </div>
    </div>

<!-- Release Pet warning message -->
	<div hidden id="petmenu-release-error" class="petmenu roboto ts-screen tlh-120 tcenter">
		<p style="color: #ff4700;">(!) WARNING (!)</p>
		<br>
		<p style="color: #ff4700;" onclick="releasePet ('petmenu-release', false, true); return false;" id="pet_release_error_msg">You cannot release your only pet:</p>
		<p style="color: #fff;" onclick="releasePet ('petmenu-release', false, true); return false;" id="release_pet_error_name"><?php echo "$pet->species (#$pet->petNumber)"?></p><!-- display the pet to release -->
	</div>

<!-- PET MENU:ACTION -->
    <div hidden id="petmenu-action" class="petmenu roboto ts-screen tlh-120">
        <div class="row" style="align-items: center;margin-bottom:2vh;" onclick="selectBreeding ('petmenu-action', 'petmenu-action-scene'); return false;">
            <div class="column3"><img draggable="false" alt="" src="img/pet-menu/petmenu-actionbtn-breeding.webp" /></div>
            <div class="column7"><p style="color: #f74347;">Visit Breeding Cave</p><p class="c-breedingcave">+1 to a Random Pet</p></div>
        </div>
        <div class="row" style="align-items: center;margin-bottom:2vh;" onclick="selectHealing1 ('petmenu-action', 'petmenu-action-scene'); return false;">
            <div class="column3"><img draggable="false" alt="" src="img/pet-menu/petmenu-actionbtn-healing.webp" /></div>
            <div class="column7"><p style="color: #60ee58;">Visit Rejuvenation Cave</p><p class="c-healingcave">Clear Fatigue (5k SC)</p></div>
        </div>
        <div class="row" style="align-items: center;"  onclick="selectVacation1 ('petmenu-action', 'petmenu-action-scene'); return false;">
            <div class="column3"><img draggable="false" alt="" src="img/pet-menu/petmenu-actionbtn-vacation.webp" /></div>
            <div class="column7"><p style="color: #4ed1fc;">Go on a Vacation</p><p class="c-vacation">-100 Fatigue (20 food)</p></div>
        </div>
    </div>

    <div hidden id="petmenu-action-scene" class="screenplay">
        <div class="playscreen">
			<p id="globalmenu-action-result" class="tcenter c-result"> </p>
			<p id="globalmenu-action-result2" class="tcenter c-result"> </p>
        </div>
    </div>

	<span id="pm-version" style="float:right;" class="tc-menu tlh-120" onclick="location.reload();"><script>document.write(appVersion)</script></span>
	<span id="pm-prim-url" hidden style="display: none;"><?php echo $primUrl?></span>

<!-- ============================================================================================================== -->
<!-- modal popup fitness -->
<div id="modal-stats-fitness" class="modal roboto c-fitness2 tlh-120" hidden >
    <p class="c-fitness tcenter" style="font-size:5vw;">- Fitness -</p><br>
    <p class="c-fitness ts-screen">Constitution (CON):</p>
    <p>Determines the pet's Health Points during battle and its resistance to Fatigue.</p>
    <br>
    <p class="c-fitness ts-screen">Strength (STR):</p>
    <p>Influences the amount of damage dealt and provides physical defense.</p>
    <br>
    <p class="c-fitness ts-screen">Agility (AGI):</p>
    <p>Improves attack evasion and enhances accuracy in dealing physical damage.</p>
    <br>
    <p class="close c-fitness ts-screen tright" onclick="document.getElementById('modal-stats-fitness').style.display = 'none';"><u><< Go Back</u></p>
</div>

<!-- modal popup charisma -->
<div id="modal-stats-charisma" class="modal roboto c-charisma2 tlh-120" hidden >
    <p class="c-charisma tcenter" style="font-size:5vw;">- Charisma -</p><br>
    <p class="c-charisma ts-screen">Charm (CHA):</p>
    <p>Increases the chance of enticing and discovering more powerful creatures.</p>
    <br>
    <p class="c-charisma ts-screen">Confidence (CFI):</p>
    <p>Enhances the chances of impressing other creatures and improving foraging abilities.</p>
    <br>
    <p class="c-charisma ts-screen">Empathy (EMP):</p>
    <p>Boosts spiritual bonds, encouraging friendly creature communication.</p>
    <br>
    <p class="close c-charisma ts-screen tright" onclick="document.getElementById('modal-stats-charisma').style.display = 'none';"><u><< Go Back</u></p>
</div>

<!-- modal wizardry -->
<div id="modal-stats-wizardry" class="modal roboto c-wizardry2 tlh-120" hidden >
    <p class="c-wizardry tcenter" style="font-size:5vw;">- Wizardry -</p><br>
    <p class="c-wizardry ts-screen">Intelligence (INT):</p>
    <p>Increases the chance of evading hostile encounters and solving dungeon puzzles.</p>
    <br>
    <p class="c-wizardry ts-screen">Wisdom (WIS):</p>
    <p>Enhances Magical Accuracy and Magic defense.</p>
    <br>
    <p class="c-wizardry ts-screen">Sorcery (SOR):</p>
    <p>Amplifies magical attack power and magic critical strikes.</p>
    <br>
    <p class="close c-wizardry ts-screen tright" onclick="document.getElementById('modal-stats-wizardry').style.display = 'none';"><u><< Go Back</u></p>
</div>

<!-- modal nature -->
<div id="modal-stats-nature" class="modal roboto c-nature2 tlh-120" hidden >
    <p class="c-nature tcenter" style="font-size:5vw;">- Nature -</p><br>
    <p class="c-nature ts-screen">Loyalty (LOY):</p>
    <p>Reduces action failures during fatigue, increases tolerance for fatigue's effects.</p>
    <br>
    <p class="c-nature ts-screen">Spirituality (SPI):</p>
    <p>Increases likelihood of uncovering rare events and discovering surprise items.</p>
    <br>
    <p class="c-nature ts-screen">Karma (KAR):</p>
    <p>Enhances luck, improves breeding odds for high-quality monsters in the future.</p>
    <br>
    <p class="close c-nature ts-screen tright" onclick="document.getElementById('modal-stats-nature').style.display = 'none';"><u><< Go Back</u></p>
</div>


<!-- ############################################################ -->
<!-- INSIDE SCREEN -->
<!-- GLOBAL:TRAINING scene1 -->
<div hidden id="globalmenu-training1" class="screenplay">
    <div class="globalmenu ts-screen tlh-120">
        <div class="milonga tcenter">
            <p class="c-title">Which training would you like to do?</p>
        </div>
        <br/>
		<?php
		for ($i = 0; $i < sizeof ($trainInfo); $i++)
        {
			$name = $trainInfo[$i]->type;
			$cost = $trainInfo[$i]->cost;
			?>
			<a href="#" id="training-<?php echo $i?>" class="row" onclick="selectTrain1(this.id, '<?php echo $name?>', <?php echo $cost?>); return false;">
				<div class="column5 c-train1 tleft"><p><?php echo $name?></p></div>
				<div class="column5 c-train2 tright"><p><?php echo $cost?> food</p></div>
			</a>
			<?php
		}
		?>
        <a href="#" class="row c-title3" style="justify-content:center;" onclick="selectTrainClose (); return false;"><u>Close</u></a>
    </div>
</div>

<!-- GLOBAL MENU:TRAINING scene2 -->
<div hidden id="globalmenu-training2"  class="screenplay">
    <div class="globalmenu ts-screen tlh-120">
        <div class="row milonga" style="margin-bottom: 1vh;">
            <p class="c-title">Are you sure you want to perform <span id="globalmenu-training2-name" class="c-title2">Endurance</span>  Training?<p>
            <!-- <p class="c-title">You do not have enough food to start <span class="c-title2">Aquatic Training</span>.</p> --> 
        </div>
        <div class="row-wgap roboto" style="margin-bottom: 1vh;">
            <div class="column-wgap">
                <input id="globalmenu-training2-texture" draggable="false" type="image" style="border: 0.35vw solid #f1de6f;border-radius: 2vw;" alt="" src="img/global-menu/training-endurance.webp"/>
            </div>
            <div class="column-wgap" style="background-color: rgba(255,255,255,0.05);border-radius: 2vw;display: flex;align-items: center;justify-content: center;">
                <div id="train2-traininfo" class="tcenter"></div>
            </div>
        </div>
        <div class="row tcenter">
            <div class="column5"><a href="#" class="c-yes" onclick="selectTrain2('globalmenu-training2', true); return false;"><u>Yes</u></a></div>
            <div class="column5"><a href="#" class="c-no" onclick="selectTrain2('globalmenu-training2', false); return false;"><u>No</u></a></div>

            <!-- <div class="column5"><a href="#" class="c-yes" onclick="selectTrain1('globalmenu-training1', true); return false;"><u>Go Back</u></a></div>
            <div class="column5"><a href="#" class="c-no" onclick="selectTrain2('globalmenu-training2', false); return false;"><u>Cancel</u></a></div> -->
        </div>
    </div>
</div>
<!-- GLOBAL MENU:TRAINING scene3 -->
<div hidden id="globalmenu-training3" class="screenplay">
    <div class="globalmenu ts-screen tlh-120">
        <div class="row milonga" style="margin-bottom: 1vh;">
            <p id="train-msg" class="c-title">Choose the pet you wish to train for <span id="globalmenu-training3-name" class="c-title2"><?php echo $trainName?></span>.<p>
        </div>
        <div class="row-wgap roboto" style="margin-bottom: 1vh;">
            <div class="column-wgap">
                <input id="train-texture" draggable="false" type="image" style="border: 0.35vw solid #f1de6f;border-radius: 2vw;" alt="" src="<?php echo $pet->texture?>"/>
            </div>
			<script>
                if (pet.health === 'Dead')
                {
                    document.getElementById('train-texture').style = "border: 0.35vw solid #f1de6f;border-radius: 2vw; filter:none;-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);";
                    document.getElementById('train-msg').innerHTML = "You can't select a dead pet for this action. Please choose another pet.";
                }
			</script>
            <div class="column-wgap column-statdisplay" style="background-color: rgba(255,255,255,0.05);border-radius: 2vw;padding: 2vw 0;overflow-y: auto;">
                <div class="tcenter">
					<p class="c-plant"><span id="train-species"><?php echo $pet->species?></span></p>
					<p class="c-plant">(#<span id="train-petNumber"><?php echo $pet->petNumber?></span>)</p>
                    <br/>
					<p class="c-fitness">Fitness: <span id="train-fitness"><?php echo 'max '.$pet->fitnessMax?></span></p>
					<p class="c-fitness2">CON: <span id="train-constitution"><?php echo $pet->constitution?></span></p>
					<p class="c-fitness2">STR: <span id="train-strength"><?php echo $pet->strength?></span></p>
					<p class="c-fitness2">AGI: <span id="train-agility"><?php echo $pet->agility?></span></p>
					<br/>
					<p class="c-wizardry">Wizardry: <span id="train-wizardry"><?php echo 'max '.$pet->wizardryMax?></span></p>
					<p class="c-wizardry2">INT: <span id="train-intelligence"><?php echo $pet->intelligence?></span></p>
					<p class="c-wizardry2">WIS: <span id="train-wisdom"><?php echo $pet->wisdom?></span></p>
					<p class="c-wizardry2">SOR: <span id="train-sorcery"><?php echo $pet->sorcery?></span></p>
					<br/>
					<p class="c-charisma">Charisma: <span id="train-charisma"><?php echo 'max '.$pet->charismaMax?></span></p>
					<p class="c-charisma2">CHA: <span id="train-charm"><?php echo $pet->charm?></span></p>
					<p class="c-charisma2">CFI: <span id="train-confidence"><?php echo $pet->confidence?></span></p>
					<p class="c-charisma2">EMP: <span id="train-empathy"><?php echo $pet->empathy?></span></p>
					<br/>
					<p class="c-nature">Nature: <span id="train-nature"><?php echo 'max '.$pet->natureMax?></span></p>
					<p class="c-nature2">LOY: <span id="train-loyalty"><?php echo $pet->loyalty?></span></p>
					<p class="c-nature2">SPI: <span id="train-spirituality"><?php echo $pet->spirituality?></span></p>
					<p class="c-nature2">KAR: <span id="train-karma"><?php echo $pet->karma?></span></p>
					<br/>
					<p class="c-fatigue">Fatigue: <span  id="train-fatigue"><?php echo $pet->fatigue?></span></p>
                </div>
            </div>
        </div>
        <div id="train-pet-buttons" class="row tcenter">
            <div id="train_pet_div1" class="column5"><p id="train-pet-button1" class="c-yes" onclick="setupTrainQuest (true); return false;"><u>Yes</u></p></div>
            <div id="train_pet_div2" class="column5"><p id="train-pet-button2" class="c-no" onclick="setupTrainQuest (false); return false;"><u>No</u></p></div>
        </div>
    </div>
</div>
<!-- GLOBAL MENU:TRAINING scene4 -->
<div hidden id="globalmenu-training4" class="screenplay">
    <div class="playscreen">
		<p id="globalmenu-training-result" class="tcenter c-result" onclick="selectQuestError ('globalmenu-training4'); return false;" >Your pet's stats have been increased by <span id="train-gain-info">your stats here.</span>.</p>
    </div>
</div>
<!-- GLOBAL MENU:TRAINING scene5 -->
<div hidden id="globalmenu-training5" class="screenplay">
	<div class="row-wgap roboto" style="margin-bottom: 1vh;">

		<div class="playscreen">
			<p id="globalmenu-training5-text" class="tcenter c-result" onclick="selectQuestError ('globalmenu-training5'); return false;" >You do not have enough food for this training! <br/>%STAT_COST% %FOOD_STAT_COST%  <br/>&lt;Click the Text to Close&gt;</p>
		</div>
	</div>
</div>


<!-- ############################################################ -->
<!-- INSIDE SCREEN 110 -->
<!-- GLOBAL MENU:foraging scene1 -->
<div hidden id="globalmenu-foraging1" class="screenplay">
    <div class="globalmenu ts-screen tlh-120">
        <div class="milonga tcenter">
            <p class="c-title" style="margin:0 auto;">Which food would you like to forage?</p><p class="c-title2" style="margin:0 auto;">(Consumes 1 AP)</p>
        </div>
		<?php
		for ($i = 0; $i < sizeof ($foodInfo); $i++)
        {
			?>
			<a href="#" id="foraging-item<?php echo $i?>" class="row" onclick="selectForage1(this.id, '<?php echo $foodInfo[$i]->type?>'); return false;">
				<div class="column5 c-forage1 tleft"><p><?php echo $foodInfo[$i]->type?></p></div>
				<div class="column5 c-forage2 tright"><p>+<?php echo $foodInfo[$i]->cost?> food</p></div>
			</a>
			<?php
		}
		?>
        <a href="#" class="row c-title3" style="justify-content:center;" onclick="selectForageClose (); return false;"><u>Close</u></a>
    </div>
</div>
<!-- GLOBAL MENU:foraging scene2 -->
<div hidden id="globalmenu-foraging2"  class="screenplay">
    <div class="globalmenu ts-screen tlh-120">
        <div class="row milonga" style="margin-bottom: 1vh;">
            <p class="c-title">Are you sure you want to forage <span id="foraging2-foodname" class="c-title2">Elven Mushroom</span>?<p>
        </div>
        <div class="row-wgap roboto" style="margin-bottom: 1vh;">
            <div class="column-wgap">
                <input draggable="false" type="image" style="border: 0.35vw solid #f1de6f;border-radius: 2vw;" id="forage2_food_image" alt="" src="img/global-menu/foraging-elvenmushroom.webp"/>
            </div>
            <div class="column-wgap" style="background-color: rgba(255,255,255,0.05);border-radius: 2vw;display: flex;align-items: center;justify-content: center;">
                <div id="forage2-foodinfo" class="tcenter">
                    <p class="c-price">Acquires 20 Food<p>
                    <br/>
                    <p class="c-plus">INT +1, WIS +1</p> <!-- if there is + to stat, then use c-plus, if - to stat, then use c-minus. refer to "global menu font color" in css-->
                    <p class="c-minus">STR -1</p> <!-- if there is + to stat, then use c-plus, if - to stat, then use c-minus -->
                    <p class="c-fatigue">Fatigue +10</p> <!-- if it is fatigue, then use  c-fatigue class -->
                </div>
            </div>
        </div>
        <div class="row tcenter">
            <div class="column5"><a href="#" class="c-yes" onclick="selectForage2('globalmenu-foraging2', 'globalmenu-foraging3', true); return false;"><u>Yes</u></a></div>
            <div class="column5"><a href="#" class="c-no" onclick="selectForage2('globalmenu-foraging2', '', false); return false;"><u>No</u></a></div>
        </div>
    </div>
</div>
<!-- GLOBAL MENU:foraging scene3 -->
<div hidden id="globalmenu-foraging3" class="screenplay">
    <div class="globalmenu ts-screen tlh-120">
        <div class="row milonga" style="margin-bottom: 1vh;">
			<p id="forage-msg" class="c-title">Choose the pet you wish to forage for <span id="foraging3-foodname" class="c-title2"><?php echo $foodName?></span>.<p>
        </div>
        <div class="row-wgap roboto" style="margin-bottom: 1vh;">
            <div class="column-wgap">
                <input id="forage-texture" draggable="false" type="image" style="border: 0.35vw solid #f1de6f;border-radius: 2vw;" alt="" src="<?php echo $pet->texture?>"/>
            </div>
			<script>
                if (pet.health === 'Dead')
                {
                    document.getElementById('forage-texture').style = "border: 0.35vw solid #f1de6f;border-radius: 2vw; filter:none;-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);";
                    document.getElementById('forage-msg').innerHTML = "You can't select a dead pet for this action. Please choose another pet.";
                }
			</script>
            <div class="column-wgap column-statdisplay" style="background-color: rgba(255,255,255,0.05);border-radius: 2vw;padding: 2vw 0;overflow-y: auto;">
                <div class="tcenter">
					<p class="c-plant"><span id="forage-species"><?php echo $pet->species?></span></p>
                    <p class="c-plant">(#<span id="forage-petNumber"><?php echo $pet->petNumber?></span>)</p>
                    <br/>
                    <p class="c-fitness">Fitness: <span id="forage-fitness"><?php echo 'max '.$pet->fitnessMax?></span></p>
                    <p class="c-fitness2">CON: <span id="forage-constitution"><?php echo $pet->constitution?></span></p>
                    <p class="c-fitness2">STR: <span id="forage-strength"><?php echo $pet->strength?></span></p>
                    <p class="c-fitness2">AGI: <span id="forage-agility"><?php echo $pet->agility?></span></p>
                    <br/>
                    <p class="c-wizardry">Wizardry: <span id="forage-wizardry"><?php echo 'max '.$pet->wizardryMax?></span></p>
                    <p class="c-wizardry2">INT: <span id="forage-intelligence"><?php echo $pet->intelligence?></span></p>
                    <p class="c-wizardry2">WIS: <span id="forage-wisdom"><?php echo $pet->wisdom?></span></p>
                    <p class="c-wizardry2">SOR: <span id="forage-sorcery"><?php echo $pet->sorcery?></span></p>
                    <br/>
                    <p class="c-charisma">Charisma: <span id="forage-charisma"><?php echo 'max '.$pet->charismaMax?></span></p>
                    <p class="c-charisma2">CHA: <span id="forage-charm"><?php echo $pet->charm?></span></p>
                    <p class="c-charisma2">CFI: <span id="forage-confidence"><?php echo $pet->confidence?></span></p>
                    <p class="c-charisma2">EMP: <span id="forage-empathy"><?php echo $pet->empathy?></span></p>
                    <br/>
                    <p class="c-nature">Nature: <span id="forage-nature"><?php echo 'max '.$pet->natureMax?></span></p>
                    <p class="c-nature2">LOY: <span id="forage-loyalty"><?php echo $pet->loyalty?></span></p>
                    <p class="c-nature2">SPI: <span id="forage-spirituality"><?php echo $pet->spirituality?></span></p>
                    <p class="c-nature2">KAR: <span id="forage-karma"><?php echo $pet->karma?></span></p>
                    <br/>
                    <p class="c-fatigue">Fatigue: <span id="forage-fatigue"><?php echo $pet->fatigue?></span></p>
                </div>
            </div>
        </div>
        <div class="row tcenter">
            <div id="forage-button-div1" class="column5"><a href="#" class="c-yes" onclick="setupForageQuest (true); return false;"><u>Yes</u></a></div>
            <div id="forage-button-div2" class="column5"><a href="#" class="c-no" onclick="setupForageQuest (false); return false;"><u>No</u></a></div>
        </div>
    </div>
</div>
<!-- GLOBAL MENU:foraging scene4 -->
<div hidden id="globalmenu-foraging4" class="screenplay">
    <!-- background display: img/global-menu/foraging-elvenmushroom.webp-->
    <div class="playscreen" onclick="selectForageError('globalmenu-foraging4', true); return false;">
		<p class="tcenter c-result" id="globalmenu-foraging4-msg">Your pet has acquired <span id="globalmenu-foraging4-foodcost">35</span> food by foraging <span id="globalmenu-foraging4-foodname">Elven Mushroom</span>!</p>
	</div>
</div>
<!-- GLOBAL MENU:foraging scene5 -->
<div hidden id="globalmenu-foraging5" class="screenplay">
	<div class="playscreen" onclick="selectForageError('globalmenu-foraging5'); return false;">
		<p id="globalmenu-foraging5-msg" class="tcenter c-result">You do not have enough AP to forage for this food yet!<br/>&lt;Click the Text to Close&gt;</p>
	</div>
</div>




<!-- ############################################################ -->
<!-- INSIDE SCREEN 110 -->
<!-- GLOBAL MENU:rest scene1 -->
<div hidden id="globalmenu-rest1" class="screenplay">
	<div class="playscreen">
		<p class="tcenter c-result">Would you grant ALL your pets a restful night's sleep? <span class="c-rest1" >(All pets reduce 10 fatigue. Consumes 1 AP)</span></p>
		<div class="row tcenter">
			<div class="column5"><a href="#" class="c-yes" onclick="selectRest1('globalmenu-rest1', true); return false;"><u>Yes</u></a></div>
			<div class="column5"><a href="#" class="c-no" onclick="selectRest1('globalmenu-rest1', false); return false;"><u>No</u></a></div>
		</div>
	</div>
</div>
<!-- GLOBAL MENU:rest scene2 -->
<div hidden id="globalmenu-rest2" class="screenplay">
	<div class="playscreen">
		<p id="train2-message" class="tcenter c-result" onclick="selectRest2('globalmenu-rest2'); return false;">All your pets had a sound sleep on the moonlit night and
			reduced 10 fatigue points!</span></p>
	</div>
</div>






	<!-- ############################################################ -->
<!-- INSIDE SCREEN 110 -->
<!-- this section is always the same for ALL quests of any kind. -->
<!-- GLOBAL MENU: QUEST OPENING scene1 -->
<div hidden id="globalmenu-qopening1" class="screenplay"><!-- !!example of pet selection window -->
    <div class="globalmenu ts-screen tlh-120">
        <div class="row milonga" style="margin-bottom: 1vh;">
			<p id="quest-msg" class="c-title">Select the pet of your choice to embark on a <span class="c-title2">random quest</span>. <span class="c-title3">(-50 Food)</span><p>
			<script>
				if (pet.health !== "Dead")
                {
                    document.getElementById('quest-msg').innerHTML = 'Select the pet of your choice to embark on a <span class="c-title2">random quest</span>. <span class="c-title3">(-50 Food)</span>';
                }
                else
                {
                    document.getElementById('quest-msg').innerHTML = "You can't select a dead pet for this action. Please choose another pet.";
                }
			</script>
        </div>
        <div class="row-wgap roboto" style="margin-bottom: 1vh;">
            <div class="column-wgap">
                <input draggable="false" type="image" style="border: 0.35vw solid #f1de6f;border-radius: 2vw;" alt="" id="quest-texture" src="<?php echo $pet->texture?>"/>
				<script>
					if (pet.health === "Dead")  {
                        document.getElementById('quest-texture').style = "filter:none;-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);";
					}
				</script>
            </div>
            <div class="column-wgap column-statdisplay" style="background-color: rgba(255,255,255,0.05);border-radius: 2vw;padding: 2vw 0;overflow-y: auto;">
                <div class="tcenter">
                    <p class="c-plant"><span id="quest-species"><?php echo $pet->species?></span></p>
                    <p class="c-plant">(#<span id="quest-petNumber"><?php echo $pet->petNumber?></span>)</p>
                    <br>
                    <p class="c-fitness">Fitness: <span id="quest-fitness"><?php echo 'max '.$pet->fitnessMax?></span></p>
                    <p class="c-fitness2">CON: <span id="quest-constitution"><?php echo $pet->constitution?></span></p>
                    <p class="c-fitness2">STR: <span id="quest-strength"><?php echo $pet->strength?></span></p>
                    <p class="c-fitness2">AGI: <span id="quest-agility"><?php echo $pet->agility?></span></p>
                    <br>
                    <p class="c-wizardry">Wizardry: <span id="quest-wizardry"><?php echo 'max '.$pet->wizardryMax?></span></p>
                    <p class="c-wizardry2">INT: <span id="quest-intelligence"><?php echo $pet->intelligence?></span></p>
                    <p class="c-wizardry2">WIS: <span id="quest-wisdom"><?php echo $pet->wisdom?></span></p>
                    <p class="c-wizardry2">SOR: <span id="quest-sorcery"><?php echo $pet->sorcery?></span></p>
                    <br>
                    <p class="c-charisma">Charisma: <span id="quest-charisma"><?php echo 'max '.$pet->charismaMax?></p>
                    <p class="c-charisma2">CHA: <span id="quest-charm"><?php echo $pet->charm?></span></p>
                    <p class="c-charisma2">CFI: <span id="quest-confidence"><?php echo $pet->confidence?></span></p>
                    <p class="c-charisma2">EMP: <span id="quest-empathy"><?php echo $pet->empathy?></span></p>
                    <br>
                    <p class="c-nature">Nature: <span id="quest-nature"><?php echo 'max '.$pet->natureMax?></span></p>
                    <p class="c-nature2">LOY: <span id="quest-loyalty"><?php echo $pet->loyalty?></span></p>
                    <p class="c-nature2">SPI: <span id="quest-spirituality"><?php echo $pet->spirituality?></span></p>
                    <p class="c-nature2">KAR: <span id="quest-karma"><?php echo $pet->karma?></span></p>
                    <br>
                    <p class="c-fatigue">Fatigue: <span id="quest-fatigue"><?php echo $pet->fatigue?></span></p>
                </div>
            </div>
        </div>
			<div class="row tcenter">
				<div id="quest-button-div1" class="column5"><a href="#" class="c-yes" onclick="selectQuestStart('globalmenu-qopening1', true); return false;"><u>Start</u></a></div>
				<div id="quest-button-div2" class="column5"><a href="#" class="c-no" onclick="selectQuestStart('globalmenu-qopening1', false); return false;"><u>Cancel</u></a></div>
			</div>
			<script>
                if (pet.health !== "Dead") {
                    document.getElementById("quest-button-div1").removeAttribute("hidden");
                    document.getElementById("quest-button-div2").removeAttribute("hidden");
                }
                else {
					document.getElementById("quest-button-div1").setAttribute("hidden", "");
                    document.getElementById("quest-button-div2").setAttribute("hidden", "");
                }
			</script>
    </div>
</div>

<!-- GLOBAL MENU: QUEST Error screen -->
<div hidden id="globalmenu-qerror" class="screenplay">
	<!-- background display: img/global-quest/quest-default.webp-->
	<div class="playscreen">
		<p class="tcenter c-result" id="qerror-p1" onclick="selectQuestError ('qerror-p1'); return false;">You do not have enough food to go on a quest. <br/>&lt;Click the Text to Close&gt;</p>
	</div>
</div>


<!-- Quest Choice screen -->
<div hidden id="globalmenu-qchoice" class="screenplay">
	<div class="playscreen">
		<div class="row" style="padding: 0 2vw 2vw 0">
			<div style="align-self: flex-end;padding: 0 2vw 0 0" class="column7 tcenter">
				<p class="c-result tleft" data-typewriter="" id="qchoice-p1">You have encountered a Unicorn!</p>
			</div>
			<div hidden class="column3 selectscreen" id="qchoice-choices4">
				<p class="c-fight roboto"  id="qchoice-choice4_1" onclick="selectQuestChoice ('fight'); return false;">Fight</p>
				<p class="c-speak roboto"  id="qchoice-choice4_2" onclick="selectQuestChoice ('speak'); return false;">Speak</p>
				<p class="c-runaway roboto"  id="qchoice-choice4_3" onclick="selectQuestChoice ('runaway'); return false;">Runaway</p>
				<p class="c-hide roboto"  id="qchoice-choice4_4" onclick="selectQuestChoice ('hide'); return false;">Hide</p>
			</div>
			<div hidden class="column3 selectscreen" id="qchoice-choices3">
				<p class="c-fight roboto"  id="qchoice-choice3_1" onclick="selectQuestChoice ('fight'); return false;">Fight</p>
				<p class="c-speak roboto"  id="qchoice-choice3_2" onclick="selectQuestChoice ('speak'); return false;">Speak</p>
				<p class="c-runaway roboto"  id="qchoice-choice3_3" onclick="selectQuestChoice ('runaway'); return false;">Runaway</p>
			</div>
			<div hidden class="column3 selectscreen" id="qchoice-choices2">
				<p class="c-fight roboto"  id="qchoice-choice2_1" onclick="selectQuestChoice ('fight'); return false;">Fight</p>
				<p class="c-speak roboto"  id="qchoice-choice2_2" onclick="selectQuestChoice ('speak'); return false;">Speak</p>
			</div>
		</div>
	</div>
</div>

<!-- Quest Dialogue Choice screen DEC 7th 2023 -->
<div hidden id="globalmenu-qdialogue" class="screenplay">
	<div class="playscreen">
        <div class="row" style="padding: 0 2vw 2vw 0;flex-direction:column;">
            <div style="align-self: auto;padding: 0 2vw 0 0;" class="tcenter">
                <p id="qdialogue_desc" class="c-result tleft">My Name is CocoPup! Can you help me find an enchanted mushroom?</p>
                <ul style="padding: 0 0 0 2vw;">
                    <li onclick="selectQuestChoice ('choice1'); return false;" id="qdialogue-choice1" class="c-result tleft">Sure! Can you describe how it looks?</li>
                    <li onclick="selectQuestChoice ('choice2'); return false;" id="qdialogue-choice2" class="c-result tleft">We can go to Death Valley to find it.</li>
                    <li onclick="selectQuestChoice ('choice3'); return false;" id="qdialogue-choice3" class="c-result tleft">If you can convince me why I should help you.</li>
					<li onclick="selectQuestChoice ('choice4'); return false;" id="qdialogue-choice4" class="c-result tleft">I am too tired, go away.</li>
					<li onclick="selectQuestChoice ('choice5'); return false;" id="qdialogue-choice5" class="c-result tleft">...</li>
                </ul>
            </div>
        </div>
    </div>
</div>





<!-- ############################################################ -->
<!-- PET PIC 90 -->
    <div id="pet-portrait">
		<img id="pet-portrait-texture" src="<?php echo $pet->texture?>"  alt=""/>
		<script>
			setPetPortraitFilter(pet);
		</script>
		<div class="playscreen" >
			<p hidden id="pet-portrait-msg" data-typewriter="" class="tleft c-white" style="padding: 5px 5px 5px 5px;"></p>
		</div>
    </div>
<!-- FRAME 100 -->
    <div id="frame">
        <img id="pet-frame" draggable="false" src="<?php echo $pet->attributeTexture?>" alt=""/>
		<!--<div id="pet-portrait-frame"></div>-->
    </div>
<!-- INTERFACE 110 -->
    <div hidden id="pet-face"><!-- START: ADDING PET FACE AND EMOTICON -->
        <img id="pet-face-img" draggable="false" src="img/pet-portrait/pet-air-1-avidra-face.webp" alt="">
    </div>
    <div hidden id="pet-emoticon">
        <img id="pet-emoji" draggable="false" src="img/global-expression/expression-happy.webp" alt=""/>
    </div><!-- END: ADDING PET FACE AND EMOTICON -->
    <div id="pet-name">
		<p id="pet-name-text" class="milonga ts-big tc-menu tcenter"><?php echo $pet->species?></p>
    </div>

    <div id="pet-id">
        <p id="pet-id-text" class="milonga ts-big tc-menu tcenter">#<?php echo $pet->petNumber?></p>
    </div>

    <div id="pet-window-btn">
        <input draggable="false" type="image" id="pm-profile" src="img/pet-menu/petmenu-profile.webp" alt="" onclick="toggleButtonImage (this, this.id, 'petmenu-profile', 'img/pet-menu/petmenu-profile.webp', 'img/pet-menu/petmenu-profile-active.webp');"/>
        <input draggable="false" type="image" id="pm-stats" src="img/pet-menu/petmenu-stats.webp" alt="" onclick="toggleButtonImage (this, this.id, 'petmenu-stats', 'img/pet-menu/petmenu-stats.webp', 'img/pet-menu/petmenu-stats-active.webp');"/>
        <input draggable="false" type="image" id="pm-health" src="img/pet-menu/petmenu-health.webp" alt="" onclick="toggleButtonImage (this, this.id, 'petmenu-health', 'img/pet-menu/petmenu-health.webp', 'img/pet-menu/petmenu-health-active.webp');"/>
        <input draggable="false" type="image" id="pm-action" src="img/pet-menu/petmenu-action.webp" alt="" onclick="toggleButtonImage (this, this.id, 'petmenu-action', 'img/pet-menu/petmenu-action.webp', 'img/pet-menu/petmenu-action-active.webp');"/>
    </div>

    <div id="global-ap">
        <p class="roboto ts-medium tc-global tleft tlh-110">
			AP: <span id="global_action_points"><?php echo $owner->actionPoints?> / <?php echo $owner->apMax?></span><br/>
			Food: <span id="global_food"><?php echo $owner->food?></span><br>
			Pets: <span id="global_total_pets"><?php echo $owner->totalPets?></span></p>
    </div>

    <div id="global-button-adventure">
        <p class="milonga ts-small tc-global tcenter">Adventure</p>
        <input draggable="false" type="image" id="adv_train" src="img/global-button/button-train.webp" alt="" onclick="toggleButtonImage ('train', this.id, 'globalmenu-training1', 'img/global-button/button-train.webp', 'img/global-button/button-train-active.webp');"/>
        <input draggable="false" type="image" id="adv_quest" src="img/global-button/button-quest.webp" alt="" onclick="toggleButtonImage ('quest', this.id, 'globalmenu-qopening1', 'img/global-button/button-quest.webp', 'img/global-button/button-quest-active.webp');"/>
    </div>

    <div id="global-button-chore">
        <p class="milonga ts-small tc-global tcenter">Chore</p>
        <input draggable="false" type="image" id="chore_forage" src="img/global-button/button-forage.webp" alt="" onclick="toggleButtonImage ('forage', this.id, 'globalmenu-foraging1', 'img/global-button/button-forage.webp', 'img/global-button/button-forage-active.webp');"/>
        <input draggable="false" type="image" id="chore_rest" src="img/global-button/button-rest.webp" alt="" onclick="toggleButtonImage ('rest', this.id, 'globalmenu-rest1', 'img/global-button/button-rest.webp', 'img/global-button/button-rest-active.webp');"/>
    </div>

    <div id="pet-selector">
        <div id="attribute-selector">
			<?php  if ($attribFilter == 'Fire') { ?>
				<input draggable="false" type="image" id="s-fire" style="outline: white solid medium; outline-offset: -0.35vw; border-radius: 20px" src="img/pet-selector/selector-red.webp" alt="" onclick="filterSelect (this, 'Fire');"/>
            <?php  } else { ?>
				<input draggable="false" type="image" id="s-fire" src="img/pet-selector/selector-red.webp" alt="" onclick="filterSelect (this, 'Fire');"/>
            <?php  } ?>
            <?php  if ($attribFilter == 'Earth') { ?>
				<input draggable="false" type="image" id="s-earth" style="outline: white solid medium; outline-offset: -0.35vw; border-radius: 20px" src="img/pet-selector/selector-brown.webp" alt="" onclick="filterSelect (this, 'Earth');"/>
            <?php  } else { ?>
				<input draggable="false" type="image" id="s-earth" src="img/pet-selector/selector-brown.webp" alt="" onclick="filterSelect (this, 'Earth');"/>
            <?php  } ?>
            <?php  if ($attribFilter == 'Plant') { ?>
				<input draggable="false" type="image" id="s-plant" style="outline: white solid medium; outline-offset: -0.35vw; border-radius: 20px" src="img/pet-selector/selector-green.webp" alt="" onclick="filterSelect (this, 'Plant');"/>
            <?php  } else { ?>
				<input draggable="false" type="image" id="s-plant" src="img/pet-selector/selector-green.webp" alt="" onclick="filterSelect (this, 'Plant');"/>
            <?php  } ?>
            <?php  if ($attribFilter == 'Water') { ?>
				<input draggable="false" type="image" id="s-water" style="outline: white solid medium; outline-offset: -0.35vw; border-radius: 20px" src="img/pet-selector/selector-blue.webp" alt="" onclick="filterSelect (this, 'Water');"/>
            <?php  } else { ?>
				<input draggable="false" type="image" id="s-water" src="img/pet-selector/selector-blue.webp" alt="" onclick="filterSelect (this, 'Water');"/>
            <?php  } ?>
            <?php  if ('Cold' === $attribFilter) { ?>
				<input draggable="false" type="image" id="s-cold" style="outline: white solid medium; outline-offset: -0.35vw; border-radius: 20px;" src="img/pet-selector/selector-skyblue.webp" alt="" onclick="filterSelect (this, 'Cold');"/>
            <?php  } else { ?>
				<input draggable="false" type="image" id="s-cold" src="img/pet-selector/selector-skyblue.webp" alt="" onclick="filterSelect (this, 'Cold');"/>
            <?php  } ?>
			<?php  if ('Air' === $attribFilter) { ?>
				<input draggable="false" type="image" id="s-wind" style="outline: white solid medium; outline-offset: -0.35vw; border-radius: 20px;" src="img/pet-selector/selector-purple.webp" alt="" onclick="filterSelect(this, 'Air');"/>
            <?php } else { ?>
				<input draggable="false" type="image" id="s-wind" src="img/pet-selector/selector-purple.webp" alt="" onclick="filterSelect(this, 'Air');"/>
            <?php } ?>
			<?php  if ($attribFilter == 'Electricity') { ?>
				<input draggable="false" type="image" id="s-electricity" style="outline: white solid medium; outline-offset: -0.35vw; border-radius: 20px" src="img/pet-selector/selector-yellow.webp" alt="" onclick="filterSelect (this, 'Electricity');"/>
            <?php  } else { ?>
				<input draggable="false" type="image" id="s-electricity" src="img/pet-selector/selector-yellow.webp" alt="" onclick="filterSelect (this, 'Electricity');"/>
            <?php  } ?>
            <?php  if ($attribFilter == 'Metal') { ?>
				<input draggable="false" type="image" id="s-metal" style="outline: white solid medium; outline-offset: -0.35vw; border-radius: 20px" src="img/pet-selector/selector-silver.webp" alt="" onclick="filterSelect (this, 'Metal');"/>
            <?php  } else { ?>
				<input draggable="false" type="image" id="s-metal" src="img/pet-selector/selector-silver.webp" alt="" onclick="filterSelect (this, 'Metal');"/>
            <?php  } ?>
            <?php  if ($attribFilter == 'Light') { ?>
				<input draggable="false" type="image" id="s-light" style="outline: white solid medium; outline-offset: -0.35vw; border-radius: 20px" src="img/pet-selector/selector-white.webp" alt="" onclick="filterSelect (this, 'Light');"/>
            <?php  } else { ?>
				<input draggable="false" type="image" id="s-light" src="img/pet-selector/selector-white.webp" alt="" onclick="filterSelect (this, 'Light');"/>
            <?php  } ?>
            <?php  if ($attribFilter == 'Darkness') { ?>
				<input draggable="false" type="image" id="s-darkness" style="outline: white solid medium; outline-offset: -0.35vw; border-radius: 20px" src="img/pet-selector/selector-black.webp" alt="" onclick="filterSelect (this, 'Darkness');"/>
            <?php  } else { ?>
				<input draggable="false" type="image" id="s-darkness" src="img/pet-selector/selector-black.webp" alt="" onclick="filterSelect (this, 'Darkness');"/>
            <?php  } ?>
        </div>
        <div id="pet-pointer">
			<?php
            $start = 0;
			$end = 0;
			// calculate the logical end of the pet list in
			// terms of the slot and offset
			if (($start + PETS_PER_PAGE) > $pageTotal) $end = $pageTotal;
			else $end = ($start + PETS_PER_PAGE);

			// loop over all the elements in the array (all 8 values)
			// if the element is for a pet display the pet information
			// and if not display an empty box.
			for ($i = $start; $i < ($start + PETS_PER_PAGE); $i++)
            {
				if ($i < $end)
                {
					// load the pet information from the slot.
                    $p = $petList[$i];
                    ?>
					<div id="slot-<?php echo $i+1?>">
						<input id="pet_image_<?php echo $i+1?>"
							   type="image"
							   class="has-pet" src="<?php echo $p["texture"]; ?>"
							   alt=""
							   style=""/>

						<?php
						if ($p["health"] === "Dead")
						{
							?>
							<script>
								document.getElementById('pet_image_<?php echo $i+1?>').style = "filter:none;-webkit-filter:grayscale(100%);-moz-filter:grayscale(100%);-ms-filter:grayscale(100%);-o-filter:grayscale(100%);";
							</script>
						<?php
                        }
						?>
						<p id="pet-number-<?php echo $i+1?>" class="has-pet roboto"><?php echo $p["pet_number"];?></p>
						<script>
                            {
                                // unhealthy & dead pet handling
                                let health = '<?php echo $p["health"]?>';
                                let e = document.getElementById('pet-number-<?php echo $i+1?>');
                            	if (health === "Sick")
                                {
                                    e.style.color = "#ff0000";
                                }
                                else if (health === "Critical")
                                {
                                    e.style.color = "#bf00ff";
								}
                            }
						</script>
						<input id="pet-thumb-frame-<?php echo $i+1;?>"
							   type="image"
							   class="frame-slot"
							   onclick="petSelect(this, 'pet-thumb-frame-<?php echo $i+1?>', <?php echo $p['id']?>, <?php echo $i?>)"
							   src="img/pet-selector/petslot-inactive.webp" alt=""/>
					</div>
					<?php
				}
				else
				{
                    ?>
					<div id="slot-<?php echo $i+1?>">
						<input id="pet-thumb-frame-<?php echo $i+1;?>"
							type="image"
							class="frame-slot"
							onclick="petSelect(this, 'pet-thumb-frame-<?php echo $i+1?>', 0, '')"
							src="img/pet-selector/petslot-inactive.webp" alt=""/>

						<input id="pet_image_<?php echo $i+1?>"
							   type="image"
							   class="has-pet" src=""
							   alt=""
							   style=""/>
						<p id="pet-number-<?php echo $i+1?>" class="has-pet roboto"></p>
					</div>
					<?php
                }
            }
			?>
        </div>
    </div>

    <div id="pet-pagination">
        <input draggable="false" type="image" id="pageup" src="img/pet-selector/pagination-uparrow.webp" alt="" onclick="doPage (this, <?php echo $page?>, -1)"/>
        <p id ="pagenum" class="milonga ts-big tcenter"><?php echo $page + 1?></p>
        <input draggable="false" type="image" id="pagedown" src="img/pet-selector/pagination-downarrow.webp" alt="" onclick="doPage (this, <?php echo $page?>, 1)"/>
    </div>


	<div id="modal_dialog"  class="modal roboto tlh-120 c-light" hidden>
		<!--<div class="flex">
			<button id="modal_dialog_close_btn" class="btn-close" onclick="closeModal(); return false;">⨉</button>
		</div>-->
        <!--

        <p id="modal_dialog_text">Close this window? You are not done yet.<br/>(No refunds for already spent AP or Food)</p>

        -->
		<div>
			<p id="modal_dialog_text">
				Dummy text here.
			</p>
		</div>

		<button onclick="processModal(true);" class="btn global-alert">Yes</button>
		<button onclick="processModal(false);" class="btn global-alert">No</button>
	</div>
</section>


</body>
</html>