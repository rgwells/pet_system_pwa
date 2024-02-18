-- ------------------------------------------------------------------
-- Pandemonium pet system tables
--
--
--  mysql --host=localhost --user=pand_pet --password=panda4$ pandemonium_pets
--

set foreign_key_checks = 0;

-- delete data from tables as needed.

-- quest tables
delete from ps_stat_test;
delete from ps_stat_cost;
delete from ps_quest_choice;
delete from ps_quest_def;

delete from ps_pet_genome
where pet_id  < 1000
;

delete from ps_player_pet where is_wild = true;

-- general tables
delete from ps_pet_gene;
delete from ps_pet;
delete from ps_attribute_names;
delete from ps_sayings;

delete from ps_rank_tier;
delete from ps_food_info;
delete from ps_train_info;
delete from ps_grade;
delete from ps_attribute_habitat;
delete from ps_habitat;
delete from ps_attribute;
delete from ps_settings;

-- --------------------------------------------------------------------

insert into ps_settings
(keyName, KeyValue)
values
('group_key', '8958e54a-72bf-c670-e542-b168f6b28802'),
('help_link', 'https://bit.ly/3tVT4fb'),
('discord_link', 'https://discord.com/invite/sSjwxjasaC')
;

-- --------------------------------------------------------------------

insert into ps_grade
(rarity, code, min_value, max_value)
values
('Common',   'C', 'D-', 'D+'),
('Uncommon', 'U', 'D+', 'C'),
('Rare',     'R', 'C',  'B-'),
('Epic',     'E', 'B-', 'B+'),
('Legendary','L', 'B+', 'A'),
('Ancient',  'A', 'A',  'S-'),
('Mythical', 'M', 'S-', 'S+')
;


insert into ps_rank_tier
(rank_tier, max_stat)
values
('D-', 70),
('D',  100),
('D+', 130),
('C-', 170),
('C',  200),
('C+', 230),
('B-', 270),
('B',  300),
('B+', 330),
('A-', 370),
('A',  400),
('A+', 430),
('S-', 470),
('S',  500),
('S+', 530)
;



insert into ps_attribute
(attribute, color, texture)
values
('Fire',     '#ff0000', 'img/frame/frame-red.webp'),
('Cold',     '#0099cc', 'img/frame/frame-skyblue.webp'),
('Water',    '#0000ff', 'img/frame/frame-blue.webp'),
('Air',      '#330066', 'img/frame/frame-purple.webp'),
('Earth',    '#663333', 'img/frame/frame-brown.webp'),
('Plant',    '#008000', 'img/frame/frame-green.webp'),
('Metal',    '#c0c0c0', 'img/frame/frame-silver.webp'),
('Electricity', '#ffff00', 'img/frame/frame-yellow.webp'),
('Light',    '#ffffff', 'img/frame/frame-white.webp'),
('Darkness', '#000000', 'img/frame/frame-black.webp')
;



insert into ps_attribute_habitat
(attribute, habitat)
values
('Fire',  'Volcano'),
('Fire',  'Hell'),
('Fire',  'Desert'),
('Fire',  'Autumnal'),
('Cold',  'Glacier'),
('Cold',  'Alpine'),
('Cold',  'Autumnal'),
('Water', 'Coastal'),
('Water', 'Coral'),
('Water', 'Swamp'),
('Air',   'Tundra'),
('Air',   'Plain'),
('Air',   'Alpine'),
('Earth', 'Desert'),
('Earth', 'Tundra'),
('Earth', 'Rainforest'),
('Earth', 'Village'),
('Earth', 'Swamp'),
('Plant', 'Rainforest'),
('Plant', 'Meadow'),
('Plant', 'Coastal'),
('Plant', 'Coral'),
('Plant', 'Plain'),
('Plant', 'Blossom'),
('Metal', 'Underground'),
('Metal', 'Mountain'),
('Metal', 'Cave'),
('Metal', 'Autumnal'),
('Metal', 'Graveyard'),
('Electricity', 'Cave'),
('Electricity', 'Heaven'),
('Electricity', 'Glacier'),
('Electricity', 'Village'),
('Light', 'Heaven'),
('Light', 'Blossom'),
('Light', 'Meadow'),
('Darkness', 'Hell'),
('Darkness', 'Graveyard'),
('Darkness', 'Volcano')
;



insert into ps_habitat
(id, habitat, texture)
values
(1, 'Alpine', 'img/pet-habitat/habitat-alpine.webp'),
(2, 'Autumnal', 'img/pet-habitat/habitat-autumnal.webp'),
(3, 'Blossom', 'img/pet-habitat/habitat-blossom.webp'),
(4, 'Cave', 'img/pet-habitat/habitat-cave.webp'),
(5, 'Coastal', 'img/pet-habitat/habitat-coastal.webp'),
(6, 'Coral', 'img/pet-habitat/habitat-coral.webp'),
(7, 'Desert', 'img/pet-habitat/habitat-desert.webp'),
(8, 'Glacier', 'img/pet-habitat/habitat-glacier.webp'),
(9, 'Graveyard', 'img/pet-habitat/habitat-graveyard.webp'),
(10, 'Heaven', 'img/pet-habitat/habitat-heaven.webp'),
(11, 'Hell', 'img/pet-habitat/habitat-hell.webp'),
(12, 'Meadow', 'img/pet-habitat/habitat-meadow.webp'),
(13, 'Plain', 'img/pet-habitat/habitat-plain.webp'),
(14, 'Rainforest', 'img/pet-habitat/habitat-rainforest.webp'),
(15, 'Swamp', 'img/pet-habitat/habitat-swamp.webp'),
(16, 'Tundra', 'img/pet-habitat/habitat-tundra.webp'),
(17, 'Village', 'img/pet-habitat/habitat-village.webp'),
(18, 'Volcano', 'img/pet-habitat/habitat-volcano.webp')
;






/*
insert into ps_personality_info
(type, gain, gain_column, loss, loss_column)
values
('Energetic',    1, 'constitution', 0, ''),
('Protective',   1, 'strength',     0, ''),
('Playful',      1, 'agility',      0, ''),
('Affectionate', 1, 'charm',        0, ''),
('Independent',  1, 'confidence',   0, ''),
('Social',       1, 'empathy',      0, ''),
('Curious',      1, 'intelligence', 0, ''),
('Calm',         1, 'wisdom',       0, ''),
('Mischievous',  1, 'sorcery',      0, ''),
('Loyal',        1, 'loyalty',      0, ''),
('Shy',          1, 'spirituality', 0, ''),
('Fearless',     1, 'karma',        0, '')
;
*/



insert into ps_train_info
(type,        cost,    texture,                               constitution, strength, agility, charm, confidence, empathy, intelligence, wisdom, sorcery, loyalty, spirituality, karma, fatigue)
values
('Endurance',  -100, 'img/global-menu/training-endurance.webp', 6,             4,        0,      0,      0,          0,       0,            0,      0,        0,       0,           0,     3),
('Speed',      -120, 'img/global-menu/training-speed.webp',     0,             0,        7,      0,      5,          0,       0,            0,      0,        0,       0,           0,     3),
('Aquatic',    -120, 'img/global-menu/training-aquatic.webp',   0,             6,        0,      0,      0,          0,       6,            0,      0,        0,       0,           0,     4),
('Play',       -120, 'img/global-menu/training-play.webp',      0,             0,       10,      0,      0,          0,       0,            0,      0,        2,       0,           0,     4),
('Meditation', -120, 'img/global-menu/training-meditation.webp',0,             0,        0,      0,      0,          4,       0,            8,      0,        0,       0,           0,     3),
('Art',        -130, 'img/global-menu/training-art.webp',       0,             0,        0,     11,      0,          0,       0,            0,      0,        0,       2,           0,     2),
('Magery',     -140, 'img/global-menu/training-magery.webp',    0,             0,        0,      0,      0,          0,       7,            0,      7,        0,       0,           0,     3),
('Outdoor',    -160, 'img/global-menu/training-outdoor.webp',   9,             0,        0,      7,      0,          0,       0,            0,      0,        0,       0,           0,     2)
;


insert into ps_food_info
(type,             cost, action_points, texture,                            req_fitness, req_wizardry, req_charisma, req_nature, constitution, strength, agility, charm, confidence, empathy, intelligence, wisdom, sorcery, loyalty, spirituality, karma, fatigue)
values
('Magical Berries', 18,  -1,  'img/global-menu/foraging-magicalberries.webp', 15,            0,           0,            0,          2,             0,        0,      -1,     0,          0,       0,            0,      0,        0,       0,           0,     5),
('Fairy Nectar',    20,  -1,  'img/global-menu/foraging-fairynectar.webp',     0,            0,          20,            0,          0,             0,        0,      0,      0,          1,       0,            0,      0,        0,       0,           0,     3),
('Pixie Honey',     25,  -1,  'img/global-menu/foraging-pixiehoney.webp',     50,            0,           0,            0,          0,             1,        1,      0,      0,          0,      -1,            0,      0,        0,       0,           0,     6),
('Elven Mushroom',  30,  -1,  'img/global-menu/foraging-elvenmushroom.webp',   0,           70,           0,            0,          0,            -1,        0,      0,      0,          0,       1,            1,      0,        0,       0,           0,    10),
('Centaur Fruits',  35,  -1,  'img/global-menu/foraging-centaurfruits.webp',   0,            0,           0,           70,          0,             0,        0,      0,      2,          0,       0,           -1,      0,        0,       0,           0,    10),
('Elfroot',         35,  -1,  'img/global-menu/foraging-elfroot.webp',         0,            0,         100,            0,          0,             2,        0,      0,      0,          0,       0,            0,      2,        0,       0,          -1,    12),
('Moon Flower',     40,  -1,  'img/global-menu/foraging-moonflower.webp',    150,            0,           0,            0,          0,            -1,        0,      2,      0,          0,       0,            0,      0,        0,       0,           0,    18),
('Dragonleaf',      45,  -1,  'img/global-menu/foraging-dragonleaf.webp',      0,          170,           0,            0,          0,             0,        0,      1,      1,          0,       0,            0,      0,        0,       0,           0,    18)
;


-- =======================================================================
-- Quest tables

-- Quest definition table - base information, type text, etc.
insert into ps_quest_def
(id, enabled, type, grade, next_action, text, texture)
values
(1, true, 'Monster', 'Common', 'unicorn0', 'Speak with Unicorn', 'img/global-quest/quest1-unicorn.webp'),
(2, true, 'Event', 'Common', 'pixie0', 'Pixie-s Tea Party',  'img/global-quest/quest2-pixie.webp'),
(3, true, 'Puzzle', 'Common', 'crystal0', 'Light up the Crystals', 'img/global-quest/quest3-puzzlecave.webp'),
(4, true, 'Encounter', 'Common', 'pet0', 'Catch a Pet', 'img/global-quest/quest-default.webp'),
(5, true, 'Forage', 'System',  'forage0', 'Forage for Food', ''),
(6, true, 'Train', 'System', 'train0', 'Train your Pet', ''),
(7, true, 'Rest', 'System', 'rest1', 'Rest your pet', 'img/global-menu/rest-sleeping.webp'),
(8, true, 'Monster', 'Common', 'bobo1_pre1', 'Meeting Bobo the mouse', 'img/global-quest/quest1-unicorn.webp'),
(9, true, 'Monster', 'Common', 'pupu1_pre1', 'Meeting Pupu the Mushroom', 'img/global-quest/quest-pupu.webp')
;

-- Quest choice

-- ----------------------------------------------------------------------------------------------------------------
-- Unicorn Monster quest
-- ----------------------------------------------------------------------------------------------------------------
insert into ps_quest_choice
(quest_id, action, type, choice_count, quest_done, choice_1, choice_2, choice_3, choice_4, choice_5, action_1, action_2, action_3, action_4, action_5, action_cost, action_test, action_cmd, text, texture, face_img, emote_img)
values
-- Unicorn quest
(1, 'unicorn0', 'choice', 0, false,              '', '', '', '', '',    'unicorn1', '', '', '', '',               null, null, null, 'Filled with excitement, %PET_NAME% gathered their belongings and prepared for a questing adventure. &lt;Click the Text to Continue&gt;', '%RANDOM_HABITAT_TEXTURE%', '', ''),
(1, 'unicorn1', 'choice', 0, false,              '', '', '', '', '',    'unicorn2', '', '', '', '',               null, null, null, '[Visiting %HABITAT_NAME% Habitat] <br\> Amidst the swirling mists of the ethereal realm of %REGION_NAME%, my spectral magical companion, floated gracefully by my side.', '%RANDOM_HABITAT_TEXTURE%', '', ''),
(1, 'unicorn2', 'choice', 0, false,              '', '', '', '', '',    'unicorn3', '', '', '', '',               null, null, null, 'With its otherworldly presence and my boundless curiosity, we embarked on a journey through the veiled mysteries of the spirit world.', '%HABITAT_TEXTURE%', '', ''),
(1, 'unicorn3', 'choice', 0, false,              '', '', '', '', '',    'unicorn_start', '', '', '', '',          null, null, null, 'What daring exploits awaited us?', '%HABITAT_TEXTURE%', '', ''),

(1, 'unicorn_start', 'choice', 0, false,         '', '', '', '', '',    'unicorn_start2', '', '', '', '',         null, null, null, 'Who approaches? I am Stardust, a cautious guardian of these lands. State your intentions and tread lightly, for trust must be earned in these enchanted realms.', 'img/global-quest/quest1-unicorn.webp', '', ''),
(1, 'unicorn_start2', 'choice', 4, false,        'Fight', 'Speak', 'Runaway', 'Hide', '',    'unicorn_fight', 'unicorn_speak', 'unicorn_runaway', 'unicorn_hide', '', null, null, null, 'Choose your action:', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%SURPRISED%'),

(1, 'unicorn_fight', 'choice', 0, false,         '', '', '', '', '',     '', '', '', '', '',                       null, 'unicorn_fight', null, 'Behold, as I reveal the mightiest of my mystical arts, the formidable secrets I wield to vanquish you.', 'img/global-quest/quest1-unicorn.webp', '', ''),

(1, 'unicorn_fight_win', 'choice', 1, false,     '', '', '', '', '',     'unicorn_fight_win2', '', '', '', '',     'unicorn_fight_win', null, null, 'In a fantastical blur, the unicorn dashes towards your beloved pet, executing a mesmerizing back-kick with unparalleled skill.', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%NERVOUS%'),
(1, 'unicorn_fight_win2', 'choice', 1, false,    '', '', '', '', '',     'unicorn_fight_win3', '', '', '', '',     null, null, null, 'After a few fierce clashes, your pet triumphs, vanquishing the opponent!', 'img/global-quest/quest1-unicorn.webp', '', ''),
(1, 'unicorn_fight_win3', 'choice', 1, false,    '', '', '', '', '',     'unicorn_fight_win4', '', '', '', '',     null, null, null, 'Honestly, I was expecting a bit of unicorn sorcery instead of your run-of-the-mill, "ho-hum," horse-style back-kick..', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%SURPRISED%'),
(1, 'unicorn_fight_win4', 'choice', 0, false,    '', '', '', '', '',     'unicorn_wrapup', '', '', '', '',         null, null, null, 'I will admit your strength surpasses mine, but don''t start preaching to unicorns about how they should fight!', 'img/global-quest/quest1-unicorn.webp', '', ''),

(1, 'unicorn_fight_lose', 'choice', 1, false,    '', '', '', '', '',     'unicorn_fight_lose2', '', '', '', '',    'unicorn_fight_lose', null, null, 'With divine precision, the unicorn charges, and with a surprising back-kick, strikes your pet''s forehead, delivering a fatal blow.', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%NERVOUS%'),
(1, 'unicorn_fight_lose2', 'choice', 1, false,   '', '', '', '', '',     'unicorn_fight_lose3', '', '', '', '',    null, null, null, 'Unfortunately, the unexpected blow leaves your pet in a dire condition.', 'img/global-quest/quest1-unicorn.webp', '', ''),
(1, 'unicorn_fight_lose3', 'choice', 1, false,   '', '', '', '', '',     'unicorn_fight_lose4', '', '', '', '',    null, null, null, 'This is just unfair! I had readied myself for a potent magical onslaught, not this unexpected back-kick of yours!', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%NERVOUS%'),
(1, 'unicorn_fight_lose4', 'choice', 0, false,   '', '', '', '', '',     'unicorn_wrapup', '', '', '', '',         null, null, null, 'It is truly staggering that you underestimated the physical might of unicorns.', 'img/global-quest/quest1-unicorn.webp', '', ''),

(1, 'unicorn_speak', 'choice', 0, false,         '', '', '', '', '',     '', '', '', '', '',                       null, 'unicorn_speak', null,        'Your pet approached the mysterious unicorn, attempting to initiate a conversation.', 'img/global-quest/quest1-unicorn.webp', '', ''),
(1, 'unicorn_speak_win', 'choice', 1, false,     '', '', '', '', '',     'unicorn_speak_win2', '', '', '', '',     null, null, null, 'Please tell me, divine unicorn, how can I embrace the magic within?', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%HAPPY%'),
(1, 'unicorn_speak_win2', 'choice', 1, false,    '', '', '', '', '',     'unicorn_speak_win3', '', '', '', '',     null, null, null, 'Embrace the magic within, let your dreams guide you, and trust in your own resilience.', 'img/global-quest/quest1-unicorn.webp', '', ''),
(1, 'unicorn_speak_win3', 'choice', 1, false,    '', '', '', '', '',     'unicorn_wrapup', '', '', '', '',         'unicorn_speak_win', null, null,    'The mysterious unicorn bids your pet farewell, her voice carrying a delicate lilt of admiration.', 'img/global-quest/quest1-unicorn.webp', '', ''),

(1, 'unicorn_speak_lose', 'choice', 1, false,    '', '', '', '', '',     'unicorn_speak_lose2', '', '', '', '',    null, null, null,      'Dear divine unicorn, your sturdy legs echo the power of the mightiest male bulls.', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%HAPPY%'),
(1, 'unicorn_speak_lose2', 'choice', 1, false,   '', '', '', '', '',     'unicorn_speak_lose3', '', '', '', '',    null, null, null,      'Your deeds provoke my anger! I am a female unicorn!', 'img/global-quest/quest1-unicorn.webp', '', ''),
(1, 'unicorn_speak_lose3', 'choice', 1, false,   '', '', '', '', '',     'unicorn_fight', '', '', '', '',          null, null, null,      'The angry unicorn lets out a sharp cry, then charges menacingly towards your pet.', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%NERVOUS%'),

(1, 'unicorn_runaway', 'choice', 0, false,       '', '', '', '', '',     '', '', '', '', '',                       null, 'unicorn_runaway', null,       'With pure survival instinct propelling it, your pet attempted to dash away from the creature.', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%NERVOUS%'),
(1, 'unicorn_runaway_win', 'choice', 1, false,   '', '', '', '', '',     'unicorn_runaway_win2', '', '', '', '',   null, null, null, 'The creature, despite its efforts, failed to chase you down, leaving you out of its grasp.', 'img/global-quest/quest1-unicorn.webp', '', ''),
(1, 'unicorn_runaway_win2', 'choice', 0, false,  '', '', '', '', '',     'unicorn_wrapup', '', '', '', '',         'unicorn_runaway_win', null, null,    'Your pet has successfully escaped from the creature!', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%SICK%'),
(1, 'unicorn_runaway_lose', 'choice', 1, false,  '', '', '', '', '',     'unicorn_runaway_lose2', '', '', '', '',  null, null, null,  'Relentlessly, the creature chases your pet with unmatched speed, determined to catch up.', 'img/global-quest/quest1-unicorn.webp', '', ''),
(1, 'unicorn_runaway_lose2', 'choice', 1, false, '', '', '', '', '',     'unicorn_fight', '', '', '', '',          null, null, null,        'Your pet has been caught by the creature! A battle emerges!', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%NERVOUS%'),

(1, 'unicorn_hide', 'choice', 0, false,          '', '', '', '', '',     '', '', '', '', '',                       null, 'unicorn_hide', null,         'Swiftly, your pet seeks refuge behind barriers, attempting to avoid detection by the creature.', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%NERVOUS%'),
(1, 'unicorn_hide_win', 'choice', 1, false,      '', '', '', '', '',     'unicorn_hide_win2', '', '', '', '',      null, null, null,  'Tension fills the air as the creature ominously closes in, drawing nearer to your pet.', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%NERVOUS%'),
(1, 'unicorn_hide_win2', 'choice', 0, false,     '', '', '', '', '',     'unicorn_wrapup', '', '', '', '',         'unicorn_hide_win', null, null,     'Unaware of your pet''s presence, the creature walks away, providing a moment of relief.', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%SICK%'),
(1, 'unicorn_hide_lose', 'choice', 1, false,     '', '', '', '', '',     'unicorn_hide_lose2', '', '', '', '',     null, null, null, 'Tension fills the air as the creature ominously closes in, drawing nearer to your pet.', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%NERVOUS%'),
(1, 'unicorn_hide_lose2', 'choice', 1, false,    '', '', '', '', '',     'unicorn_fight', '', '', '', '',          null, null, null,      'The creature senses your pet''s presence, appears provoked, and swiftly dashes toward it.', 'img/global-quest/quest1-unicorn.webp', '%PET_FACE%', '%SURPRISED%'),

(1, 'unicorn_wrapup', 'choice', 0, false,        '', '', '', '', '',     'unicorn_fight_end', '', '', '', '',      null, null, null, '%FATIGUE_MSG% Your pet\'s other stats have changed as follows:<br/>%STAT_COST% %FOOD_STAT_COST%', 'img/global-quest/quest1-unicorn.webp', '', ''),
(1, 'unicorn_fight_end', 'choice', 0, true,      '', '', '', '', '',     '', '', '', '', '',                       null, null, null, '', 'img/global-quest/quest1-unicorn.webp', '', '')
;

-- unicorn Tests
insert into ps_stat_test
(quest_id, action,   win_action,         lose_action,               constitution, strength, agility, charm, confidence, empathy, intelligence, wisdom, sorcery, loyalty, spirituality, karma)
values
(1, 'unicorn_fight', 'unicorn_fight_win', 'unicorn_fight_lose',       25,           25,       25,         0,     0,        0,      10,            10,   10,       0,       0,            0),
(1, 'unicorn_speak', 'unicorn_speak_win', 'unicorn_speak_lose',        0,            0,        0,        30,    15,      20,        0,             0,    0,       0,       0,            0),
(1, 'unicorn_runaway', 'unicorn_runaway_win', 'unicorn_runaway_lose', 35,            0,       35,         0,     0,        0,       0,             0,    0,       0,       0,            0),
(1, 'unicorn_hide', 'unicorn_hide_win', 'unicorn_hide_lose',           0,            0,       10,         0,     0,        0,      35,             0,    0,       0,       0,            0)
;

-- unicorn costs
insert into ps_stat_cost
(quest_id, action,         constitution, strength, agility, charm, confidence, empathy, intelligence, wisdom, sorcery, loyalty, spirituality, karma, fatigue, food)
values
(1, 'unicorn_fight_win',   0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            1,     12,       10),
(1, 'unicorn_fight_lose',  0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,     12,        0),
(1, 'unicorn_speak_win',   0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            1,     10,       10),
(1, 'unicorn_runaway_win', 0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,      5,        5),
(1, 'unicorn_hide_win',    0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,      5,        5)
;


-- ----------------------------------------------------------------------------------------------------------------
-- Pixie Tea party quest
-- ----------------------------------------------------------------------------------------------------------------
insert into ps_quest_choice
(quest_id, action, type, choice_count, quest_done, choice_1, choice_2, choice_3, choice_4, choice_5, action_1, action_2, action_3, action_4, action_5, action_cost, action_test, action_cmd, text, texture, face_img, emote_img)
values
-- pixie quest
(2, 'pixie0', 'choice', 0, false, '', '', '', '', '',    'pixie1', '', '', '', '',                              null, null, null, 'Filled with excitement, %PET_NAME% gathered their belongings and prepared for a questing adventure. &lt;Click the Text to Continue&gt;', 'img/global-quest/quest-default.webp', '', ''),
(2, 'pixie1', 'choice', 0, false, '', '', '', '', '',    'pixie2', '', '', '', '',                              null, null, null, '[Visiting %HABITAT_NAME% Habitat] <br\> Amidst the swirling mists of the ethereal realm, my spectral magical companion of %REGION_NAME%, floated gracefully by my side.', 'img/global-quest/quest-default.webp', '', ''),
(2, 'pixie2', 'choice', 0, false, '', '', '', '', '',    'pixie3', '', '', '', '',                              null, null, null, 'With its otherworldly presence and my boundless curiosity, we embarked on a journey through the veiled mysteries of the spirit world.', 'img/global-quest/quest-default.webp', '', ''),
(2, 'pixie3', 'choice', 0, false, '', '', '', '', '',    'pixie4', '', '', '', '',                              null, null, null, 'What daring exploits awaited us?', 'img/global-quest/quest-default.webp', '', ''),
(2, 'pixie4', 'choice', 0, false, '', '', '', '', '',    'pixie_start', '', '', '', '',                         null, null, null, 'Amidst the tangled underbrush, a mysterious glow beckons.', 'img/global-quest/quest2-pixie.webp', '', ''),
(2, 'pixie_start', 'choice', 2, false, 'Accept', 'Reject', '', '', '',    'pixie_accept', 'pixie_reject', '', '', '', null, null, null, 'Wee folk caught in the act! What a surprise to have an audience for our whimsical tea affair! Would you like to join us?', 'img/global-quest/quest2-pixie.webp', '', ''),

(2, 'pixie_accept', 'choice', 0, false,         '', '', '', '', '',    '', '', '', '', '',                      null, 'pixie_accept', null,     'Drawn by curiosity, your pet approaches the pixie group, observing their tea-sipping gathering.', 'img/global-quest/quest2-pixie.webp', '', ''),

(2, 'pixie_accept_win', 'choice', 0, false,     '', '', '', '', '',    'pixie_accept_win2', '', '', '', '',     null, null,  null,              'Pray, grant me the honor of joining your revelry!', 'img/global-quest/quest2-pixie.webp', '%PET_FACE%', '%HAPPY%'),
(2, 'pixie_accept_win2', 'choice', 0, false,    '', '', '', '', '',    'pixie_accept_win3', '', '', '', '',     null, null,  null,              'The pixies beamed with approval, nodding graciously as they beckoned your faithful pet to join their midst.', 'img/global-quest/quest2-pixie.webp', '', ''),
(2, 'pixie_accept_win3', 'choice', 0, false,    '', '', '', '', '',    'pixie_accept_win4', '', '', '', '',     null, null,  null,              'Amidst the tea party, your pet and the pixie share delightful moments of joy that linger till night''s end.', 'img/global-quest/quest2-pixie.webp', '%PET_FACE%', '%CONFIDENT%'),
(2, 'pixie_accept_win4', 'choice', 0, false,    '', '', '', '', '',    'pixie_wrapup', '', '', '', '',          'pixie_accept_win', null, null, 'May the bubbles in our tea sparkle like stars in the moonlit sky!', 'img/global-quest/quest2-pixie.webp', '%PET_FACE%', '%CONFIDENT%'),

(2, 'pixie_accept_lose', 'choice', 0, false,    '', '', '', '', '',    'pixie_accept_lose2', '', '', '', '',    null, null,  null,              'What''s up, Pixies? You having a wild time getting wasted?', 'img/global-quest/quest2-pixie.webp', '%PET_FACE%', '%EXCITED%'),
(2, 'pixie_accept_lose2', 'choice', 0, false,   '', '', '', '', '',    'pixie_accept_lose3', '', '', '', '',    null, null,  null,              'It appeared that the pixies raised their eyebrows in distaste at your pet''s tone.', 'img/global-quest/quest2-pixie.webp', '', ''),
(2, 'pixie_accept_lose3', 'choice', 0, false,   '', '', '', '', '',    'pixie_accept_lose4', '', '', '', '',     null, null,  null,              'We pixies demand a certain level of decorum. Farewell.', 'img/global-quest/quest2-pixie.webp', '', ''),
(2, 'pixie_accept_lose4', 'choice', 0, false,   '', '', '', '', '',    'pixie_wrapup', '', '', '', '',          'pixie_accept_lose', null, null,'The pixies vanished in a radiant burst of white light, leaving your pet behind, without uttering a word.', 'img/global-quest/quest2-pixie.webp', '%PET_FACE%', '%SURPRISED%'),

(2, 'pixie_reject', 'choice', 0, false, '', '', '', '', '',            'pixie_reject2', '', '', '', '',          null, null, null, 'Showing reluctance, your pet distances itself from the pixie gathering, refusing the tea party invitation.', 'img/global-quest/quest2-pixie.webp', '%PET_FACE%', '%SICK%'),
(2, 'pixie_reject2', 'choice', 0, false,  '', '', '', '', '',          'pixie_reject3', '', '', '', '',          null, null, null, 'I thought we shared a special bond, but it seems I was mistaken.', 'img/global-quest/quest2-pixie.webp', '', ''),
(2, 'pixie_reject3', 'choice', 0, false, '', '', '', '', '',           'pixie_wrapup', '', '', '', '',           'pixie_reject', null, null, 'The misty fog envelops the disappearing pixie group, their disappointed expressions fading into the unknown.', 'img/global-quest/quest2-pixie.webp', '', ''),

(2, 'pixie_wrapup', 'choice', 0, false,   '', '', '', '', '',          'pixie_end', '', '', '', '',              null, null, null, '%FATIGUE_MSG% Your pet\'s other stats have changed as follows:<br/>%STAT_COST% %FOOD_STAT_COST%', 'img/global-quest/quest2-pixie.webp', '', ''),
(2, 'pixie_end', 'choice', 0, true,       '', '', '', '', '',          '', '', '', '', '',                       null, null, null, '', 'img/global-quest/quest2-pixie.webp', '', '')
;

-- Pixie tests
insert into ps_stat_test
(quest_id, action,   win_action,         lose_action,                constitution, strength, agility, charm, confidence, empathy, intelligence, wisdom, sorcery, loyalty, spirituality, karma)
values
(2, 'pixie_accept', 'pixie_accept_win', 'pixie_accept_lose',           0,            0,        0,        25,    20,         0,       0,             0,    0,       0,      15,            0)
;

-- Pixie costs
insert into ps_stat_cost
(quest_id, action,         constitution, strength, agility, charm, confidence, empathy, intelligence, wisdom, sorcery, loyalty, spirituality, karma, fatigue, food)
values
(2, 'pixie_accept_win',    0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        1,            0,    -30,        0),
(2, 'pixie_accept_lose',   0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,     10,        0),
(2, 'pixie_reject',        0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,     10,        0)
;



-- ----------------------------------------------------------------------------------------------------------------
-- Crystal Puzzle Quest
-- ----------------------------------------------------------------------------------------------------------------
insert into ps_quest_choice
(quest_id, action, type, choice_count, quest_done, choice_1, choice_2, choice_3, choice_4, choice_5, action_1, action_2, action_3, action_4, action_5, action_cost, action_test, action_cmd, text, texture, face_img, emote_img)
values
-- light up crystals quest
(3, 'crystal0', 'choice', 0, false, '', '', '', '', '',                             'crystal1', '', '', '', '',              null, null, null, 'Filled with excitement, %PET_NAME% gathered their belongings and prepared for a questing adventure. &lt;Click the Text to Continue&gt;', 'img/global-quest/quest-default.webp', '', ''),
(3, 'crystal1', 'choice', 0, false, '', '', '', '', '',                             'crystal2', '', '', '', '',              null, null, null, '[Visiting %HABITAT_NAME% Habitat] <br\> Amidst the swirling mists of the ethereal realm of %REGION_NAME%, my spectral magical companion, floated gracefully by my side.', 'img/global-quest/quest-default.webp', '', ''),
(3, 'crystal2', 'choice', 0, false, '', '', '', '', '',                             'crystal3', '', '', '', '',              null, null, null, 'With its otherworldly presence and my boundless curiosity, we embarked on a journey through the veiled mysteries of the spirit world.', 'img/global-quest/quest-default.webp', '', ''),
(3, 'crystal3', 'choice', 0, false, '', '', '', '', '',                             'crystal_start', '', '', '', '',         null, null, null, 'What daring exploits awaited us?', 'img/global-quest/quest-default.webp', '', ''),

(3, 'crystal_start', 'choice', 0, false,           '', '', '', '', '',              'crystal_start1', '', '', '', '',                    null, null, null, 'Your pet stumbles upon a mysterious cave brimming with sparkling crystals.', 'img/global-quest/quest3-puzzlecave.webp', '', ''),
(3, 'crystal_start1', 'choice', 0, false,          '', '', '', '', '',              'crystal_start2', '', '', '', '',                    null, null, null, 'Among them, a few glow in a particular pattern, seemingly offering clues to unravel hidden mysteries.', 'img/global-quest/quest3-puzzlecave.webp', '', ''),
(3, 'crystal_start2', 'choice', 2, false,          'Yes', 'No', '', '', '',         'crystal_riddle1', 'crystal_riddle2_no', '', '', '', null, null, null, 'Would your pet dare to delve deeper into the mystery?', 'img/global-quest/quest3-puzzlecave.webp', '%PET_FACE%', '%SURPRISED%'),

(3, 'crystal_riddle1', 'choice', 0, false,         '', '', '', '', '',              '', '', '', '', '',                                  null, 'crystal_riddle1', null, 'Your pet leaps around, rearranging the glowing crystals into specific orders while exploring the area.', 'img/global-quest/quest3-puzzlecave.webp', '', ''),
(3, 'crystal_riddle1_win', 'choice', 0, false,     '', '', '', '', '',              'crystal_riddle1_win2', '', '', '', '',              'crystal_riddle1_win', null, null,              'With a stroke of luck, your pet successfully unravels the second clue, leading to the emergence of additional glowing crystals.', 'img/global-quest/quest3-puzzlecave.webp', '%PET_FACE%', '%EXCITED%'),
(3, 'crystal_riddle1_win2','choice',  2, false,    'Continue', 'Stop', '', '', '',  'crystal_riddle2_start', 'crystal_riddle_stop', '', '', '', null, null, null,              'Only a small number of crystals await rearrangement to complete the radiant display. Shall we proceed and solve the final mystery?', 'img/global-quest/quest3-puzzlecave.webp', '%PET_FACE%', '%HAPPY%'),
(3, 'crystal_riddle1_lose', 'choice', 0, false,    '', '', '', '', '',              'crystal_riddle_stop', '', '', '', '',               'crystal_riddle1_lose', null, null, 'As your pet starts rearranging the crystals, they suddenly lose their glow and become inactive.', 'img/global-quest/quest3-puzzlecave.webp', '%PET_FACE%', '%DISAPPOINTED%'),

(3, 'crystal_riddle2_no', 'choice', 0, false,       '', '', '', '', '',             'crystal_riddle_stop', '', '', '', '',               null, null, null, 'Your pet takes a cautious step backward, letting out a startled shriek as sudden hollowing sounds echo from the distance.', 'img/global-quest/quest3-puzzlecave.webp', '%PET_FACE%', '%SURPRISED%'),

(3, 'crystal_riddle2_start', 'choice', 0, false, '', '', '', '', '',                '', '', '', '', '',                                  null, 'crystal_riddle2', null, 'Curiosity driving it, your pet delves deeper, seeking more crystals to rearrange and solve the mysteries once more.', 'img/global-quest/quest3-puzzlecave.webp', '', ''),
(3, 'crystal_riddle2_win', 'choice', 0, false, '', '', '', '', '',                  'crystal_riddle2_win2', '', '', '', '',              'crystal_riddle2_win', null, null,              'With a stroke of luck, your pet successfully unravels the second clue, leading to the emergence of additional glowing crystals.', 'img/global-quest/quest3-puzzlecave.webp', '%PET_FACE%', '%EXCITED%'),
(3, 'crystal_riddle2_win2','choice',  0, false, 'Continue', 'Stop', '', '', '',     'crystal_riddle3_start', 'crystal_riddle_stop', '', '', '', null, null, null,  'Only a small number of crystals await rearrangement to complete the radiant display. Shall we proceed and solve the final mystery?', 'img/global-quest/quest3-puzzlecave.webp', '%PET_FACE%', '%HAPPY%'),
(3, 'crystal_riddle2_lose', 'choice', 0, false, '', '', '', '', '',                 'crystal_riddle_stop', '', '', '', '',               'crystal_riddle2_lose', null, null,              'While rearranging the glowing crystals once more, an unforeseen glitch causes them all to lose their luminosity.', 'img/global-quest/quest3-puzzlecave.webp', '%PET_FACE%', '%DISAPPOINTED%'),

(3, 'crystal_riddle3_start', 'choice', 0, false, '', '', '', '', '',                '', '', '', '', '',                                  null, 'crystal_riddle3', null, 'Your pet explores further more once again, searching for additional crystals to rearrange in order to unlock the final mystery.', 'img/global-quest/quest3-puzzlecave.webp', '', ''),
(3, 'crystal_riddle3_win', 'choice', 0, false, '', '', '', '', '',                  'crystal_riddle3_win2', '', '', '', '',              'crystal_riddle2_win', null, null, 'Your pet\'s mastery of the clues brings about a wondrous spectacle as the entire crystal cave illuminates in vibrant hues!', 'img/global-quest/quest3-puzzlecave.webp', '%PET_FACE%', '%EXCITED%'),
(3, 'crystal_riddle3_win2', 'choice', 0, false, '', '', '', '', '',                 'crystal_riddle_wrapup', '', '', '', '',             null, null, null,     'A hidden passageway opens, unveiling a trove of delightful surprises within the cave!', 'img/global-quest/quest3-puzzlecave.webp', '', ''),
(3, 'crystal_riddle3_lose', 'choice', 0, false, '', '', '', '', '',                 'crystal_riddle_stop', '', '', '', '',               'crystal_riddle3_lose', null, null,    'As your pet struggled to solve the demanding riddles, the once radiant crystals lost their glow, casting the cave into utter darkness.', 'img/global-quest/quest3-puzzlecave.webp', '%PET_FACE%', '%DISAPPOINTED%'),

(3, 'crystal_riddle_stop', 'choice', 0, false, '', '', '', '', '',                  'crystal_riddle_wrapup', '', '', '', '', null, null, null,    'Perplexed, your pet cocks its head in puzzlement, retreats from the crystals, and exits the scene.', 'img/global-quest/quest3-puzzlecave.webp', '', ''),
(3, 'crystal_riddle_wrapup', 'choice', 0, false,   '', '', '', '', '',              'crystal_riddle_end', '', '', '', '',     null, null, null, '%FATIGUE_MSG% Your pet\'s other stats have changed as follows:<br/>%STAT_COST% %FOOD_STAT_COST%', 'img/global-quest/quest3-puzzlecave.webp', '', ''),
(3, 'crystal_riddle_end', 'choice', 0, true,       '', '', '', '', '',              '', '', '', '', '',                       null, null, null, '', 'img/global-quest/quest3-puzzlecave.webp', '', '')
;

-- crystal puzzle tests
insert into ps_stat_test
(quest_id, action,   win_action,         lose_action,               constitution, strength, agility, charm, confidence, empathy, intelligence, wisdom, sorcery, loyalty, spirituality, karma)
values
(3, 'crystal_riddle1', 'crystal_riddle1_win', 'crystal_riddle1_lose',  0,            0,        0,         0,     0,        0,      20,            10,    0,       0,      10,            0),
(3, 'crystal_riddle2', 'crystal_riddle2_win', 'crystal_riddle2_lose',  0,            0,        0,         0,     0,        0,      20,            20,    0,       0,      13,            0),
(3, 'crystal_riddle3', 'crystal_riddle3_win', 'crystal_riddle3_lose',  0,            0,        0,         0,     0,        0,      50,            30,    0,       0,      15,            0)
;

-- crystal puzzle costs
insert into ps_stat_cost
(quest_id, action,         constitution, strength, agility, charm, confidence, empathy, intelligence, wisdom, sorcery, loyalty, spirituality, karma, fatigue, food)
values
(3, 'crystal_riddle1_win', 0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,     10 ,       15),
(3, 'crystal_riddle1_lose',0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,     10,        0),

(3, 'crystal_riddle2_win', 0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        1,            1,     10,       35),
(3, 'crystal_riddle2_lose',0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,     10,        0),

(3, 'crystal_riddle3_win', 0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            1,     10,       50),
(3, 'crystal_riddle4_lose',0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,     10,        0)
;

-- ----------------------------------------------------------------------------------------------------------------
-- Random Pet Encounter quest
-- ----------------------------------------------------------------------------------------------------------------
insert into ps_quest_choice
(quest_id, action, type, choice_count, quest_done, choice_1, choice_2, choice_3, choice_4, choice_5, action_1, action_2, action_3, action_4, action_5, action_cost, action_test, action_cmd, text, texture, face_img, emote_img)
values
-- capture pet 1
(4, 'pet0', 'choice', 0, false,             '', '', '', '', '',                         'pet1', '', '', '', '',                                         null, null, null, 'Filled with excitement, %PET_NAME% gathered their belongings and prepared for a questing adventure. &lt;Click the Text to Continue&gt;', '%RANDOM_HABITAT_TEXTURE%', '', ''),
(4, 'pet1', 'choice', 0, false,             '', '', '', '', '',                         'pet2', '', '', '', '',                                         null, null, null, '[Visiting %HABITAT_NAME% Habitat] <br\> Amidst the swirling mists of the ethereal realm of %REGION_NAME%, my spectral magical companion, floated gracefully by my side.', '%RANDOM_HABITAT_TEXTURE%', '', ''),
(4, 'pet2', 'choice', 0, false,             '', '', '', '', '',                         'pet3', '', '', '', '',                                         null, null, null, 'With its otherworldly presence and my boundless curiosity, we embarked on a journey through the veiled mysteries of the spirit world.', '%HABITAT_TEXTURE%', '', ''),
(4, 'pet3', 'choice', 0, false,             '', '', '', '', '',                         'pet_prepare', '', '', '', '',                                  null, null, '%GET_WILD_PET%', 'What daring exploits awaited us?', '%HABITAT_TEXTURE%', '', ''),

(4, 'pet_prepare', 'choice', 0, false,      '', '', '', '', '',                          'pet_start', '', '', '', '',                                   null, null, null, 'As your exploration unfolds, your loyal pet uncovers a wondrous creature.', '%WILD_PET_TEXTURE%', '%PET_FACE%', ''),
(4, 'pet_start', 'choice', 4, false,        'Speak', 'Entice', 'Fight', 'Ignore', '',    'pet_speak', 'pet_entice', 'pet_fight', 'pet_ignore', '',      null, null, null, 'This creature shares similarities yet boasting extraordinary traits that captivate your pet''s interest.', '%WILD_PET_TEXTURE%', '', ''),

(4, 'pet_speak', 'choice', 0, false,        '', '', '', '', '',                          '', '', '', '', '',                                            null, '%SPEAK_WILD_PET%', null, 'With an inquisitive spirit, your beloved pet ventures closer to the mysterious being, studying its form intently and attempting to communicate', '%WILD_PET_TEXTURE%', '', ''),
(4, 'pet_speak_win', 'choice', 1, false,    '', '', '', '', '',                          'pet_speak_win2', '', '', '', '',                              'pet_speak_win', null, null, 'Hey, enchanted one! Let''s turn this world into our playground of fun!', '%WILD_PET_TEXTURE%', '%PET_FACE%', '%HAPPY%'),
(4, 'pet_speak_win2', 'choice', 1, false,    '', '', '', '', '',                         'pet_wrapup', '', '', '', '',                                  null, null, null, 'The creature and your loyal pet frolic and leap joyously, their interactions radiating harmony and delight', '%WILD_PET_TEXTURE%', '%PET_FACE%', '%EXCITED%'),
(4, 'pet_speak_lose', 'choice', 0, false,   '', '', '', '', '',                          'pet_speak_lose2', '', '', '', '',                             'pet_speak_lose', null, null, 'Eh.. That sparkling tail of yours.. Kinda not working. Just saying..', '%WILD_PET_TEXTURE%', '%PET_FACE%', '%TIRED%'),
(4, 'pet_speak_lose2', 'choice', 0, false,   '', '', '', '', '',                         'pet_wrapup', '', '', '', '',                                  null, null, null, 'Quizzical brows furrowed upon the creature''s visage, casting an air of tension as it abruptly flees from your pet''s presence.', '%WILD_PET_TEXTURE%', '%PET_FACE%', '%SURPRISED%'),

(4, 'pet_entice', 'choice', 0, false,       '', '', '', '', '',                          '', '', '', '', '',                                            null, '%ENTICE_WILD_PET%', null, 'Your pet performs agile flips and spins, defying gravity in a mesmerizing display of magical prowess.', '%WILD_PET_TEXTURE%', '%PET_FACE%', ''),
(4, 'pet_entice_win', 'choice', 0, false,   '', '', '', '', '',                          'pet_entice_win2', '', '', '', '',                             'pet_entice_win', null, null, 'The creature observes, twirling alongside in elegant synchrony.', '%WILD_PET_TEXTURE%', '%PET_FACE%', '%CONFIDENT%'),
(4, 'pet_entice_win2', 'choice', 0, false,   '', '', '', '', '',                         'pet_wrapup', '', '', '', '',                                  null, null, null, 'Playful tricks forge a deep bond between your pet and the entranced creature, ensuring the enticement''s success.', '%WILD_PET_TEXTURE%', '%PET_FACE%', '%CONFIDENT%'),
(4, 'pet_entice_lose', 'choice', 0, false,  '', '', '', '', '',                          'pet_entice_lose2', '', '', '', '',                            'pet_entice_lose', null, null, 'Unfortunately, one wild flip turns into a foot-stomping accident, leaving the creature yelling in agony.', '%WILD_PET_TEXTURE%', '%PET_FACE%', '%NERVOUS%'),
(4, 'pet_entice_lose2', 'choice', 0, false,  '', '', '', '', '',                         'pet_wrapup', '', '', '', '',                                  null, null, null, 'In its fury, the creature headbutts your pet in revenge before swiftly running off and disappearing.', '%WILD_PET_TEXTURE%', '%PET_FACE%', '%DISAPPOINTED%'),

(4, 'pet_fight', 'choice', 0, false,        '', '', '', '', '',                          '', '', '', '', '',                                            null, '%FIGHT_WILD_PET%', null, 'Swift as an arrow, your valiant pet charges at the mysterious creature, dashing with lightning speed in a fervent attempt to capture it.', '%WILD_PET_TEXTURE%', '', ''),
(4, 'pet_fight_win', 'choice', 0, false,    '', '', '', '', '',                          'pet_fight_win2', '', '', '', '',                              'pet_fight_win', null, null, 'A masterful juggling display ends with a pie to the creature''s face, ensuring your pet''s win', '%WILD_PET_TEXTURE%', '%PET_FACE%', '%EXCITED%'),
(4, 'pet_fight_win2', 'choice', 0, false,    '', '', '', '', '',                         'pet_wrapup', '', '', '', '',                                  null, null, null, 'After a fierce battle, your pet unleashed a dazzling spell, binding the creature in luminous chains of victory.', '%WILD_PET_TEXTURE%', '%PET_FACE%', '%EXCITED%'),

(4, 'pet_fight_lose', 'choice', 0, false,   '', '', '', '', '',                          'pet_fight_lose2', '', '', '', '',                              'pet_fight_lose', null, null, 'In the midst of battle, the creature''s bitch slaps kept your pet on the defensive, losing ground.', '%WILD_PET_TEXTURE%', '%PET_FACE%', '%DISAPPOINTED%'),
(4, 'pet_fight_lose2', 'choice', 0, false,   '', '', '', '', '',                         'pet_wrapup', '', '', '', '',                                   null, null, null, 'Your pet, battered and bewildered, could only helplessly observe the creature''s disappearance.', '%WILD_PET_TEXTURE%', '%PET_FACE%', '%DISAPPOINTED%'),

(4, 'pet_ignore', 'choice', 0, false,       '', '', '', '', '',                          'pet_wrapup', '', '', '', '',                                  'pet_ignore', null, null, 'Your pet indifferently disregards the enigmatic creature, departing the scene without further ado, unperturbed by its presence.', '%WILD_PET_TEXTURE%', '', ''),

(4, 'pet_wrapup', 'choice', 0, false,       '', '', '', '', '',                          'pet_end', '', '', '', '',                                     null, null, null, '%FATIGUE_MSG% Your pet''s other stats have changed as follows:<br/>%STAT_COST% %FOOD_STAT_COST%', '%WILD_PET_TEXTURE%', '', ''),
(4, 'pet_end', 'choice', 0, true,           '', '', '', '', '',                          '', '', '', '', '',                                            null, null, null, '', '%WILD_PET_TEXTURE%', '', '')
;

-- Pet tests


-- pet costs
insert into ps_stat_cost
(quest_id, action,         constitution, strength, agility, charm, confidence, empathy, intelligence, wisdom, sorcery, loyalty, spirituality, karma, fatigue, food)
values
(4, 'pet_speak_win',       0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,    -50,        0),
(4, 'pet_speak_lose',      0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,     25,        0),
(4, 'pet_entice_win',      0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,     25,        0),
(4, 'pet_entice_lose',     0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,     25,        0),
(4, 'pet_fight_win',       0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,     25,        0),
(4, 'pet_fight_lose',      0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,     25,        0),
(4, 'pet_ignore',          0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,      5,        0)
;


-- ----------------------------------------------------------------------------------------------------------------
-- Forage quest
-- ----------------------------------------------------------------------------------------------------------------
insert into ps_quest_choice
(quest_id, action, type, choice_count, quest_done, choice_1, choice_2, choice_3, choice_4, choice_5, action_1, action_2, action_3, action_4, action_5, action_cost, action_test, action_cmd, text, texture, face_img, emote_img)
values
-- Forage
(5, 'forage0', 'choice', 0, false,             '', '', '', '', '',                         'forage1', '', '', '', '',                                        null, null, null, 'Filled with excitement, %PET_NAME% gathered their belongings and readied themselves for a training adventure. <br/> &lt;Click the Text to Continue&gt;', '%FOOD_TEXTURE%', '', ''),
(5, 'forage1', 'choice', 0, false,             '', '', '', '', '',                         'forage2', '', '', '', '',                                        null, null, null, 'In the heart of the mysterious Forest, the spirited %PET_NAME% set out on a whimsical adventure to find %FOOD_NAME%.', '%FOOD_TEXTURE%', '', ''),
(5, 'forage2', 'choice', 0, false,             '', '', '', '', '',                         'forage3', '', '', '', '',                                        null, null, null, 'With a gleam of excitement in its eyes, %PET_NAME% hopped along the winding path, its little paws leaving tiny imprints in the soft moss.', '%FOOD_TEXTURE%', '%PET_FACE%', '%HAPPY%'),
(5, 'forage3', 'choice', 0, false,             '', '', '', '', '',                         'forage_test', '', '', '', '',                                    null, null, null, 'As it ventured deeper into the woods, %PET_NAME%''s curiosity led it to a glade where the %FOOD_NAME% seemed to glow with light.', '%FOOD_TEXTURE%', '%PET_FACE%', '%SURPRISED%'),
(5, 'forage_test', 'choice', 0, false,         '', '', '', '', '',                         '', '', '', '', '',                                               null, '%FORAGE_TEST%', null, 'Without hesitation, it approached the bushes with a charming twinkle in its eye.', '%FOOD_TEXTURE%', '', ''),
(5, 'forage_win1', 'choice', 0, false,         '', '', '', '', '',                         'forage_win2', '', '', '', '',                                    '%FORAGE_COST_WIN%', null, null, 'With a gentle sigh, %PET_NAME% began to gather the %FOOD_NAME% into its little pouch, cherishing each luminous morsel.', '%FOOD_TEXTURE%', '', ''),
(5, 'forage_win2', 'choice', 0, false,         '', '', '', '', '',                         'forage_final1', '', '', '', '',                                  null, null, null, 'With a triumphant squeal, %PET_NAME% twirled around the glade, its paws collecting the luminous berries  that fell like fairy blessings.', '%FOOD_TEXTURE%', '%PET_FACE%', '%HAPPY%'),
(5, 'forage_unhealthy1', 'choice', 0, false,   '', '', '', '', '',                         'forage_final1', '', '', '', '',                                  '%FORAGE_COST_LOSE%', null, null, 'Yet, as it collected, a sudden feeling of unwellness washed over %PET_NAME%. Despite its determination, it couldn''t gather all the berries.', '%FOOD_TEXTURE%', '%PET_FACE%', '%TIRED%'),
(5, 'forage_lose1', 'choice', 0, false,        '', '', '', '', '',                         'forage_lose2', '', '', '', '',                                   '%FORAGE_COST_LOSE%', null, null, 'With a determined spirit, %PET_NAME% began to gather the %FOOD_NAME% into its little pouch, cherishing each luminous item.', '%FOOD_TEXTURE%', '', ''),
(5, 'forage_lose2', 'choice', 0, false,        '', '', '', '', '',                         'forage_final1', '', '', '', '',                                  null, null, null, 'Yet, try as it might, %PET_NAME%''s paws weren''t skillful enough to collect them all. It realized it needed more fitness to reach the higher branches where the ripest berries glistened.', '%FOOD_TEXTURE%', '%PET_FACE%', '%DISAPPOINTED%'),
(5, 'forage_final1', 'choice', 0, false,       '', '', '', '', '',                         'forage_final2', '', '', '', '',                                  null, null, null, 'As a result, %PET_NAME% has gathered %FOOD_COST% units of food by foraging for %FOOD_NAME%. %FOOD_MSG_SICK%', '%FOOD_TEXTURE%', '', ''),
(5, 'forage_final2', 'choice', 0, false,       '', '', '', '', '',                         'forage_end', '', '', '', '',                                     null, null, null, 'Furthermore, %PET_NAME%''s statistics have undergone the following changes.<br/>%STAT_COST%', '%FOOD_TEXTURE%', '', ''),
(5, 'forage_end', 'choice', 0, true,           '', '', '', '', '',                         '', '', '', '', '',                                               null, null, null, '', '%FOOD_TEXTURE', '', '')
;

-- ----------------------------------------------------------------------------------------------------------------
-- training quest
-- ----------------------------------------------------------------------------------------------------------------
insert into ps_quest_choice
(quest_id, action, type, choice_count, quest_done, choice_1, choice_2, choice_3, choice_4, choice_5, action_1, action_2, action_3, action_4, action_5, action_cost, action_test, action_cmd, text, texture, face_img, emote_img)
values
-- Train
(6, 'train0', 'choice', 0, false,             '', '', '', '', '',                         'train1', '', '', '', '',                                  null, null, null, 'Filled with excitement, %PET_NAME% gathered their belongings and readied themselves for a training adventure. &lt;Click the Text to Continue&gt;', '%TRAIN_TEXTURE%', '', ''),
(6, 'train1', 'choice', 0, false,             '', '', '', '', '',                         'train2', '', '', '', '',                                  null, null, null, 'In a whimsical realm, young %PET_NAME% embarks on an adventure to grow stronger', '%TRAIN_TEXTURE%', '', ''),
(6, 'train2', 'choice', 0, false,             '', '', '', '', '',                         '', '', '', '', '',                                        null, '%TRAIN_TEST%', null, '%PET_NAME%''s clumsy start doesn''t deter its spirit. With every stumble, it learns, a determination like no other.', '%TRAIN_TEXTURE%', '', ''),
(6, 'train_win1', 'choice', 0, false,         '', '', '', '', '',                         'train_win2', '', '', '', '',                              null, null, null, '%PET_NAME%''s cute confusion turns into cleverness. It tackles challenges with a spirited heart.', '%TRAIN_TEXTURE%', '%PET_FACE%', '%HAPPY%'),
(6, 'train_win2', 'choice', 0, false,         '', '', '', '', '',                         'train_win3', '', '', '', '',                              null, null, null, '%PET_NAME%''s efforts sparkle, with all stats rising and each achievement celebrated with endearing determination.', '%TRAIN_TEXTURE%', '', ''),
(6, 'train_win3', 'choice', 0, false,         '', '', '', '', '',                         'train_wrapup', '', '', '', '',                            '%TRAIN_COST%', null, null, 'As darkness approaches, %PET_NAME% faces it, newfound strength echoing its growth. The tale becomes a beacon of persistence and devotion.', '%TRAIN_TEXTURE%', '%PET_FACE%', '%EXCITED%'),
(6, 'train_lose1', 'choice', 0, false,        '', '', '', '', '',                         'train_lose2', '', '', '', '',                             null, null, null, '%PET_NAME%''s initial confusion morphs into cleverness. Challenges are embraced with a spirited heart.', '%TRAIN_TEXTURE%', '%PET_FACE%', '%CONFIDENT%'),
(6, 'train_lose2', 'choice', 0, false,        '', '', '', '', '',                         'train_lose3', '', '', '', '',                             null, null, null, '%PET_NAME%''s efforts shine - all growing, celebrated with endearing determination.', '%TRAIN_TEXTURE%', '', ''),
(6, 'train_lose3', 'choice', 0, false,        '', '', '', '', '',                         'train_wrapup', '', '', '', '',                            '%TRAIN_COST%', null, null, 'Amidst some struggles and not feeling its best, %PET_NAME% persists, embodying the spirit of determined dedication.', '%TRAIN_TEXTURE%', '%PET_FACE%', '%TIRED%'),
(6, 'train_wrapup', 'choice', 0, false,       '', '', '', '', '',                         'train_end', '', '', '', '',                               null, null, null, 'As a result, %PET_NAME% has raised the following stats by going through %TRAIN_NAME% training.<br/>%STAT_COST% %FOOD_STAT_COST%', '%TRAIN_TEXTURE%', '', ''),
(6, 'train_end', 'choice', 0, true,           '', '', '', '', '',                         '', '', '', '', '',                                        null, null, null, '', '%TRAIN_TEXTURE%', '', '')
;


-- ----------------------------------------------------------------------------------------------------------------
-- Resting quest
-- ----------------------------------------------------------------------------------------------------------------
insert into ps_quest_choice
(quest_id, action, type, choice_count, quest_done, choice_1, choice_2, choice_3, choice_4, choice_5, action_1, action_2, action_3, action_4, action_5, action_cost, action_test, action_cmd, text, texture, face_img, emote_img)
values
-- Rest
(7, 'rest1', 'choice', 0, false,             '', '', '', '', '',                         'rest_end', '', '', '', '',                               null, null, '%REST_CMD%', 'All your pets had a sound sleep on the moonlit night and reduced 10 fatigue points!', 'img/global-menu/rest-sleeping.webp', '', ''),
(7, 'rest_end', 'choice', 0, true,           '', '', '', '', '',                         '', '', '', '', '',                                       null, null, null, '', 'img/global-menu/rest-sleeping.webp', '', '')
;

-- ----------------------------------------------------------------------

-- ----------------------------------------------------------------------------------------------------------------
-- Meeting BoBo the mouse Quest
-- ----------------------------------------------------------------------------------------------------------------
insert into ps_quest_choice
(quest_id, action, type, choice_count, quest_done, choice_1, choice_2, choice_3, choice_4, choice_5, action_1, action_2, action_3, action_4, action_5, action_cost, action_test, action_cmd, text, texture, face_img, emote_img)
values
-- Bobo the mouse (code "bobo1")
(8, 'bobo1_pre1', 'choice', 0, false,              '', '', '', '', '',    'bobo1_pre2', '', '', '', '',        null, null, null, 'Filled with excitement, %PET_NAME% gathered their belongings and prepared for a questing adventure. &lt;Click the Text to Continue&gt;', '%RANDOM_HABITAT_TEXTURE%', '', ''),
(8, 'bobo1_pre2', 'choice', 0, false,              '', '', '', '', '',    'bobo1_pre3', '', '', '', '',        null, null, null, '[Visiting %HABITAT_NAME% Habitat] <br\> Amidst the swirling mists of the ethereal realm of %REGION_NAME%, my spectral magical companion, floated gracefully by my side.', '%RANDOM_HABITAT_TEXTURE%', '', ''),
(8, 'bobo1_pre3', 'choice', 0, false,              '', '', '', '', '',    'bobo1_pre4', '', '', '', '',        null, null, null, 'With its otherworldly presence and my boundless curiosity, we embarked on a journey through the veiled mysteries of the spirit world.', '%HABITAT_TEXTURE%', '', ''),
(8, 'bobo1_pre4', 'choice', 0, false,              '', '', '', '', '',    'bobo1_1.0', '', '', '', '',         null, null, null, 'What daring exploits awaited us?', '%HABITAT_TEXTURE%', '', ''),

(8, 'bobo1_1.0', 'choice', 0, false,              '', '', '', '', '',    'bobo1_1.1', '', '', '', '',          'bobo1_initial_cost', null, null, '(%PET_NAME% explores the surroundings and encounters a seemingly harmless mouse)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_1.1', 'choice', 0, false,              '', '', '', '', '',    'bobo1_1.2', '', '', '', '',          null, null, null, '(The tiny mouse spots %PET_NAME%, prompting a gasp of horror in reaction)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_1.2', 'choice', 0, false,              '', '', '', '', '',    'bobo1_1.3', '', '', '', '',          null, null, null, '(%PET_NAME% tilts its head and approaches the creature)', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%SURPRISED%'),
(8, 'bobo1_1.3', 'choice', 0, false,              '', '', '', '', '',    'bobo1_1.4', '', '', '', '',          null, null, null, 'No!! Don''t take BoBo''s food!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_1.4', 'choice', 0, false,              '', '', '', '', '',    'bobo1_1.5', '', '', '', '',          null, null, null, 'BoBo''s food? Is your name BoBo?', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%SURPRISED%'),
(8, 'bobo1_1.5', 'ask',    3, false,                 'Don''t worry. I am not here to take your food.', 'Eww... Your food doesn''t look tasty to me anyway.', 'Isn''t that the rare golden nut?? Give me that now!', '', '',    'bobo1_2.0', 'bobo1_3.0', 'bobo1_4.0', '', '',          null, null, null, 'BoBo has been starving for 3 days! Please! Don''t take my nut!', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_2.0', 'choice', 0, false,              '', '', '', '', '',    'bobo1_2.1', '', '', '', '',          null, null, null, 'Oh, okay. (BoBo says relieved, starts to eat his nut)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_2.1', 'choice', 0, false,              '', '', '', '', '',    'bobo1_2.2', '', '', '', '',          null, null, null, 'Actually, I have some delicious food for you to try as well!', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%CONFIDENT%'),
(8, 'bobo1_2.2', 'choice', 0, false,              '', '', '', '', '',    'bobo1_2.3', '', '', '', '',          null, null, null, '(BoBo cocks up his ear) Mmm? You do? What is it?', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_2.3', 'choice', 0, false,              '', '', '', '', '',    'bobo1_2.4', '', '', '', '',          null, null, null, '(%PET_NAME% offers small dried jerky) Go ahead. Give it a try!', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%HAPPY%'),
(8, 'bobo1_2.4', 'choice', 0, false,              '', '', '', '', '',    'bobo1_2.5', '', '', '', '',          null, null, null, 'Uhm.. Okay? (Bobo says taking the jerky and bite out of it)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_2.5', 'choice', 0, false,              '', '', '', '', '',    'bobo1_2.6', '', '', '', '',          null, null, null, 'Do you like it?', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%HAPPY%'),
(8, 'bobo1_2.6', 'ask',    3, false,              'It contains Griffin Fat...', 'It has mouse meat!', 'That jerky is made from trolls!', '', '',    'bobo1_5.0', 'bobo1_6.0', 'bobo1_7.0', '', '',          null, null, null, 'This is so good! What''s in this?...', 'img/global-quest/quest-bobo.webp', '', ''),


(8, 'bobo1_3.0', 'choice', 0, false,              '', '', '', '', '',    'bobo1_3.1', '', '', '', '',          null, null, null, 'Oh?... What food do you eat?', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_3.1', 'choice', 0, false,              '', '', '', '', '',    'bobo1_3.2', '', '', '', '',          null, null, null, 'I eat magical berries. It is the yummiest food around here.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%CONFIDENT%'),
(8, 'bobo1_3.2', 'choice', 0, false,              '', '', '', '', '',    'bobo1_3.3', '', '', '', '',          null, null, null, 'Can.. Can I have some?', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_3.3', 'choice', 0, false,              '', '', '', '', '',    'bobo1_3.4', '', '', '', '',          null, null, null, 'Sure you can! (%PET_NAME% gives magical berries to mouse)', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%HAPPY%'),
(8, 'bobo1_3.4', 'choice', 0, false,              '', '', '', '', '',    'bobo1_3.5', '', '', '', '',          null, null, null, 'Bobo thanks you! (Bobo starts to eat magical berries)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_3.5', 'choice', 0, false,              '', '', '', '', '',    'bobo1_3.6', '', '', '', '',          null, null, null, 'Is that all you will say?', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%SICK%'),
(8, 'bobo1_3.6', 'ask',    3, false,              'You must pay for the magical berries you just ate!', 'You are not showing enough appreciation.', 'Fair enough... Just eat them fast as they get spoiled quickly.', '', '',    'bobo1_8.0', 'bobo1_9.0', 'bobo1_8.10', '', '',          null, null, null, 'Ye... Yes, is there a problem?...', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_4.0', 'choice', 0, false,              '', '', '', '', '',    'bobo1_4.1', '', '', '', '',          null, null, null, 'What a monster! You would take food from a poor starving mouse?', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_4.1', 'choice', 0, false,              '', '', '', '', '',    'bobo1_4.2', '', '', '', '',          null, null, null, 'What? It really hurts being called a monster.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%SICK%'),
(8, 'bobo1_4.2', 'choice', 0, false,              '', '', '', '', '',    'bobo1_4.3', '', '', '', '',          null, null, null, '(Cries) I didn''t mean to hurt your feelings, but I can''t give you my nut!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_4.3', 'choice', 0, false,              '', '', '', '', '',    'bobo1_4.4', '', '', '', '',          null, null, null, 'Nevermind, I don''t eat nuts. I am allergic to it.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%SICK%'),
(8, 'bobo1_4.4', 'choice', 0, false,              '', '', '', '', '',    'bobo1_4.5', '', '', '', '',          null, null, null, 'Thank goodness. I was getting worried you would take my nut.', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_4.5', 'choice', 0, false,              '', '', '', '', '',    'bobo1_4.6', '', '', '', '',          null, null, null, '(Smiles) You see, instead, I eat something else.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%HAPPY%'),
(8, 'bobo1_4.6', 'choice', 0, false,              '', '', '', '', '',    'bobo1_4.7', '', '', '', '',          null, null, null, '(Bobo raises his eyebrows) Like what?', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_4.7', 'ask',    3, false,              'Anything that is alive.', 'I eat a mouse like you.', 'I eat magical berries.', '', '',    'bobo1_11.0', 'bobo1_12.0', 'bobo1_13.0', '', '',          null, null, null, '', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_5.0', 'choice', 0, false,              '', '', '', '', '',    'bobo1_5.1', '', '', '', '',          null, null, null, 'That is amazing. I was worried it would be mouse meat!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_5.1', 'choice', 0, false,              '', '', '', '', '',    'bobo1_5.2', '', '', '', '',          null, null, null, 'You don''t eat mouse meat? Who knows it will be good for you.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%TIRED%'),
(8, 'bobo1_5.2', 'choice', 0, false,              '', '', '', '', '',    'bobo1_5.3', '', '', '', '',          null, null, null, '(Bobo shivers at the thought) A mouse would never eat another mouse!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_5.3', 'choice', 0, false,              '', '', '', '', '',    'bobo1_5.4', '', '', '', '',          null, null, null, 'I see...', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%SURPRISED%'),
(8, 'bobo1_5.4', 'choice', 0, false,              '', '', '', '', '',    'bobo1_5.5', '', '', '', '',          null, null, null, 'Thank you for the Griffin Fat. You are so kind to give me this.', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_5.5', 'choice', 0, false,              '', '', '', '', '',    'bobo1_5.6', '', '', '', '',          null, null, null, 'You are welcome. I know that is very rare delicacy for you.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%CONFIDENT%'),
(8, 'bobo1_5.6', 'choice', 0, false,              '', '', '', '', '',    'bobo1_5.7', '', '', '', '',          null, null, null, 'Now I am going to leave. Good luck little mouse!', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%HAPPY%'),
(8, 'bobo1_5.7', 'choice', 0, false,              '', '', '', '', '',    'bobo1_wrapup', '', '', '', '',       'bobo1_cost_5', null, null, '(Bobo swiftly waves at %PET_NAME%.) Bobo wishes you a safe journey!', 'img/global-quest/quest-bobo.webp', '', ''),


(8, 'bobo1_6.0', 'choice', 0, false,              '', '', '', '', '',    'bobo1_6.1', '', '', '', '',          null, null, null, '(Bobo halts eating, mouth agape in shock) Mouse Meat?', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_6.1', 'choice', 0, false,              '', '', '', '', '',    'bobo1_6.2', '', '', '', '',          null, null, null, '(Giggles) Yes! Mouse Meat!', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%EXCITED%'),
(8, 'bobo1_6.2', 'choice', 0, false,              '', '', '', '', '',    'bobo1_6.3', '', '', '', '',          null, null, null, 'Bobo, looking horrified, gazes at you. Did you... kill a mouse?', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_6.3', 'choice', 0, false,              '', '', '', '', '',    'bobo1_6.4', '', '', '', '',          null, null, null, '(Laughs) Of course I killed a mouse for it! What did you expect?', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%EXCITED%'),
(8, 'bobo1_6.4', 'choice', 0, false,              '', '', '', '', '',    'bobo1_6.5', '', '', '', '',          null, null, null, 'Bobo freezes in fear. Ahh! Don''t... Don''t kill me! Please!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_6.5', 'choice', 0, false,              '', '', '', '', '',    'bobo1_6.6', '', '', '', '',          null, null, null, '(Laughs hard) Now you are going to be my next mouse victim!', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%EXCITED%'),
(8, 'bobo1_6.6', 'choice', 0, false,              '', '', '', '', '',    '', '', '', '', '',                   null, 'bobo1_test_6.6', null, '(Bobo sees %PET_NAME% dashing toward him and hastily tries to run away)', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_6.6_success_1', 'choice', 0, false,    '', '', '', '', '',    'bobo1_6.6_success_2', '', '', '', '',          null, null, null, '(After endless chasing, %PET_NAME% finally managed to catch Bobo)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_6.6_success_2', 'choice', 0, false,    '', '', '', '', '',    'bobo1_6.6_success_3', '', '', '', '',          null, null, null, '(Bobo cries and screams) Ahhh! Please don''t kill me!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_6.6_success_3', 'choice', 0, false,    '', '', '', '', '',    'bobo1_6.6_success_4', '', '', '', '',          null, null, null, '(Laughs) I was just kidding... I''m not going to hurt you. Go ahead, finish your food. I must be on my way.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%EXCITED%'),
(8, 'bobo1_6.6_success_4', 'choice', 0, false,    '', '', '', '', '',    'bobo1_6.6_success_5', '', '', '', '',          null, null, null, '(Bobo is confused but nods quietly)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_6.6_success_5', 'choice', 0, false,    '', '', '', '', '',    'bobo1_wrapup', '', '', '', '',                 'bobo1_cost_6_success', null, null, '(%PET_NAME% playfully dashes into the bushes, magically disappearing from Bobo''s view)', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_6.6_fail_1', 'choice', 0, false,        '', '', '', '', '',    'bobo1_wrapup', '', '', '', '',            'bobo1_cost_6_fail', null, null, '(After an endless chase, Bobo managed to elude you, disappearing into the bushes)', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_7.0', 'choice', 0, false,              '', '', '', '', '',    'bobo1_7.1', '', '', '', '',          null, null, null, '(Bobo looks amazed) Troll? The mythical big creature Troll?', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_7.1', 'choice', 0, false,              '', '', '', '', '',    'bobo1_7.2', '', '', '', '',          null, null, null, 'It has many magical nutrients to make you strong.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%CONFIDENT%'),
(8, 'bobo1_7.2', 'choice', 0, false,              '', '', '', '', '',    'bobo1_7.3', '', '', '', '',          null, null, null, '(Bobo seems surprised) I didn''t know Troll meat was that magical..', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_7.3', 'choice', 0, false,              '', '', '', '', '',    'bobo1_7.4', '', '', '', '',          null, null, null, 'Of course they are. Now, will you please eat that already?', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%SICK%'),
(8, 'bobo1_7.4', 'choice', 0, false,              '', '', '', '', '',    'bobo1_7.5', '', '', '', '',          null, null, null, 'Oh... Okay... Thank you for the meat... (Bobo continues to eat.)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_7.5', 'choice', 0, false,              '', '', '', '', '',    'bobo1_7.6', '', '', '', '',          null, null, null, 'Oof... I don''t feel too good now... (BoBo says sounding sick)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_7.6', 'choice', 0, false,              '', '', '', '', '',    '', '', '', '', '',                   null, 'bobo1_test_7.6', null, '(Gasps) Let me help you! (Starts conjuring healing magic on Bobo)', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%SURPRISED%'),

(8, 'bobo1_7.6_success_1', 'choice', 0, false,       '', '', '', '', '',    'bobo1_7.6_success_2', '', '', '', '',          null, null, null, '(It appears that the magical healing aura %PET_NAME% was conjuring on Bobo has worked its charm)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_7.6_success_2', 'choice', 0, false,       '', '', '', '', '',    'bobo1_7.6_success_3', '', '', '', '',          null, null, null, 'Mmm mmm... I feel better now. Thank you!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_7.6_success_3', 'choice', 0, false,       '', '', '', '', '',    'bobo1_7.6_success_4', '', '', '', '',          null, null, null, '(%PET_NAME% pets Bobo happily) Yay!', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%EXCITED%'),
(8, 'bobo1_7.6_success_4', 'choice', 0, false,       '', '', '', '', '',    'bobo1_7.6_success_5', '', '', '', '',          null, null, null, 'For the rest of the afternoon, %PET_NAME% continued to look after Bobo. When it was late, %PET_NAME% bid farewell.', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_7.6_success_5', 'choice', 0, false,       '', '', '', '', '',    'bobo1_wrapup', '', '', '', '',          'bobo1_cost_7_success', null, null, 'Bobo thanks you! Have a wonderful trip!', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_7.6_fail_1', 'choice', 0, false,       '', '', '', '', '',    'bobo1_7.6_fail_2', '', '', '', '',          null, null, null, '(It appears that the magical healing aura %PET_NAME% was conjuring on Bobo didn''t work well)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_7.6_fail_2', 'choice', 0, false,       '', '', '', '', '',    'bobo1_7.6_fail_3', '', '', '', '',          null, null, null, '(Bobo loses consciousness)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_7.6_fail_3', 'choice', 0, false,       '', '', '', '', '',    'bobo1_7.6_fail_4', '', '', '', '',          null, null, null, 'Ar... Are you okay?', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%SURPRISED%'),
(8, 'bobo1_7.6_fail_4', 'choice', 0, false,       '', '', '', '', '',    'bobo1_wrapup', '', '', '', '',              'bobo1_cost_7_fail', null, null, '(%PET_NAME% being bewildered by the incident, quickly flees from the scene in frustration)', 'img/global-quest/quest-bobo.webp', '', ''),


(8, 'bobo1_8.0', 'choice', 0, false,       '', '', '', '', '',    'bobo1_8.1', '', '', '', '',          null, null, null, 'Wha.. What? You didn''t give it to me out of kindness?', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_8.1', 'choice', 0, false,       '', '', '', '', '',    'bobo1_8.2', '', '', '', '',          null, null, null, 'Do I look like I am someone that would give free food around here?', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%SICK%'),
(8, 'bobo1_8.2', 'choice', 0, false,       '', '', '', '', '',    'bobo1_8.3', '', '', '', '',          null, null, null, 'Uhm... No.', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_8.3', 'choice', 0, false,       '', '', '', '', '',    'bobo1_8.4', '', '', '', '',          null, null, null, 'You got that right. I am not kind. I am here to trade.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%SICK%'),
(8, 'bobo1_8.4', 'choice', 0, false,       '', '', '', '', '',    'bobo1_8.5', '', '', '', '',          null, null, null, 'How much do I pay you? (Bobo says in a worried voice)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_8.5', 'choice', 0, false,       '', '', '', '', '',    'bobo1_8.6', '', '', '', '',          null, null, null, 'Give me that golden nut you have.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%EXCITED%'),
(8, 'bobo1_8.6', 'choice', 0, false,       '', '', '', '', '',    'bobo1_8.7', '', '', '', '',          null, null, null, '(Bobo sulks his mouth) Ok here....', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_8.7', 'choice', 0, false,       '', '', '', '', '',    'bobo1_8.8', '', '', '', '',          null, null, null, '(%PET_NAME% takes the golden nut from Bobo) Good deal!', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%EXCITED%'),
(8, 'bobo1_8.8', 'choice', 0, false,       '', '', '', '', '',    'bobo1_8.9', '', '', '', '',          null, null, null, '(Bobo sulks his mouth) .....', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_8.9', 'choice', 0, false,       '', '', '', '', '',    'bobo1_8.10', '', '', '', '',         null, null, null, 'Now I must go! Thanks for the nut!', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%EXCITED%'),
(8, 'bobo1_8.10', 'choice', 0, false,      '', '', '', '', '',    'bobo1_wrapup', '', '', '', '',       'bobo1_cost_8_success', null, null, '(%PET_NAME% quickly disappears into bushes with giggles)', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_9.0', 'choice', 0, false,       '', '', '', '', '',    'bobo1_9.1', '', '', '', '',          null, null, null, 'I... I am sorry. I mean... (Bobo gulps) Thank you for the berries.', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_9.1', 'choice', 0, false,       '', '', '', '', '',    'bobo1_9.2', '', '', '', '',          null, null, null, 'I am really grateful that you gave me the yummy berries.', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_9.2', 'choice', 0, false,       '', '', '', '', '',    'bobo1_9.3', '', '', '', '',          null, null, null, 'I really really thank you for the berries. I sincerely thank you for the berries.', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_9.3', 'choice', 0, false,       '', '', '', '', '',    'bobo1_9.4', '', '', '', '',          null, null, null, 'How can I ever thank...', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_9.4', 'choice', 0, false,       '', '', '', '', '',    'bobo1_9.5', '', '', '', '',          null, null, null, 'Stop! That''s enough!', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%NERVOUS%'),
(8, 'bobo1_9.5', 'choice', 0, false,       '', '', '', '', '',    'bobo1_9.6', '', '', '', '',          null, null, null, '(%PET_NAME% gets annoyed with Bobo and hides behind bushes.)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_9.6', 'choice', 0, false,       '', '', '', '', '',    'bobo1_9.7', '', '', '', '',          null, null, null, '(Bobo gulps) Thank... Huh? Where did you go?', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_9.7', 'choice', 0, false,        '', '', '', '', '',   'bobo1_wrapup', '', '', '', '',       'bobo1_cost_9_success', null, null, '(%PET_NAME% hastily dashes into the bushes, quickly disappearing from Bobo''s view)', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_10.0', 'choice', 0, false,       '', '', '', '', '',    'bobo1_10.1', '', '', '', '',          null, null, null, '(Bobo nods and quickly finishes eating them, then looks at %PET_NAME%)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_10.1', 'choice', 0, false,       '', '', '', '', '',    'bobo1_10.2', '', '', '', '',          null, null, null, 'Hmm? What is it? Why are you looking at me like that?', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%SURPRISED%'),
(8, 'bobo1_10.2', 'choice', 0, false,       '', '', '', '', '',    'bobo1_10.3', '', '', '', '',          null, null, null, 'Ca.. Can I have some more?... The magical berries were so delicious.', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_10.3', 'choice', 0, false,       '', '', '', '', '',    'bobo1_10.4', '', '', '', '',          null, null, null, 'I can''t give you more.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%NERVOUS%'),
(8, 'bobo1_10.4', 'choice', 0, false,       '', '', '', '', '',    'bobo1_10.5', '', '', '', '',          null, null, null, '(Bobo cries) Bobo will never be able to taste the berry again.', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_10.5', 'choice', 0, false,       '', '', '', '', '',    'bobo1_10.6', '', '', '', '',          null, null, null, '(%PET_NAME% sighs and throws the last leftover berries to Bobo)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_10.6', 'choice', 0, false,       '', '', '', '', '',    'bobo1_10.7', '', '', '', '',          null, null, null, '(Bobo quickly catches the berry and eats it) Yay!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_10.7', 'choice', 0, false,       '', '', '', '', '',    'bobo1_wrapup', '', '', '', '',          'bobo1_cost_10_success', null, null, '(%PET_NAME% swiftly waves at Bobo and quickly dashes into the bushes for the next adventure)', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_11.0', 'choice', 0, false,       '', '', '', '', '',    'bobo1_11.1', '', '', '', '',          null, null, null, 'What? You eat things that have feelings? That is cruel!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_11.1', 'choice', 0, false,       '', '', '', '', '',    'bobo1_11.2', '', '', '', '',          null, null, null, 'How dare you disrespect my joyful eating preference.', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_11.2', 'choice', 0, false,       '', '', '', '', '',    'bobo1_11.3', '', '', '', '',          null, null, null, '(Bobo speaks in a small voice) It... it is not a preference... It is being cruel.', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_11.3', 'choice', 0, false,       '', '', '', '', '',    'bobo1_11.4', '', '', '', '',          null, null, null, 'Yeah, right. (Pet suddenly snatches the golden nut from Bobo while he is off guard)', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%EXCITED%'),
(8, 'bobo1_11.4', 'choice', 0, false,       '', '', '', '', '',    'bobo1_11.5', '', '', '', '',          null, null, null, 'Wait! That is my nut!! Give it back!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_11.5', 'choice', 0, false,       '', '', '', '', '',    'bobo1_11.6', '', '', '', '',          null, null, null, 'Hahaha, catch me if you can, and I will give it back to you!', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%EXCITED%'),
(8, 'bobo1_11.6', 'choice', 0, false,       '', '', '', '', '',    '', '', '', '', '',                    null, 'bobo1_test_11.6', null, 'Get back here!! (Bobo chases after %PET_NAME%)', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_11.6_success_1', 'choice', 0, false,       '', '', '', '', '',    'bobo1_wrapup', '', '', '', '',              'bobo1_cost_11_success', null, null, '(%PET_NAME% manages to run away from Bobo, with his nuts stolen from him)', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_11.6_fail_1', 'choice', 0, false,        '', '', '', '', '',    'bobo1_11.6_fail_2', '', '', '', '',           null, null, null, '(Bobo manages to catch up to %PET_NAME% and takes his golden nut back)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_11.6_fail_2', 'choice', 0, false,        '', '', '', '', '',    'bobo1_11.6_fail_3', '', '', '', '',           null, null, null, 'I was just joking.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%NERVOUS%'),
(8, 'bobo1_11.6_fail_3', 'choice', 0, false,        '', '', '', '', '',    'bobo1_11.6_fail_4', '', '', '', '',           null, null, null, '(Bobo snorts) Thanks for the joke, hmph!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_11.6_fail_4', 'choice', 0, false,        '', '', '', '', '',    'bobo1_wrapup', '', '', '', '',                'bobo1_cost_11_fail', null, null, '(Bobo walks back into the bush and disappears from %PET_NAME%)', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_12.0', 'choice', 0, false,       '', '', '', '', '',    'bobo1_12.1', '', '', '', '',          null, null, null, '(Bobo was speechless. He started to shiver) You eat mouse??', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_12.1', 'choice', 0, false,       '', '', '', '', '',    'bobo1_12.2', '', '', '', '',          null, null, null, 'I have an illness, and the only cure for it is to eat a mouse.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%TIRED%'),
(8, 'bobo1_12.2', 'choice', 0, false,       '', '', '', '', '',    'bobo1_12.3', '', '', '', '',          null, null, null, 'You can''t just eat me because you are sick!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_12.3', 'choice', 0, false,       '', '', '', '', '',    'bobo1_12.4', '', '', '', '',          null, null, null, '(Laughs evilly) I will have to hunt you and take you as my next meal!', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%EXCITED%'),
(8, 'bobo1_12.4', 'choice', 0, false,       '', '', '', '', '',    'bobo1_12.5', '', '', '', '',          null, null, null, '(Bobo frantically shouts) No! Get away from me! I hate you!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_12.5', 'choice', 0, false,       '', '', '', '', '',    'bobo1_12.6', '', '', '', '',          null, null, null, '(%PET_NAME% quickly dashes toward Bobo) Time for the hunting spree!', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%EXCITED%'),
(8, 'bobo1_12.6', 'choice', 0, false,       '', '', '', '', '',    '', '', '', '', '',                    null, 'bobo1_test_12.6', null, 'Ahhhh! (Bobo readies to block your pet''s attack)', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_12.6_success_1', 'choice', 0, false,        '', '', '', '', '',    'bobo1_12.6_success_2', '', '', '', '',                    null, null, null, '(After a fierce battle with Bobo, %PET_NAME% emerges victorious)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_12.6_success_2', 'choice', 0, false,        '', '', '', '', '',    'bobo1_12.6_success_3', '', '', '', '',                    null, null, null, '(Bobo cries) To end my life in this sad situation...', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_12.6_success_3', 'choice', 0, false,        '', '', '', '', '',    'bobo1_12.6_success_4', '', '', '', '',                    null, null, null, '(%PET_NAME%) I am not eating you. Just run away while you can.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%TIRED%'),
(8, 'bobo1_12.6_success_4', 'choice', 0, false,        '', '', '', '', '',    'bobo1_wrapup', '', '', '', '',                    'bobo1_cost_12_success', null, null, '(Bobo hastily runs away without even looking back)', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_12.6_fail_1', 'choice', 0, false,        '', '', '', '', '',    'bobo1_11.6_fail_2', '', '', '', '',           null, null, null, '(After a fierce battle with Bobo, %PET_NAME% loses the battle)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_12.6_fail_2', 'choice', 0, false,        '', '', '', '', '',    'bobo1_11.6_fail_3', '', '', '', '',           null, null, null, '(Bobo lets out awe-inspiring chuckles) It was not even worthy.', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_12.6_fail_3', 'choice', 0, false,         '', '', '', '', '',   'bobo1_wrapup', '', '', '', '',                null, null, null, '(Bobo disappears into the bushes, leaving %PET_NAME% defeated on the ground)', 'img/global-quest/quest-bobo.webp', '', ''),


(8, 'bobo1_13.0', 'choice', 0, false,       '', '', '', '', '',    'bobo1_13.1', '', '', '', '',          null, null, null, 'Magical berries? What does it taste like?', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_13.1', 'choice', 0, false,       '', '', '', '', '',    'bobo1_13.2', '', '', '', '',          null, null, null, 'Would you like to try magical berries? You can have some!', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%HAPPY%'),
(8, 'bobo1_13.2', 'choice', 0, false,       '', '', '', '', '',    'bobo1_13.3', '', '', '', '',          null, null, null, 'Yes please! (Bobo says happily)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_13.3', 'choice', 0, false,       '', '', '', '', '',    'bobo1_13.4', '', '', '', '',          null, null, null, '(%PET_NAME% takes some magical berries from pouch and hands over to Bobo)', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_13.4', 'choice', 0, false,       '', '', '', '', '',    'bobo1_13.5', '', '', '', '',          null, null, null, '(Bobo eats the magical berry) Thank you for giving me this yummy food!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_13.5', 'choice', 0, false,       '', '', '', '', '',    'bobo1_13.6', '', '', '', '',          null, null, null, 'I am glad you like it. Now I must get going to continue my journey.', 'img/global-quest/quest-bobo.webp', '%PET_FACE%', '%HAPPY%'),
(8, 'bobo1_13.6', 'choice', 0, false,       '', '', '', '', '',    'bobo1_13.7', '', '', '', '',          null, null, null, 'Good luck with your journey!', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_13.7', 'choice', 0, false,       '', '', '', '', '',    'bobo1_wrapup', '', '', '', '',        'bobo1_cost_13_success', null, null, '(Bobo swiftly waves at %PET_NAME%)', 'img/global-quest/quest-bobo.webp', '', ''),

(8, 'bobo1_wrapup', 'choice', 1, false,        '', '', '', '', '',    'bobo1_end', '', '', '', '',       null, null, null, '%FATIGUE_MSG% Your pet''s other stats have changed as follows:<br/>%STAT_COST% %FOOD_STAT_COST%', 'img/global-quest/quest-bobo.webp', '', ''),
(8, 'bobo1_end', 'choice', 0, true,        '', '', '', '', '',    '', '', '', '', '',                    null, null, null, '', 'img/global-quest/quest-bobo.webp', '', '')
;

-- -------------------------------------
-- Meet Bobo the Mouse - Tests
insert into ps_stat_test
(quest_id, action,   win_action,         lose_action,               constitution, strength, agility, charm, confidence, empathy, intelligence, wisdom, sorcery, loyalty, spirituality, karma)
values
-- BoBo the mouse                                                    25,           20,       25,        40,    25,       35,     15,           20,   10,      30,     40,           25
(8, 'bobo1_test_6.6',  'bobo1_6.6_success_1',  'bobo1_6.6_fail_1',   25,            0,       25,         0,     0,        0,      0,            0,    0,       0,      0,            0),
(8, 'bobo1_test_7.6',  'bobo1_7.6_success_1',  'bobo1_7.6_fail_1',    0,            0,        0,         0,     0,        0,     15,           20,    0,       0,      0,            0),
(8, 'bobo1_test_11.6', 'bobo1_11.6_success_1', 'bobo1_11.6_fail_1',   0,            0,        0,         0,    25,        0,      0,            0,    0,       0,      0,            0),
(8, 'bobo1_test_12.6', 'bobo1_12.6_success_1', 'bobo1_12.6_fail_1',   0,           20,       25,         0,     0,        0,      0,            0,    0,       0,      0,            0)
;

-- -------------------------------------------
-- BoBo the Mouse  - Costs
insert into ps_stat_cost
(quest_id, action,          constitution, strength, agility, charm, confidence, empathy, intelligence, wisdom, sorcery, loyalty, spirituality, karma, fatigue, food)
values
(8, 'bobo1_initial_cost',       0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,    0,      -50),
(8, 'bobo1_cost_5',             0,            0,        0,       0,     1,          0,       0,             0,     0,       0,        0,            1,   12,        0),
(8, 'bobo1_cost_6_success',     0,            0,        1,       0,     0,          0,       0,             0,     0,       1,        0,            0,   12,        0),
(8, 'bobo1_cost_6_fail',        1,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,   12,        0),
(8, 'bobo1_cost_7_success',     0,            0,        0,       0,     0,          0,       1,             0,     0,       0,        0,            1,   14,        0),
(8, 'bobo1_cost_7_fail',        0,            0,        0,       0,     0,          0,       1,             0,     0,       0,        0,            0,   14,        0),
(8, 'bobo1_cost_8_success',     0,            0,        0,       0,     1,          0,       0,             0,     0,       1,        0,            0,   14,        0),
(8, 'bobo1_cost_9_success',     0,            0,        0,       0,     0,          0,       1,             0,     0,       1,        0,            0,   12,        0),
(8, 'bobo1_cost_10_success',    0,            0,        0,       0,     0,          1,       0,             0,     0,       0,        0,            1,   14,        0),
(8, 'bobo1_cost_11_success',    0,            0,        1,       0,     0,          0,       0,             0,     0,       0,        0,            0,   14,       30),
(8, 'bobo1_cost_11_fail',       1,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,   14,        0),
(8, 'bobo1_cost_12_success',    0,            0,        1,       0,     0,          0,       0,             0,     0,       0,        0,            0,   14,        0),
(8, 'bobo1_cost_13_success',    0,            0,        0,       0,     1,          0,       0,             0,     0,       0,        0,            1,   14,        0)
;



-- ----------------------------------------------------------------------------------------------------------------
-- Meeting Pupu the Mushroom
-- ----------------------------------------------------------------------------------------------------------------
insert into ps_quest_choice
(quest_id, action, type, choice_count, quest_done, choice_1, choice_2, choice_3, choice_4, choice_5, action_1, action_2, action_3, action_4, action_5, action_cost, action_test, action_cmd, text, texture, face_img, emote_img)
values
-- Pupu the mouse (code "pupu1")
(9, 'pupu1_pre1', 'choice', 0, false,              '', '', '', '', '',    'pupu1_pre2', '', '', '', '',        null, null, null, 'Filled with excitement, %PET_NAME% gathered their belongings and prepared for a questing adventure. &lt;Click the Text to Continue&gt;', '%RANDOM_HABITAT_TEXTURE%', '', ''),
(9, 'pupu1_pre2', 'choice', 0, false,              '', '', '', '', '',    'pupu1_pre3', '', '', '', '',        null, null, null, '[Visiting %HABITAT_NAME% Habitat] <br\> Amidst the swirling mists of the ethereal realm of %REGION_NAME%, my spectral magical companion, floated gracefully by my side.', '%RANDOM_HABITAT_TEXTURE%', '', ''),
(9, 'pupu1_pre3', 'choice', 0, false,              '', '', '', '', '',    'pupu1_pre4', '', '', '', '',        null, null, null, 'With its otherworldly presence and my boundless curiosity, we embarked on a journey through the veiled mysteries of the spirit world.', '%HABITAT_TEXTURE%', '', ''),
(9, 'pupu1_pre4', 'choice', 0, false,              '', '', '', '', '',    'pupu1_1.0', '', '', '', '',         null, null, null, 'What daring exploits awaited us?', '%HABITAT_TEXTURE%', '', ''),

(9, 'pupu1_1.0', 'choice', 0, false,              '', '', '', '', '',    'pupu1_1.1', '', '', '', '',          'pupu1_initial_cost', null, null, '(%PET_NAME% joyfully explores the surroundings and encounters a seemingly feisty mushroom-like creature.)', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_1.1', 'choice', 0, false,              '', '', '', '', '',    'pupu1_1.2', '', '', '', '',          null, null, null, 'My name is PuPu! I am a guardian of this Sunset Mushroom Forest! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_1.2', 'choice', 0, false,              '', '', '', '', '',    'pupu1_1.3', '', '', '', '',          null, null, null, 'I see... Let me guess. You were going to ask me who I am and why I am here?', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%TIRED%'),
(9, 'pupu1_1.3', 'choice', 0, false,              '', '', '', '', '',    'pupu1_1.4', '', '', '', '',          null, null, null, 'That is right! PuPu! Who are you and why are you here? PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_1.4', 'choice', 0, false,              '', '', '', '', '',    'pupu1_1.5', '', '', '', '',          null, null, null, 'Could you please stop saying PuPu? It makes me think of the word Poop...', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SICK%'),
(9, 'pupu1_1.5', 'ask', 3, false,                 'I was just... taking a stroll.', 'I am here to search for a rare Sunset Mushroom.', 'I came here to kidnap you!', '', '',    'pupu1_2.0', 'pupu1_3.0', 'pupu1_4.0', '', '',          null, null, null, '(PuPu speaks angrily) How dare you? Just answer my question! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_2.0', 'choice', 0, false,              '', '', '', '', '',    'pupu1_2.1', '', '', '', '',          null, null, null, 'You need to leave! You''re wandering into our territory! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_2.1', 'choice', 0, false,              '', '', '', '', '',    'pupu1_2.2', '', '', '', '',          null, null, null, 'Who said this is your territory?', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SICK%'),
(9, 'pupu1_2.2', 'choice', 0, false,              '', '', '', '', '',    'pupu1_2.3', '', '', '', '',          null, null, null, 'It is our territory!!! My pack has been hanging out here for ages! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_2.3', 'choice', 0, false,              '', '', '', '', '',    'pupu1_2.4', '', '', '', '',          null, null, null, 'That doesn''t convince me. Anyone can claim they''ve been chilling here for ages.', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SICK%'),
(9, 'pupu1_2.4', 'choice', 0, false,              '', '', '', '', '',    'pupu1_2.5', '', '', '', '',          null, null, null, '(PuPu lets out a growl and starts to dance in a quirky way) PuPu! PuPu! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_2.5', 'choice', 0, false,              '', '', '', '', '',    'pupu1_2.6', '', '', '', '',          null, null, null, '(%PET_NAME% is a bit surprised at the noise PuPu was making and steps back a bit)', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SURPRISED%'),
(9, 'pupu1_2.6', 'ask',    3, false,              'You dare to threaten me?', 'Wait, I''ve got an interesting offer for you.', 'So, you want me to go away?', '', '',    'pupu1_5.0', 'pupu1_6.0', 'pupu1_7.0', '', '',          null, null, null, 'You''ll be sorry if you try to sneak in here! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),


(9, 'pupu1_3.0', 'choice', 0, false,              '', '', '', '', '',    'pupu1_3.1', '', '', '', '',          null, null, null, 'I have never heard of such a mushroom in this forest! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_3.1', 'choice', 0, false,              '', '', '', '', '',    'pupu1_3.2', '', '', '', '',          null, null, null, 'But isn''t this place called Sunset Mushroom Forest? There has to be the Sunset Mushroom!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SICK%'),
(9, 'pupu1_3.2', 'choice', 0, false,              '', '', '', '', '',    'pupu1_3.3', '', '', '', '',          null, null, null, 'PuPu thinks you got it wrong. This forest doesn''t have mushrooms. PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_3.3', 'choice', 0, false,              '', '', '', '', '',    'pupu1_3.4', '', '', '', '',          null, null, null, '(%PET_NAME% rolls eyes) That is so lame!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SICK%'),
(9, 'pupu1_3.4', 'choice', 0, false,              '', '', '', '', '',    'pupu1_3.5', '', '', '', '',          null, null, null, 'PuPu thinks you are lame! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_3.5', 'choice', 0, false,              '', '', '', '', '',    'pupu1_3.6', '', '', '', '',          null, null, null, 'Well? Too bad because I got a magical item I was going to trade for the Sunset Mushroom!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SURPRISED%'),
(9, 'pupu1_3.6', 'ask',    3, false,              'A Tickle Feather.', 'Magical Berries.', 'Mirror of Past-life.', '', '',    'pupu1_8.0', 'pupu1_9.0', 'pupu1_8.10', '', '',          null, null, null, '(PuPu raises his eyebrows) PuPu? What is it, PuPu?', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_4.0', 'choice', 0, false,              '', '', '', '', '',    'pupu1_4.1', '', '', '', '',          null, null, null, '(PuPu gasps) What? No, you can''t just kidnap me!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_4.1', 'choice', 0, false,              '', '', '', '', '',    'pupu1_4.2', '', '', '', '',          null, null, null, 'Why not?', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SURPRISED%'),
(9, 'pupu1_4.2', 'choice', 0, false,              '', '', '', '', '',    'pupu1_4.3', '', '', '', '',          null, null, null, 'Because it is against the rule of the Sunset Mushroom Forest!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_4.3', 'choice', 0, false,              '', '', '', '', '',    'pupu1_4.4', '', '', '', '',          null, null, null, 'Oh dear! Really? Am I in trouble for trying to kidnap you?', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SURPRISED%'),
(9, 'pupu1_4.4', 'choice', 0, false,              '', '', '', '', '',    'pupu1_4.5', '', '', '', '',          null, null, null, 'Yes PuPu! You are in trouble! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_4.5', 'choice', 0, false,              '', '', '', '', '',    'pupu1_4.6', '', '', '', '',          null, null, null, 'Giggles! Like hell I care! Come here! Let me kidnap you!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%EXCITED%'),
(9, 'pupu1_4.6', 'choice', 0, false,              '', '', '', '', '',    'pupu1_4.7', '', '', '', '',          null, null, null, 'PuPu! Why? Why do you want to kidnap me, PuPu? WHY!!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_4.7', 'ask',    3, false,              'Because you are so cute!', 'Because you are ugly...', 'Hmm.. I am not sure why..', '', '',    'pupu1_11.0', 'pupu1_12.0', 'pupu1_13.0', '', '',          null, null, null, '', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_5.0', 'choice', 0, false,              '', '', '', '', '',    'pupu1_5.1', '', '', '', '',          null, null, null, '(PuPu dashes to %PET_NAME% with a determined stare) You shall not pass!! PuPu!!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_5.1', 'choice', 0, false,              '', '', '', '', '',    'pupu1_5.2', '', '', '', '',          null, null, null, '(With much luck, %PET_NAME% skillfully dodges the unexpected dash) What''s your deal?', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SICK%'),
(9, 'pupu1_5.2', 'choice', 0, false,              '', '', '', '', '',    'pupu1_5.3', '', '', '', '',          null, null, null, '(PuPu suddenly trips while rushing towards %PET_NAME%) PUUUU!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_5.3', 'choice', 0, false,              '', '', '', '', '',    'pupu1_5.4', '', '', '', '',          null, null, null, 'Groundbreaking sound effects you got there, Captain Poop.', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SICK%'),
(9, 'pupu1_5.4', 'choice', 0, false,              '', '', '', '', '',    'pupu1_5.5', '', '', '', '',          null, null, null, '(PuPu struggles to get back up) You....', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_5.5', 'choice', 0, false,              '', '', '', '', '',    'pupu1_5.6', '', '', '', '',          null, null, null, 'PuPu challenges you to a battle! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_5.6', 'choice', 0, false,              '', '', '', '', '',    '', '', '', '', '',          		   null, 'pupu1_test_5.6', null, '(%PET_NAME% snorts) That battle cry was impressive... Not!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SICK%'),

(9, 'pupu1_5.6_success_1', 'choice', 0, false,    '', '', '', '', '',    'pupu1_5.6_success_2', '', '', '', '',          null, null, null, '(PuPu tries to land a hit on %PET_NAME% but stumbles with his clumsy footsteps) PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_5.6_success_2', 'choice', 0, false,    '', '', '', '', '',    'pupu1_5.6_success_3', '', '', '', '',          null, null, null, '(%PET_NAME% chuckles) With those short legs of yours, I knew you''re not that impressive.', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%TIRED%'),
(9, 'pupu1_5.6_success_3', 'choice', 0, false,    '', '', '', '', '',    'pupu1_wrapup', '', '', '', '',                 'pupu1_cost_5_success', null, null, '(PuPu, embarrassed, quickly scurries back to the forest) PuPu will come back later!', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_5.6_fail_1', 'choice', 0, false,        '', '', '', '', '',    'pupu1_5.6_fail_2', '', '', '', '',             null, null, null, '(PuPu successfully lands a hit on %PET_NAME% causing a playful impact) PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_5.6_fail_2', 'choice', 0, false,        '', '', '', '', '',    'pupu1_5.6_fail_3', '', '', '', '',             null, null, null, '(%PET_NAME% sighs and struggles to stand up) Ugh...', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%NERVOUS%'),
(9, 'pupu1_5.6_fail_3', 'choice', 0, false,        '', '', '', '', '',    'pupu1_5.6_fail_4', '', '', '', '',             null, null, null, 'PuPu has mighty power! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_5.6_fail_4', 'choice', 0, false,        '', '', '', '', '',    'pupu1_wrapup', '', '', '', '',                 'pupu1_cost_5_fail', null, null, '(%PET_NAME% pouts and quickly steps back from PuPu, escaping the scene)', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_6.0', 'choice', 0, false,              '', '', '', '', '',    'pupu1_6.1', '', '', '', '',          null, null, null, 'What.. what offer? PuPu?', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_6.1', 'choice', 0, false,              '', '', '', '', '',    'pupu1_6.2', '', '', '', '',          null, null, null, 'You don''t really get anything good by tangling with me, right?', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SICK%'),
(9, 'pupu1_6.2', 'choice', 0, false,              '', '', '', '', '',    'pupu1_6.3', '', '', '', '',          null, null, null, 'I guess… yes? PuPu?', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_6.3', 'choice', 0, false,              '', '', '', '', '',    'pupu1_6.4', '', '', '', '',          null, null, null, 'How about I tell you what you could get if you let me enter the forest?', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%CONFIDENT%'),
(9, 'pupu1_6.4', 'choice', 0, false,              '', '', '', '', '',    'pupu1_6.5', '', '', '', '',          null, null, null, 'What will I get? PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_6.5', 'choice', 0, false,              '', '', '', '', '',    'pupu1_6.6', '', '', '', '',          null, null, null, '(%PET_NAME% takes out magical berries for PuPu) Delicious exotic magical treat!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%CONFIDENT%'),
(9, 'pupu1_6.6', 'choice', 0, false,              '', '', '', '', '',    '', '', '', '', '',                   null, 'pupu1_test_6.6', null, '(PuPu is stunned for a second, as his eyes lock on the magical berry) Pu...', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_6.6_success_1', 'choice', 0, false,    '', '', '', '', '',    'pupu1_6.6_success_2', '', '', '', '',          null, null, null, 'Don''t you want this juicy, slimy fabulous fruit? It''ll make your jaw drop with amazement!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%EXCITED%'),
(9, 'pupu1_6.6_success_2', 'choice', 0, false,    '', '', '', '', '',    'pupu1_6.6_success_3', '', '', '', '',          null, null, null, '(PuPu''s mouth waters) Ye.. Yes. PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_6.6_success_3', 'choice', 0, false,    '', '', '', '', '',    'pupu1_6.6_success_4', '', '', '', '',          null, null, null, '(%PET_NAME% giggles and places the magical berries on the floor, then dashes into the forest inside)', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%HAPPY%'),
(9, 'pupu1_6.6_success_4', 'choice', 0, false,    '', '', '', '', '',    'pupu1_wrapup', '', '', '', '',                 'pupu1_cost_6_success', null, null, '(PuPu happily nibbles the berry, not caring where %PET_NAME% went) PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_6.6_fail_1', 'choice', 0, false,        '', '', '', '', '',    'pupu1_6.6_fail_2', '', '', '', '',             null, null, null, 'So, have we got a deal? This berry is top-notch.', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%HAPPY%'),
(9, 'pupu1_6.6_fail_2', 'choice', 0, false,        '', '', '', '', '',    'pupu1_6.6_fail_2', '', '', '', '',             null, null, null, '(PuPu shakes his head) Magical berries cause tummy rumbles to PuPu.', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_6.6_fail_3', 'choice', 0, false,        '', '', '', '', '',    'pupu1_6.6_fail_2', '', '', '', '',             null, null, null, '(%PET_NAME% pouts) Oh...', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SICK%'),
(9, 'pupu1_6.6_fail_4', 'choice', 0, false,        '', '', '', '', '',    'pupu1_6.6_fail_2', '', '', '', '',             null, null, null, 'No deal! PuPu! Scoot now! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_6.6_fail_5', 'choice', 0, false,        '', '', '', '', '',    'pupu1_wrapup', '', '', '', '',             'pupu1_cost_6_fail', null, null, '(%PET_NAME% shrugs, steps back, and leaves the scene)', 'img/global-quest/quest-pupu.webp', '', ''),


(9, 'pupu1_7.0', 'choice', 0, false,              '', '', '', '', '',    'pupu1_7.1', '', '', '', '',          null, null, null, 'PuPu, yes! You can''t trespass here! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_7.1', 'choice', 0, false,              '', '', '', '', '',    'pupu1_7.2', '', '', '', '',          null, null, null, '(%PET_NAME% gasps) Oh, I guess I should leave then.', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SICK%'),
(9, 'pupu1_7.2', 'choice', 0, false,              '', '', '', '', '',    'pupu1_7.3', '', '', '', '',          null, null, null, 'Uh huh! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_7.3', 'choice', 0, false,              '', '', '', '', '',    'pupu1_7.4', '', '', '', '',          null, null, null, '...thought I''d say that? Fool! Hahaha! I''m going to take over this place!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%EXCITED%'),
(9, 'pupu1_7.4', 'choice', 0, false,              '', '', '', '', '',    'pupu1_7.5', '', '', '', '',          null, null, null, 'Taking over? PuPu will show you the formidable side and teach you a lesson! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_7.5', 'choice', 0, false,              '', '', '', '', '',    'pupu1_7.6', '', '', '', '',          null, null, null, '(%PET_NAME% swiftly trespasses into the more secluded sections of the Forest)', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_7.6', 'choice', 0, false,              '', '', '', '', '',    '', '', '', '', '',                   null, 'pupu1_test_7.6', null, 'C.. come back here, PuPu! (PuPu chases after %PET_NAME%)', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', ''),

(9, 'pupu1_7.6_success_1', 'choice', 0, false,       '', '', '', '', '',    'pupu1_7.6_success_2', '', '', '', '',    null, null, null, '(PuPu pants hard and slows down after relentless chasing after %PET_NAME%) Ha... PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_7.6_success_2', 'choice', 0, false,       '', '', '', '', '',    'pupu1_wrapup', '', '', '', '',           'pupu1_cost_7_success', null, null, '(%PET_NAME% laughs and disappears swiftly from the sight of PuPu)', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_7.6_fail_1', 'choice', 0, false,       '', '', '', '', '',    'pupu1_7.6_fail_2', '', '', '', '',          null, null, null, '(PuPu quickly catches up to %PET_NAME%) I got you! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_7.6_fail_2', 'choice', 0, false,       '', '', '', '', '',    'pupu1_7.6_fail_3', '', '', '', '',          null, null, null, '(%PET_NAME% gasps) Okay! I leave! I leave!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%NERVOUS%'),
(9, 'pupu1_7.6_fail_3', 'choice', 0, false,       '', '', '', '', '',    'pupu1_7.6_fail_4', '', '', '', '',          null, null, null, 'You are no match against PuPu when it comes to running! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_7.6_fail_4', 'choice', 0, false,       '', '', '', '', '',    'pupu1_wrapup', '', '', '', '',              'pupu1_cost_7_fail', null, null, '(%PET_NAME% sulks and backs away and leaves the forest)', 'img/global-quest/quest-pupu.webp', '', ''),


(9, 'pupu1_8.0', 'choice', 0, false,       '', '', '', '', '',    'pupu1_8.1', '', '', '', '',          null, null, null, 'A tickle feather? What does it do, PuPu?', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_8.1', 'choice', 0, false,       '', '', '', '', '',    'pupu1_8.2', '', '', '', '',          null, null, null, 'You see, you use this to tickle other folks, and guess what they will do?', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%HAPPY%'),
(9, 'pupu1_8.2', 'choice', 0, false,       '', '', '', '', '',    'pupu1_8.3', '', '', '', '',          null, null, null, 'Uhm... Would it cause them to get angry?? PuPu?', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_8.3', 'choice', 0, false,       '', '', '', '', '',    'pupu1_8.4', '', '', '', '',          null, null, null, '(%PET_NAME% laughs) Of course not! It will actually make them laugh!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%EXCITED%'),
(9, 'pupu1_8.4', 'choice', 0, false,       '', '', '', '', '',    'pupu1_8.5', '', '', '', '',          null, null, null, 'Mmm.. I see.. PuPu..', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_8.5', 'choice', 0, false,       '', '', '', '', '',    'pupu1_8.6', '', '', '', '',          null, null, null, 'Don''t you think this is so cool? Do you want it? I will trade for a Sunset Mushroom!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%HAPPY%'),
(9, 'pupu1_8.6', 'choice', 0, false,       '', '', '', '', '',    '', '', '', '', '',                   null, 'pupu1_test_8.6', null, '(PuPu carefully examines the tickle feather)', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_8.6_success_1', 'choice', 0, false,       '', '', '', '', '',    'pupu1_8.6_success_2', '', '', '', '',    null, null, null, 'PuPu can trade the tickle feather for PuPu Mushroom! It makes you laugh too. PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_8.6_success_2', 'choice', 0, false,       '', '', '', '', '',    'pupu1_8.6_success_3', '', '', '', '',    null, null, null, 'A mushroom that makes me laugh? I guess that works..', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SURPRISED%'),
(9, 'pupu1_8.6_success_3', 'choice', 1, false,       '', '', '', '', '',    'pupu1_wrapup', '', '', '', '',           'pupu1_cost_8_success', null, null, '(%PET_NAME% and PuPu trade their items)', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_8.6_fail_1', 'choice', 0, false,       '', '', '', '', '',    'pupu1_8.6_fail_2', '', '', '', '',          null, null, null, '(PuPu quickly catches up to %PET_NAME%) I got you! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_8.6_fail_2', 'choice', 0, false,       '', '', '', '', '',    'pupu1_8.6_fail_3', '', '', '', '',          null, null, null, '(%PET_NAME% gasps) Okay! I leave! I leave!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%NERVOUS%'),
(9, 'pupu1_8.6_fail_3', 'choice', 0, false,       '', '', '', '', '',    'pupu1_8.6_fail_4', '', '', '', '',          null, null, null, 'You are no match against PuPu when it comes to running! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_8.6_fail_4', 'choice', 0, false,       '', '', '', '', '',    'pupu1_wrapup', '', '', '', '',              'pupu1_cost_8_fail', null, null, '(%PET_NAME% sulks and backs away and leaves the forest)', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_9.0', 'choice', 0, false,       '', '', '', '', '',    'pupu1_9.1', '', '', '', '',          null, null, null, 'PuPu knows what magic the magical berries do to me! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_9.1', 'choice', 0, false,       '', '', '', '', '',    'pupu1_9.2', '', '', '', '',          null, null, null, 'Oh! You do?', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SURPRISED%'),
(9, 'pupu1_9.2', 'choice', 0, false,       '', '', '', '', '',    'pupu1_9.3', '', '', '', '',          null, null, null, 'Yes! Magical berries cause tummy rumbles when PuPu eats them! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_9.3', 'choice', 0, false,       '', '', '', '', '',    'pupu1_9.4', '', '', '', '',          null, null, null, 'Oh.. really? That is too bad. (%PET_NAME% starts to eat the magical berries innocently)', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%TIRED%'),
(9, 'pupu1_9.4', 'choice', 0, false,       '', '', '', '', '',    'pupu1_9.5', '', '', '', '',          null, null, null, '(PuPu looks at %PET_NAME% with his mouth watering) PuPu..', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_9.5', 'choice', 0, false,       '', '', '', '', '',    'pupu1_9.6', '', '', '', '',          null, null, null, '(%PET_NAME% looks at PuPu) Do you still want some?', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%HAPPY%'),
(9, 'pupu1_9.6', 'choice', 0, false,       '', '', '', '', '',    'pupu1_9.7', '', '', '', '',          null, null, null, '(PuPu nods) Yes! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_9.7', 'choice', 0, false,       '', '', '', '', '',    'pupu1_9.8', '', '', '', '',          null, null, null, '(%PET_NAME% gives the magical berry) Now give me the Sunset Mushroom!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%CONFIDENT%'),
(9, 'pupu1_9.8', 'choice', 0, false,       '', '', '', '', '',    'pupu1_9.9', '', '', '', '',          null, null, null, '(PuPu eats the berry) PuPu doesn''t have that mushroom. PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_9.9', 'choice', 0, false,       '', '', '', '', '',    'pupu1_9.10', '', '', '', '',         null, null, null, 'Wha... What? This is not fair!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%NERVOUS%'),
(9, 'pupu1_9.10', 'choice', 0, false,      '', '', '', '', '',    'pupu1_wrapup', '', '', '', '',       'pupu1_cost_9_success', null, null, '(PuPu grunts) Eeek! PuPu is having a tummy rumble! PuPu must go! Bye! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),


(9, 'pupu1_10.0', 'choice', 0, false,       '', '', '', '', '',    'pupu1_10.1', '', '', '', '',          null, null, null, 'Mirror of Past-life? What does it do, PuPu?', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_10.1', 'choice', 0, false,       '', '', '', '', '',    'pupu1_10.2', '', '', '', '',          null, null, null, 'It allows you to see who you were in the past life. Do you want to know who you were?', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%HAPPY%'),
(9, 'pupu1_10.2', 'choice', 0, false,       '', '', '', '', '',    'pupu1_10.3', '', '', '', '',          null, null, null, 'PuPu was a mushroom in the past life, PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_10.3', 'choice', 0, false,       '', '', '', '', '',    'pupu1_10.4', '', '', '', '',          null, null, null, 'You are wrong. This Mirror is telling me that you were more than just a mushroom.', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%HAPPY%'),
(9, 'pupu1_10.4', 'choice', 0, false,       '', '', '', '', '',    'pupu1_10.5', '', '', '', '',          null, null, null, 'PuPu? Really? What was I in the past life? PuPu?', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_10.5', 'choice', 0, false,       '', '', '', '', '',    'pupu1_10.6', '', '', '', '',          null, null, null, 'If you want to know, trade me with the Sunset Mushroom and it will tell you!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%CONFIDENT%'),
(9, 'pupu1_10.6', 'choice', 0, false,       '', '', '', '', '',    'pupu1_10.7', '', '', '', '',          null, null, null, '(PuPu hesitates and looks confused) Uhmmm.. PuPu...', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_10.7', 'choice', 0, false,       '', '', '', '', '',    'pupu1_10.8', '', '', '', '',          null, null, null, '(PuPu offers red-colored seeds) Take this! PuPu! Now give me that Mirror! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_10.8', 'choice', 0, false,       '', '', '', '', '',    'pupu1_10.9', '', '', '', '',          null, null, null, '(%PET_NAME% takes the seeds and gives the mirror) Here, take it.', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%HAPPY%'),
(9, 'pupu1_10.9', 'choice', 0, false,       '', '', '', '', '',    'pupu1_10.10', '', '', '', '',         null, null, null, '(PuPu takes the mirror and squeals in excitement) PuPu was an angel in the past life! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_10.10', 'choice', 0, false,      '', '', '', '', '',    'pupu1_wrapup', '', '', '', '',        'pupu1_cost_10_success', null, null, '(%PET_NAME% smiles and leaves, not realizing the seed was a weed seed)', 'img/global-quest/quest-pupu.webp', '', ''),


(9, 'pupu1_11.0', 'choice', 0, false,       '', '', '', '', '',    'pupu1_11.1', '', '', '', '',          null, null, null, '(PuPu covers his ear) I am not cute! I am tough! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_11.1', 'choice', 0, false,       '', '', '', '', '',    'pupu1_11.2', '', '', '', '',          null, null, null, '(%PET_NAME% blushes) But.. You are cute...', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%CONFIDENT%'),
(9, 'pupu1_11.2', 'choice', 0, false,       '', '', '', '', '',    'pupu1_11.3', '', '', '', '',          null, null, null, '(PuPu steps back from %PET_NAME%) I.. I am not cute! Stop saying that, PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_11.3', 'choice', 0, false,       '', '', '', '', '',    'pupu1_11.4', '', '', '', '',          null, null, null, 'If you are not cute.. Then who else could possibly be cute?', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SURPRISED%'),
(9, 'pupu1_11.4', 'choice', 0, false,       '', '', '', '', '',    'pupu1_11.5', '', '', '', '',          null, null, null, 'PuPu!! Being cute is for weaklings!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_11.5', 'choice', 0, false,       '', '', '', '', '',    'pupu1_11.6', '', '', '', '',          null, null, null, '(%PET_NAME% laughs) Oh yeah? Come here, cutie! Let me catch you! Haha!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%EXCITED%'),
(9, 'pupu1_11.6', 'choice', 0, false,       '', '', '', '', '',    '', '', '', '', '',                    null, 'pupu1_test_11.6', null, '(PuPu gasps and starts to run away from %PET_NAME%) No! PuPu!!!', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_11.6_success_1', 'choice', 0, false,       '', '', '', '', '',    'pupu1_11.6_success_2', '', '', '', '',          null, null, null, '(PuPu runs hard, but his endurance didn''t last long before getting caught)', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_11.6_success_2', 'choice', 0, false,       '', '', '', '', '',    'pupu1_11.6_success_3', '', '', '', '',          null, null, null, 'Whahaha! I got you!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%EXCITED%'),
(9, 'pupu1_11.6_success_3', 'choice', 0, false,       '', '', '', '', '',    'pupu1_11.6_success_4', '', '', '', '',          null, null, null, '(PuPu cries) PuPu is weak. PuPu will die here. PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_11.6_success_4', 'choice', 0, false,       '', '', '', '', '',    'pupu1_wrapup', '', '', '', '',          'pupu1_cost_11_success', null, null, '(%PET_NAME% quickly kisses PuPu on the cheeks and disappears into the forest) So long! Cutie!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%HAPPY%'),

(9, 'pupu1_11.6_fail_1', 'choice', 0, false,        '', '', '', '', '',    'pupu1_11.6_fail_2', '', '', '', '',           null, null, null, '(PuPu runs away from %PET_NAME% with much effort and manages to escape into the forest)', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_11.6_fail_2', 'choice', 0, false,        '', '', '', '', '',    'pupu1_11.6_fail_3', '', '', '', '',           null, null, null, '(%PET_NAME% chuckles) I was only… kidding… Oh well..', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SICK%'),
(9, 'pupu1_11.6_fail_3', 'choice', 0, false,        '', '', '', '', '',    'pupu1_wrapup', '', '', '', '',               'pupu1_cost_11_fail', null, null, '(%PET_NAME% leaves the forest in disappointment)', 'img/global-quest/quest-pupu.webp', '', ''),


(9, 'pupu1_12.0', 'choice', 0, false,       '', '', '', '', '',    'pupu1_12.1', '', '', '', '',          null, null, null, '(PuPu trembles) That is not a reason to kidnap someone, PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_12.1', 'choice', 0, false,       '', '', '', '', '',    'pupu1_12.2', '', '', '', '',          null, null, null, 'But this is my reason!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SICK%'),
(9, 'pupu1_12.2', 'choice', 0, false,       '', '', '', '', '',    'pupu1_12.3', '', '', '', '',          null, null, null, 'PuPu! You are so mean! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_12.3', 'choice', 0, false,       '', '', '', '', '',    'pupu1_12.4', '', '', '', '',          null, null, null, 'Just blame yourself that you are ugly! Or you wouldn''t be kidnapped!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%TIRED%'),
(9, 'pupu1_12.4', 'choice', 0, false,       '', '', '', '', '',    'pupu1_12.5', '', '', '', '',          null, null, null, '(PuPu tears) But I am not ugly!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_12.5', 'choice', 0, false,       '', '', '', '', '',    'pupu1_12.6', '', '', '', '',          null, null, null, '(%PET_NAME% laughs evily and makes a swift move to dash toward PuPu to capture him)', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_12.6', 'choice', 0, false,       '', '', '', '', '',    '', '', '', '', '',                    null, 'pupu1_test_12.6', null, '(PuPu screams and gets ready to counter %PET_NAME%)', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_12.6_success_1', 'choice', 0, false,        '', '', '', '', '',    'pupu1_12.6_success_2', '', '', '', '',     null, null, null, '(After a fierce battle, PuPu seemed to lose the pace to keep up the fight with %PET_NAME%)', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_12.6_success_2', 'choice', 0, false,        '', '', '', '', '',    'pupu1_12.6_success_3', '', '', '', '',     null, null, null, '(%PET_NAME% finally defeats PuPu and captures him) There! I got you now!', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%EXCITED%'),
(9, 'pupu1_12.6_success_3', 'choice', 0, false,        '', '', '', '', '',    'pupu1_12.6_success_4', '', '', '', '',     null, null, null, '(PuPu cries) You are so mean! PuPu….', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', ''),
(9, 'pupu1_12.6_success_4', 'choice', 0, false,        '', '', '', '', '',    'pupu1_wrapup', '', '', '', '',             'pupu1_cost_12_success', null, null, '(%PET_NAME% chuckles and lets go of PuPu, leaving the scene) Don''t let me catch you next time. Bye.', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%TIRED%'),

(9, 'pupu1_12.6_fail_1', 'choice', 0, false,        '', '', '', '', '',    'pupu1_12.6_fail_2', '', '', '', '',           null, null, null, '(After numerous battles, %PET_NAME% makes mistakes in fighting and gets a fatal blow)', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%NERVOUS%'),
(9, 'pupu1_12.6_fail_2', 'choice', 0, false,        '', '', '', '', '',    'pupu1_12.6_fail_3', '', '', '', '',           null, null, null, '(%PET_NAME% flexes arms) Eeeyah! PuPu is strong! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_12.6_fail_3', 'choice', 0, false,         '', '', '', '', '',   'pupu1_12.6_fail_4', '', '', '', '',           null, null, null, '(%PET_NAME% grunts in pain) I.. I was wrong.. I will leave here at once.', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%CRITICAL%'),
(9, 'pupu1_12.6_fail_4', 'choice', 0, false,         '', '', '', '', '',   'pupu1_wrapup', '', '', '', '',                'pupu1_cost_12_fail', null, null, '(%PET_NAME% quickly runs away from PuPu mortified)', 'img/global-quest/quest-pupu.webp', '', ''),


(9, 'pupu1_13.0', 'choice', 0, false,       '', '', '', '', '',    'pupu1_13.1', '', '', '', '',          null, null, null, 'PuPu has nothing that you would want! Get away from PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_13.1', 'choice', 0, false,       '', '', '', '', '',    'pupu1_13.2', '', '', '', '',          null, null, null, 'Oh.. so.. does that mean you are worthless?', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SURPRISED%'),
(9, 'pupu1_13.2', 'choice', 0, false,       '', '', '', '', '',    'pupu1_13.3', '', '', '', '',          null, null, null, 'PuPu is not worthless just because PuPu doesn''t have anything that you want! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_13.3', 'choice', 0, false,       '', '', '', '', '',    'pupu1_13.4', '', '', '', '',          null, null, null, 'If you have nothing that I want, you are worthless to me.', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%TIRED%'),
(9, 'pupu1_13.4', 'choice', 0, false,       '', '', '', '', '',    'pupu1_13.5', '', '', '', '',          null, null, null, 'PuPu has feelings and emotions and thoughts like everyone else! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_13.5', 'choice', 0, false,       '', '', '', '', '',    'pupu1_13.6', '', '', '', '',          null, null, null, '(%PET_NAME% yawns) Whatever... Since you are worthless to me, I will be on my way. Bye', 'img/global-quest/quest-pupu.webp', '%PET_FACE%', '%SICK%'),
(9, 'pupu1_13.6', 'choice', 0, false,       '', '', '', '', '',    'pupu1_13.7', '', '', '', '',          null, null, null, 'You are the meaniest creature PuPu has ever encountered! PuPu!', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_13.7', 'choice', 0, false,       '', '', '', '', '',    'pupu1_wrapup', '', '', '', '',        'pupu1_cost_13_success', null, null, '(%PET_NAME% shrugs and quickly heads for other locations)', 'img/global-quest/quest-pupu.webp', '', ''),

(9, 'pupu1_wrapup', 'choice', 1, false,    '', '', '', '', '',    'pupu1_end', '', '', '', '',           null, null, null, '%FATIGUE_MSG% Your pet''s other stats have changed as follows:<br/>%STAT_COST% %FOOD_STAT_COST%', 'img/global-quest/quest-pupu.webp', '', ''),
(9, 'pupu1_end', 'choice', 0, true,        '', '', '', '', '',    '', '', '', '', '',                    null, null, null, '', 'img/global-quest/quest-pupu.webp', '', '')
;

-- -------------------------------------
-- Meet PuPu the Mushroom - Tests
insert into ps_stat_test
(quest_id, action,   win_action,         lose_action,               constitution, strength, agility, charm, confidence, empathy, intelligence, wisdom, sorcery, loyalty, spirituality, karma)
values
-- Pupu the mushroom stats                                           35,           25,       20,        20,    25,       35,     10,             25,      10,      40,        25,         25
(9, 'pupu1_test_5.6', 'pupu1_5.6_success_1', 'pupu1_5.6_fail_1',     35,           25,       20,         0,     0,        0,      0,              0,       0,       0,         0,          0),
(9, 'pupu1_test_6.6', 'pupu1_6.6_success_1', 'pupu1_6.6_fail_1',      0,            0,        0,        20,     0,       35,      0,              0,       0,       0,         0,          0),
(9, 'pupu1_test_7.6', 'pupu1_7.6_success_1', 'pupu1_7.6_fail_1',     35,            0,        0,         0,     0,        0,      0,              0,       0,       0,         0,          0),
(9, 'pupu1_test_8.6', 'pupu1_8.6_success_1', 'pupu1_8.6_fail_1',      0,            0,        0,         0,     0,        0,     10,              0,       0,       0,         0,          0),
(9, 'pupu1_test_11.6', 'pupu1_11.6_success_1', 'pupu1_11.6_fail_1',  35,            0,        0,         0,     0,        0,      0,              0,       0,       0,         0,          0),
(9, 'pupu1_test_12.6', 'pupu1_12.6_success_1', 'pupu1_12.6_fail_1',  35,           25,       20,         0,     0,        0,      0,              0,       0,       0,         0,          0)
;

-- -------------------------------------------
-- Meet PuPu the Mushroom  - Costs
insert into ps_stat_cost
(quest_id, action,          constitution, strength, agility, charm, confidence, empathy, intelligence, wisdom, sorcery, loyalty, spirituality, karma, fatigue, food)
values
(9, 'pupu1_initial_cost',       0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,    0,  -50),
(9, 'pupu1_cost_5_success',     0,            1,        0,       0,     0,          0,       0,             0,     0,       1,        0,            0,   12,    0),
(9, 'pupu1_cost_5_fail',        0,            1,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,   14 ,    0),
(9, 'pupu1_cost_6_success',     0,            0,        0,       0,     1,          0,       1,             0,     0,       0,        0,            0,   12,    0),
(9, 'pupu1_cost_6_fail',        0,            0,        0,       0,     0,          0,       1,             0,     0,       0,        0,            0,   14,    0),
(9, 'pupu1_cost_7_success',     0,            0,        1,       0,     0,          0,       0,             0,     0,       0,        0,            1,   12,    0),
(9, 'pupu1_cost_7_fail',        1,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,   14,    0),
(9, 'pupu1_cost_8_success',     0,            0,        0,       0,     0,          0,       1,             0,     0,       1,        0,            0,   12,    0),
(9, 'pupu1_cost_8_fail',        0,            0,        0,       0,     0,          0,       1,             0,     0,       0,        0,            0,   14,    0),
(9, 'pupu1_cost_9_success',     0,            0,        0,       0,     0,          1,       0,             1,     0,       0,        0,            0,   14,    0),
(9, 'pupu1_cost_10_success',    0,            0,        0,       0,     1,          0,       0,             0,     1,       0,        0,            0,   14,    0),
(9, 'pupu1_cost_11_success',    0,            0,        0,       1,     0,          0,       0,             0,     0,       0,        0,            1,   12,    0),
(9, 'pupu1_cost_11_fail',       0,            0,        0,       1,     0,          0,       0,             0,     0,       0,        0,            0,   14,    0),
(9, 'pupu1_cost_12_success',    0,            1,        0,       0,     0,          0,       0,             0,     0,       1,        0,            0,   12,    0),
(9, 'pupu1_cost_12_fail',       1,            0,        0,       0,     0,          0,       0,             0,     0,       0,        0,            0,   14,    0),
(9, 'pupu1_cost_13_success',    0,            0,        0,       0,     0,          0,       0,             0,     0,       0,        1,            0,   14,    0)
;


-- ----------------------------------------------------------------------------------------
-- Base Pet definitions
insert into ps_pet
(id, species, owner_type, texture, face_texture, color, attribute_texture, attribute_name, grade)
values 
(1, 'Bryony',   'any', 'img/pet-portrait/pet-plant-1-bryony.webp',  'img/pet-portrait/pet-plant-1-bryony-face.webp', (select color from ps_attribute where attribute = 'Plant'), (select texture as attribure_texture from ps_attribute where attribute = 'Plant'), 'Plant', 'Common'),
(2, 'Leafsong', 'any', 'img/pet-portrait/pet-plant-1-leafsong.webp', 'img/pet-portrait/pet-plant-1-leafsong-face.webp', (select color from ps_attribute where attribute = 'Plant'),  (select texture as attribure_texture from ps_attribute where attribute = 'Plant'), 'Plant',  'Common'),
(3, 'Lupine',   'any', 'img/pet-portrait/pet-plant-1-lupine.webp', 'img/pet-portrait/pet-plant-1-lupine-face.webp', (select color from ps_attribute where attribute = 'Plant'), (select texture as attribure_texture from ps_attribute where attribute = 'Plant'), 'Plant', 'Common'),
(4, 'Slyph',    'any', 'img/pet-portrait/pet-plant-1-sylph.webp', 'img/pet-portrait/pet-plant-1-sylph-face.webp', (select color from ps_attribute where attribute = 'Plant'), (select texture as attribure_texture from ps_attribute where attribute = 'Plant'), 'Plant', 'Common'),
(5, 'Thorn',    'any', 'img/pet-portrait/pet-plant-1-thorn.webp', 'img/pet-portrait/pet-plant-1-thorn-face.webp', (select color from ps_attribute where attribute = 'Plant'), (select texture as attribure_texture from ps_attribute where attribute = 'Plant'), 'Plant', 'Common'),

(10, 'Avidra',    'any', 'img/pet-portrait/pet-air-1-avidra.webp', 'img/pet-portrait/pet-air-1-avidra-face.webp', (select color from ps_attribute where attribute = 'Air'), (select texture as attribure_texture from ps_attribute where attribute = 'Air'), 'Air', 'Common'),
(11, 'Gryphius',  'any', 'img/pet-portrait/pet-air-1-gryphius.webp', 'img/pet-portrait/pet-air-1-gryphius-face.webp', (select color from ps_attribute where attribute = 'Air'), (select texture as attribure_texture from ps_attribute where attribute = 'Air'), 'Air', 'Common'),
(12, 'Valkyrix',  'any', 'img/pet-portrait/pet-air-1-valkyrix.webp', 'img/pet-portrait/pet-air-1-valkyrix-face.webp', (select color from ps_attribute where attribute = 'Air'), (select texture as attribure_texture from ps_attribute where attribute = 'Air'), 'Air', 'Common'),
(13, 'Windrifter','any', 'img/pet-portrait/pet-air-1-windrifter.webp', 'img/pet-portrait/pet-air-1-windrifter-face.webp', (select color from ps_attribute where attribute = 'Air'), (select texture as attribure_texture from ps_attribute where attribute = 'Air'), 'Air', 'Common'),
(14, 'Zephyrus',  'any', 'img/pet-portrait/pet-air-1-zephyrus.webp', 'img/pet-portrait/pet-air-1-zephyrus-face.webp', (select color from ps_attribute where attribute = 'Air'), (select texture as attribure_texture from ps_attribute where attribute = 'Air'), 'Air', 'Common'),

(20, 'Frostfang', 'any', 'img/pet-portrait/pet-cold-1-frostfang.webp', 'img/pet-portrait/pet-cold-1-frostfang-face.webp', (select color from ps_attribute where attribute = 'Cold'), (select texture as attribure_texture from ps_attribute where attribute = 'Cold'), 'Cold', 'Common'),
(21, 'Icefudge',  'any', 'img/pet-portrait/pet-cold-1-icefudge.webp', 'img/pet-portrait/pet-cold-1-icefudge-face.webp', (select color from ps_attribute where attribute = 'Cold'), (select texture as attribure_texture from ps_attribute where attribute = 'Cold'), 'Cold', 'Common'),
(22, 'Muffin',    'any', 'img/pet-portrait/pet-cold-1-muffin.webp', 'img/pet-portrait/pet-cold-1-muffin-face.webp', (select color from ps_attribute where attribute = 'Cold'), (select texture as attribure_texture from ps_attribute where attribute = 'Cold'), 'Cold', 'Common'),
(23, 'Tootsie',   'any', 'img/pet-portrait/pet-cold-1-tootsie.webp', 'img/pet-portrait/pet-cold-1-tootsie-face.webp', (select color from ps_attribute where attribute = 'Cold'), (select texture as attribure_texture from ps_attribute where attribute = 'Cold'), 'Cold', 'Common'),
(24, 'Whisk',     'any', 'img/pet-portrait/pet-cold-1-whisk.webp', 'img/pet-portrait/pet-cold-1-whisk-face.webp', (select color from ps_attribute where attribute = 'Cold'), (select texture as attribure_texture from ps_attribute where attribute = 'Cold'), 'Cold', 'Common'),

(30, 'Darkmaw',     'any', 'img/pet-portrait/pet-darkness-1-darkmaw.webp', 'img/pet-portrait/pet-darkness-1-darkmaw-face.webp', (select color from ps_attribute where attribute = 'Darkness'),  (select texture as attribure_texture from ps_attribute where attribute = 'Darkness'), 'Darkness',  'Common'),
(31, 'Desolator',   'any', 'img/pet-portrait/pet-darkness-1-desolator.webp', 'img/pet-portrait/pet-darkness-1-desolator-face.webp', (select color from ps_attribute where attribute = 'Darkness'),  (select texture as attribure_texture from ps_attribute where attribute = 'Darkness'), 'Darkness',  'Common'),
(32, 'Doomgloom',   'any', 'img/pet-portrait/pet-darkness-1-doomgloom.webp', 'img/pet-portrait/pet-darkness-1-doomgloom-face.webp', (select color from ps_attribute where attribute = 'Darkness'),  (select texture as attribure_texture from ps_attribute where attribute = 'Darkness'), 'Darkness',  'Common'),
(33, 'Grimshade',   'any', 'img/pet-portrait/pet-darkness-1-grimshade.webp', 'img/pet-portrait/pet-darkness-1-grimshade-face.webp', (select color from ps_attribute where attribute = 'Darkness'),  (select texture as attribure_texture from ps_attribute where attribute = 'Darkness'), 'Darkness',  'Common'),
(34, 'Shadeprowler','any', 'img/pet-portrait/pet-darkness-1-shadeprowler.webp', 'img/pet-portrait/pet-darkness-1-shadeprowler-face.webp', (select color from ps_attribute where attribute = 'Darkness'),  (select texture as attribure_texture from ps_attribute where attribute = 'Darkness'), 'Darkness',  'Common'),

(40, 'Avenas',     'any', 'img/pet-portrait/pet-earth-1-avenas.webp', 'img/pet-portrait/pet-earth-1-avenas-face.webp', (select color from ps_attribute where attribute = 'Earth'), (select texture as attribure_texture from ps_attribute where attribute = 'Earth'), 'Earth', 'Common'),
(41, 'Bellflower', 'any', 'img/pet-portrait/pet-earth-1-bellflower.webp', 'img/pet-portrait/pet-earth-1-bellflower-face.webp', (select color from ps_attribute where attribute = 'Earth'), (select texture as attribure_texture from ps_attribute where attribute = 'Earth'), 'Earth', 'Common'),
(42, 'Fir',        'any', 'img/pet-portrait/pet-earth-1-fir.webp', 'img/pet-portrait/pet-earth-1-fir-face.webp', (select color from ps_attribute where attribute = 'Earth'), (select texture as attribure_texture from ps_attribute where attribute = 'Earth'), 'Earth', 'Common'),
(43, 'Gravel',     'any', 'img/pet-portrait/pet-earth-1-gravel.webp', 'img/pet-portrait/pet-earth-1-gravel-face.webp', (select color from ps_attribute where attribute = 'Earth'), (select texture as attribure_texture from ps_attribute where attribute = 'Earth'), 'Earth', 'Common'),
(44, 'Loam',       'any', 'img/pet-portrait/pet-earth-1-loam.webp', 'img/pet-portrait/pet-earth-1-loam-face.webp', (select color from ps_attribute where attribute = 'Earth'), (select texture as attribure_texture from ps_attribute where attribute = 'Earth'), 'Earth', 'Common'),

(50, 'Cootie',    'any', 'img/pet-portrait/pet-electricity-1-cootie.webp', 'img/pet-portrait/pet-electricity-1-cootie-face.webp', (select color from ps_attribute where attribute = 'Electricity'), (select texture as attribure_texture from ps_attribute where attribute = 'Electricity'), 'Electricity', 'Common'),
(51, 'Dynamo',    'any', 'img/pet-portrait/pet-electricity-1-dynamo.webp', 'img/pet-portrait/pet-electricity-1-dynamo-face.webp', (select color from ps_attribute where attribute = 'Electricity'), (select texture as attribure_texture from ps_attribute where attribute = 'Electricity'), 'Electricity', 'Common'),
(52, 'Flashbang', 'any', 'img/pet-portrait/pet-electricity-1-flashbang.webp', 'img/pet-portrait/pet-electricity-1-flashbang-face.webp', (select color from ps_attribute where attribute = 'Electricity'), (select texture as attribure_texture from ps_attribute where attribute = 'Electricity'), 'Electricity', 'Common'),
(53, 'Jolteon',   'any', 'img/pet-portrait/pet-electricity-1-jolteon.webp', 'img/pet-portrait/pet-electricity-1-jolteon-face.webp', (select color from ps_attribute where attribute = 'Electricity'), (select texture as attribure_texture from ps_attribute where attribute = 'Electricity'), 'Electricity', 'Common'),
(54, 'Voltara',   'any', 'img/pet-portrait/pet-electricity-1-voltara.webp', 'img/pet-portrait/pet-electricity-1-voltara-face.webp', (select color from ps_attribute where attribute = 'Electricity'), (select texture as attribure_texture from ps_attribute where attribute = 'Electricity'), 'Electricity', 'Common'),

(60, 'Ashen',   'any', 'img/pet-portrait/pet-fire-1-ashen.webp', 'img/pet-portrait/pet-fire-1-ashen-face.webp', (select color from ps_attribute where attribute = 'Fire'),  (select texture as attribure_texture from ps_attribute where attribute = 'Fire'), 'Fire',  'Common'),
(61, 'Burner',  'any', 'img/pet-portrait/pet-fire-1-burner.webp', 'img/pet-portrait/pet-fire-1-burner-face.webp', (select color from ps_attribute where attribute = 'Fire'),  (select texture as attribure_texture from ps_attribute where attribute = 'Fire'), 'Fire',  'Common'),
(62, 'Flareon', 'any', 'img/pet-portrait/pet-fire-1-flareon.webp', 'img/pet-portrait/pet-fire-1-flareon-face.webp', (select color from ps_attribute where attribute = 'Fire'),  (select texture as attribure_texture from ps_attribute where attribute = 'Fire'), 'Fire',  'Common'),
(63, 'Ignite',  'any', 'img/pet-portrait/pet-fire-1-ignite.webp', 'img/pet-portrait/pet-fire-1-ignite-face.webp', (select color from ps_attribute where attribute = 'Fire'),  (select texture as attribure_texture from ps_attribute where attribute = 'Fire'), 'Fire',  'Common'),
(64, 'Knurl',   'any', 'img/pet-portrait/pet-fire-1-knurl.webp', 'img/pet-portrait/pet-fire-1-knurl-face.webp', (select color from ps_attribute where attribute = 'Fire'),  (select texture as attribure_texture from ps_attribute where attribute = 'Fire'), 'Fire',  'Common'),

(70, 'Arabella',  'any', 'img/pet-portrait/pet-light-1-arabella.webp', 'img/pet-portrait/pet-light-1-arabella-face.webp', (select color from ps_attribute where attribute = 'Light'), (select texture as attribure_texture from ps_attribute where attribute = 'Light'), 'Light', 'Common'),
(71, 'Rosalind',  'any', 'img/pet-portrait/pet-light-1-rosalind.webp', 'img/pet-portrait/pet-light-1-rosalind-face.webp', (select color from ps_attribute where attribute = 'Light'), (select texture as attribure_texture from ps_attribute where attribute = 'Light'), 'Light', 'Common'),
(72, 'Seraphina', 'any', 'img/pet-portrait/pet-light-1-seraphina.webp', 'img/pet-portrait/pet-light-1-seraphina-face.webp', (select color from ps_attribute where attribute = 'Light'), (select texture as attribure_texture from ps_attribute where attribute = 'Light'), 'Light', 'Common'),
(73, 'Valentina', 'any', 'img/pet-portrait/pet-light-1-valentina.webp', 'img/pet-portrait/pet-light-1-valentina-face.webp', (select color from ps_attribute where attribute = 'Light'), (select texture as attribure_texture from ps_attribute where attribute = 'Light'), 'Light', 'Common'),
(74, 'Vivienne',  'any', 'img/pet-portrait/pet-light-1-vivienne.webp', 'img/pet-portrait/pet-light-1-vivienne-face.webp', (select color from ps_attribute where attribute = 'Light'), (select texture as attribure_texture from ps_attribute where attribute = 'Light'), 'Light', 'Common'),

(80, 'Ferrous',    'any', 'img/pet-portrait/pet-metal-1-ferrous.webp', 'img/pet-portrait/pet-metal-1-ferrous-face.webp', (select color from ps_attribute where attribute = 'Metal'), (select texture as attribure_texture from ps_attribute where attribute = 'Metal'), 'Metal', 'Common'),
(81, 'Metalcore',  'any', 'img/pet-portrait/pet-metal-1-metalcore.webp', 'img/pet-portrait/pet-metal-1-metalcore-face.webp', (select color from ps_attribute where attribute = 'Metal'), (select texture as attribure_texture from ps_attribute where attribute = 'Metal'), 'Metal', 'Common'),
(82, 'Sapphireus', 'any', 'img/pet-portrait/pet-metal-1-sapphire.webp', 'img/pet-portrait/pet-metal-1-sapphire-face.webp', (select color from ps_attribute where attribute = 'Metal'), (select texture as attribure_texture from ps_attribute where attribute = 'Metal'), 'Metal', 'Common'),
(83, 'Silt',       'any', 'img/pet-portrait/pet-metal-1-silt.webp', 'img/pet-portrait/pet-metal-1-silt-face.webp', (select color from ps_attribute where attribute = 'Metal'), (select texture as attribure_texture from ps_attribute where attribute = 'Metal'), 'Metal', 'Common'),
(84, 'Steelix',    'any', 'img/pet-portrait/pet-metal-1-steelix.webp', 'img/pet-portrait/pet-metal-1-steelix-face.webp', (select color from ps_attribute where attribute = 'Metal'), (select texture as attribure_texture from ps_attribute where attribute = 'Metal'), 'Metal', 'Common'),

(90, 'Finley',   'any', 'img/pet-portrait/pet-water-1-finley.webp', 'img/pet-portrait/pet-water-1-finley-face.webp', (select color from ps_attribute where attribute = 'Water'), (select texture as attribure_texture from ps_attribute where attribute = 'Water'), 'Water', 'Common'),
(91, 'Kelpie',   'any', 'img/pet-portrait/pet-water-1-kelpie.webp', 'img/pet-portrait/pet-water-1-kelpie-face.webp', (select color from ps_attribute where attribute = 'Water'), (select texture as attribure_texture from ps_attribute where attribute = 'Water'), 'Water', 'Common'),
(92, 'Lily',     'any', 'img/pet-portrait/pet-water-1-lily.webp', 'img/pet-portrait/pet-water-1-lily-face.webp', (select color from ps_attribute where attribute = 'Water'), (select texture as attribure_texture from ps_attribute where attribute = 'Water'), 'Water', 'Common'),
(93, 'Nixie',    'any', 'img/pet-portrait/pet-water-1-nixie.webp', 'img/pet-portrait/pet-water-1-nixie-face.webp', (select color from ps_attribute where attribute = 'Water'), (select texture as attribure_texture from ps_attribute where attribute = 'Water'), 'Water', 'Common'),
(94, 'Pearlina', 'any', 'img/pet-portrait/pet-water-1-pearlina.webp', 'img/pet-portrait/pet-water-1-pearlina-face', (select color from ps_attribute where attribute = 'Water'), (select texture as attribure_texture from ps_attribute where attribute = 'Water'), 'Water', 'Common')
;



-- ----------------------------------------------------------------
-- Wild Pets
-- ----------------------------------------------------------------

insert into ps_player_pet (id, pet_number, pet_id, parent_a, parent_b, avuuid, is_wild, birth_date, stage, health, habitat, personality, fatigue, fitness_rank_tier, constitution, strength, agility, wizardry_rank_tier, intelligence, wisdom, sorcery, charisma_rank_tier, charm, confidence, empathy, nature_rank_tier, loyalty, spirituality, karma)
values
(901, 0, 1, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Rainforest', 'Independent', 0, 'D-', 10, 10, 10, 'D-', 10, 10, 10, 'D+', 10, 10, 10, 'D', 10, 10, 10),
(902, 0, 2, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Meadow', 'Calm', 0, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10),
(903, 0, 3, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Rainforest', 'Curious', 0, 'D', 10, 10, 10, 'D+', 10, 10, 10, 'D-', 10, 10, 10, 'D', 10, 10, 10),
(904, 0, 4, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Coastal', 'Calm', 0, 'D', 10, 10, 10, 'D-', 10, 10, 10, 'D', 10, 10, 10, 'D+', 10, 10, 10),
(905, 0, 5, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Rainforest', 'Playful', 0, 'D', 10, 10, 10, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10),
(906, 0, 10, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Alpine', 'Independent', 0, 'D-', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10),
(907, 0, 11, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Tundra', 'Social', 0, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D+', 10, 10, 10, 'D-', 10, 10, 10),
(908, 0, 12, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Tundra', 'Protective', 0, 'D-', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10),
(909, 0, 13, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Plain', 'Calm', 0, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10, 'D+', 10, 10, 10),
(910, 0, 14, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Tundra', 'Independent', 0, 'D', 10, 10, 10, 'D', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10),
(911, 0, 20, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Alpine', 'Affectionate', 0, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D+', 10, 10, 10, 'D-', 10, 10, 10),
(912, 0, 21, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Alpine', 'Energetic', 0, 'D', 10, 10, 10, 'D', 10, 10, 10, 'D+', 10, 10, 10, 'D', 10, 10, 10),
(913, 0, 22, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Autumnal', 'Curious', 0, 'D+', 10, 10, 10, 'D-', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10),
(914, 0, 23, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Glacier', 'Energetic', 0, 'D+', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10, 'D', 10, 10, 10),
(915, 0, 24, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Alpine', 'Protective', 0, 'D-', 10, 10, 10, 'D+', 10, 10, 10, 'D+', 10, 10, 10, 'D+', 10, 10, 10),
(916, 0, 30, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Volcano', 'Loyal', 0, 'D', 10, 10, 10, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D+', 10, 10, 10),
(917, 0, 31, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Volcano', 'Mischievous', 0, 'D-', 10, 10, 10, 'D', 10, 10, 10, 'D+', 10, 10, 10, 'D', 10, 10, 10),
(918, 0, 32, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Volcano', 'Energetic', 0, 'D+', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10, 'D', 10, 10, 10),
(919, 0, 33, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Volcano', 'Curious', 0, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10),
(920, 0, 34, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Volcano', 'Playful', 0, 'D-', 10, 10, 10, 'D-', 10, 10, 10, 'D+', 10, 10, 10, 'D+', 10, 10, 10),
(921, 0, 40, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Swamp', 'Independent', 0, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D+', 10, 10, 10, 'D+', 10, 10, 10),
(922, 0, 41, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Swamp', 'Affectionate', 0, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10),
(923, 0, 42, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Village', 'Social', 0, 'D-', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10),
(924, 0, 43, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Tundra', 'Affectionate', 0, 'D-', 10, 10, 10, 'D-', 10, 10, 10, 'D+', 10, 10, 10, 'D-', 10, 10, 10),
(925, 0, 44, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Village', 'Mischievous', 0, 'D-', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10),
(926, 0, 50, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Heaven', 'Energetic', 0, 'D+', 10, 10, 10, 'D-', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10),
(927, 0, 51, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Heaven', 'Loyal', 0, 'D', 10, 10, 10, 'D', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10),
(928, 0, 52, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Cave', 'Curious', 0, 'D', 10, 10, 10, 'D+', 10, 10, 10, 'D-', 10, 10, 10, 'D', 10, 10, 10),
(929, 0, 53, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Glacier', 'Protective', 0, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10),
(930, 0, 54, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Village', 'Loyal', 0, 'D', 10, 10, 10, 'D+', 10, 10, 10, 'D-', 10, 10, 10, 'D+', 10, 10, 10),
(931, 0, 60, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Volcano', 'Energetic', 0, 'D+', 10, 10, 10, 'D+', 10, 10, 10, 'D+', 10, 10, 10, 'D-', 10, 10, 10),
(932, 0, 61, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Volcano', 'Independent', 0, 'D-', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10, 'D+', 10, 10, 10),
(933, 0, 62, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Volcano', 'Affectionate', 0, 'D-', 10, 10, 10, 'D', 10, 10, 10, 'D+', 10, 10, 10, 'D+', 10, 10, 10),
(934, 0, 63, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Volcano', 'Calm', 0, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D+', 10, 10, 10, 'D', 10, 10, 10),
(935, 0, 64, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Hell', 'Independent', 0, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10, 'D', 10, 10, 10),
(936, 0, 70, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Meadow', 'Independent', 0, 'D+', 10, 10, 10, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D+', 10, 10, 10),
(937, 0, 71, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Meadow', 'Independent', 0, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10),
(938, 0, 72, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Meadow', 'Calm', 0, 'D', 10, 10, 10, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10),
(939, 0, 73, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Blossom', 'Protective', 0, 'D', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10, 'D+', 10, 10, 10),
(940, 0, 74, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Heaven', 'Mischievous', 0, 'D+', 10, 10, 10, 'D+', 10, 10, 10, 'D+', 10, 10, 10, 'D', 10, 10, 10),
(941, 0, 80, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Graveyard', 'Calm', 0, 'D-', 10, 10, 10, 'D+', 10, 10, 10, 'D-', 10, 10, 10, 'D+', 10, 10, 10),
(942, 0, 81, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Graveyard', 'Affectionate', 0, 'D-', 10, 10, 10, 'D+', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10),
(943, 0, 82, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Mountain', 'Protective', 0, 'D+', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10, 'D', 10, 10, 10),
(944, 0, 83, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Underground', 'Affectionate', 0, 'D-', 10, 10, 10, 'D', 10, 10, 10, 'D', 10, 10, 10, 'D-', 10, 10, 10),
(945, 0, 84, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Underground', 'Playful', 0, 'D+', 10, 10, 10, 'D-', 10, 10, 10, 'D+', 10, 10, 10, 'D', 10, 10, 10),
(946, 0, 90, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Swamp', 'Calm', 0, 'D-', 10, 10, 10, 'D+', 10, 10, 10, 'D+', 10, 10, 10, 'D-', 10, 10, 10),
(947, 0, 91, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Swamp', 'Independent', 0, 'D+', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10),
(948, 0, 92, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Coastal', 'Independent', 0, 'D+', 10, 10, 10, 'D-', 10, 10, 10, 'D-', 10, 10, 10, 'D', 10, 10, 10),
(949, 0, 93, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Coastal', 'Affectionate', 0, 'D-', 10, 10, 10, 'D', 10, 10, 10, 'D+', 10, 10, 10, 'D+', 10, 10, 10),
(950, 0, 94, null, null, '', 1, '2023-09-21', 'Adult', 'Healthy', 'Coral', 'Social', 0, 'D', 10, 10, 10, 'D-', 10, 10, 10, 'D+', 10, 10, 10, 'D-', 10, 10, 10)
;

-- wild pet genomes


insert into ps_pet_genome
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values
(901, false, true, true, false, true, false, true, true, false, false, true, false, false),
(902, true, false, true, false, true, true, false, false, true, false, true, false, true),
(903, false, true, false, false, true, true, true, false, true, false, true, false, false),
(904, true, false, false, true, false, true, false, true, false, true, true, false, true),
(905, false, true, false, true, true, false, true, false, true, false, true, false, true),
(906, true, true, false, false, true, false, true, false, true, true, false, false, true),
(907, false, true, false, true, true, false, false, true, false, true, true, false, false),
(908, true, false, true, false, true, false, true, true, false, true, false, true, false),
(909, false, false, true, true, false, true, false, true, false, false, true, true, false),
(910, true, true, false, true, false, true, true, false, true, false, true, false, true),
(911, false, true, false, false, true, false, true, false, false, true, false, true, false),
(912, true, false, true, false, true, true, false, true, false, true, true, false, true),
(914, true, true, false, true, false, true, false, true, true, false, true, false, true),
(915, false, true, false, false, true, false, true, false, false, true, false, true, false),
(916, true, false, true, false, true, false, true, true, false, true, false, true, false),
(917, false, false, true, true, false, true, false, true, false, false, true, true, false),
(918, true, true, false, true, false, true, true, false, true, false, true, false, true),
(919, false, true, false, false, true, false, true, false, false, true, false, true, false),
(920, true, false, true, false, true, true, false, true, false, true, true, false, true),
(921, false, false, true, true, false, false, true, true, false, false, true, true, false),
(922, true, true, false, true, false, true, false, true, true, false, true, false, true),
(923, false, true, false, false, true, false, true, false, false, true, false, true, false),
(924, true, false, true, false, true, false, true, true, false, true, false, true, false),
(925, false, false, true, true, false, true, false, true, false, false, true, true, false),
(926, true, true, false, true, false, true, true, false, true, false, true, false, true),
(927, false, true, false, false, true, false, true, false, false, true, false, true, false),
(928, true, false, true, false, true, true, false, true, false, true, true, false, true),
(929, true, false, true, false, true, true, false, true, false, false, true, false, true),
(930, false, true, true, true, false, false, true, false, true, false, false, true, true),
(931, true, false, false, true, true, false, true, false, false, true, true, false, true),
(932, false, true, false, true, true, true, false, true, true, false, true, false, false),
(933, true, false, true, false, true, true, true, false, false, true, true, false, false),
(934, false, false, false, true, false, true, true, false, false, true, true, true, true),
(935, true, false, true, true, true, false, true, true, false, false, true, true, true),
(936, true, true, false, false, true, false, true, true, false, true, false, false, true),
(937, false, false, false, true, false, true, false, true, true, false, true, false, false),
(938, false, false, true, false, true, true, false, false, true, true, true, true, false),
(939, true, true, false, true, true, false, true, true, true, true, false, false, false),
(940, false, false, false, true, false, true, false, false, false, true, false, false, true),
(941, true, true, false, false, false, true, false, false, false, true, false, false, false),
(942, false, true, true, true, false, false, true, true, false, false, false, false, false),
(943, false, true, true, false, false, false, true, false, true, false, false, false, false),
(944, false, false, true, true, true, false, true, true, false, true, true, true, true),
(945, true, true, true, false, false, false, false, true, true, true, false, false, true),
(946, false, false, true, true, true, false, false, true, false, true, true, true, true),
(947, true, false, false, false, true, true, true, false, false, true, true, false, true),
(948, true, true, false, false, false, true, true, false, false, false, false, false, false),
(949, false, false, true, true, false, false, false, false, true, false, false, false, true),
(950, false, false, true, true, false, false, false, false, true, false, false, false, true)
;




-- ---------------------------------------------------------------------------
-- Sayings table 
insert into ps_sayings 
(category, text, emoticon)
values
('Dead', 'Unfortunately, %PET_NAME% has died of sickness.', ''),
('Critical', 'Please, I need help now, the pain is unbearable.', ''),
('Critical', 'Every breath is a struggle, I need help to make it through.', ''),
('Critical', 'I fear that without swift aid, I might not survive.', ''),
('Critical', 'I\'m in dire need of a healer\'s touch, or my spark will be extinguished.', ''),
('Critical', 'I can sense the darkness closing in, please, find a way to save me.', '')
;

insert into ps_sayings 
(category, text, emoticon)
values
('Sick', 'The enchantment that fuels me is fading, please help.', '%SICK%'),
('Sick', 'I\'m a creature of dreams, but now I\'m caught in a nightmare of sickness.', '%SICK%'),
('Sick', 'Please, lend your magic to rejuvenate my fading aura.', '%SICK%'),
('Sick', 'I\'m a creature of fantasy, but now I\'m bound by sickness.', '%SICK%'),
('Sick', 'My enchanted glow is flickering, I need your help to reignite it.', '%SICK%')
;

insert into ps_sayings 
(category, text, emoticon)
values
('Run Down', 'Ugh, can\'t a magical creature catch a break?', ''),
('Run Down', 'Why can\'t I just have a regular pet\'s life for a day?', ''),
('Run Down', 'I\'m seriously contemplating turning invisible right now.', ''),
('Run Down', 'My patience is wearing thinner than a mermaid\'s hair.', ''),
('Run Down', 'I\'m so fed up that I might just turn into a grumpy gnome.', '')
;

insert into ps_sayings 
(category, text, emoticon)
values
('Tired', 'I need a break from all these magical tricks.', ''),
('Tired', 'If only I could rest on a cloud for a while.', ''),
('Tired', 'I\'m so tired, even my sparkles are dimming.', ''),
('Tired', 'Can someone cast a spell to help me relax, please?', ''),
('Tired', 'I\'m running out of stardust and energy simultaneously.', '')
;

insert into ps_sayings 
(category, text, emoticon)
values
('Energetic', 'Come on, let\'s race to the enchanted forest and back!', ''),
('Energetic', 'Woohoo! Let\'s chase some imaginary dragons today!', ''),
('Energetic', 'I\'ve been practicing my jumps - watch this!', ''),
('Energetic', 'Bouncing around is my specialty - wanna join in?', ''),
('Energetic', 'Who needs rest? There\'s a whole realm to explore!', ''),
('Energetic', 'Ever raced a shooting star? Now\'s your chance!', ''),
('Energetic', 'Feel the wind in your hair as we race through the enchanted glade!', ''),
('Energetic', 'I\'ve been practicing my spins - want to see my whirlwind move?', ''),
('Energetic', 'Time to zigzag through the meadows and weave our energetic tale!', ''),
('Energetic', 'Let\'s be like shooting stars - swift, vibrant, and impossible to catch!', '')
;

insert into ps_sayings 
(category, text, emoticon)
values
('Protective', 'Stay behind me, I\'ll shield you from any danger.', ''),
('Protective', 'I sense something amiss; be cautious as we proceed.', ''),
('Protective', 'I won\'t let anything harm you; I\'m always by your side.', ''),
('Protective', 'Stay close, and I\'ll ensure your well-being.', ''),
('Protective', 'Feel secure; I\'m your shield in this unpredictable world.', ''),
('Protective', 'Let\'s proceed with caution; I\'m on high alert.', ''),
('Protective', 'Trust me to guard you while you sleep - no harm shall come near.', ''),
('Protective', 'Stay calm; I\'ll confront any threat that comes our way.', ''),
('Protective', 'Bravery comes naturally to me when it\'s about protecting you.', ''),
('Protective', 'Fret not; I\'m trained to detect danger from miles away.', '')
;

insert into ps_sayings 
(category, text, emoticon)
values
('Playful', 'I\'ve got a riddle for you - what\'s fluffy, fun, and full of energy? Me!', ''),
('Playful', 'Tag, you\'re it! Chase me through the meadows and let\'s laugh!', ''),
('Playful', 'Bounce with me through the forest, and let\'s make the leaves jealous!', ''),
('Playful', 'Feeling mischievous? Let\'s prank the squirrels with some friendly fun!', ''),
('Playful', 'Watch me pounce on shadows - wanna join in on the shadow-hunting?', ''),
('Playful', 'Adventure is out there, but so is the world of endless play!', ''),
('Playful', 'You bring the joy, and I\'ll bring the playfulness - it\'s a perfect match!', ''),
('Playful', 'I\'ve got a game in mind: magical hopscotch - wanna try?', ''),
('Playful', 'Let\'s roll down that hill and giggle all the way to the bottom!', ''),
('Playful', 'Let\'s dance through the enchanted woods and make the trees sway with us!', '')
;

insert into ps_sayings 
(category, text, emoticon)
values
('Affectionate', 'I love you so much, and I\'m always here for cuddles.', ''),
('Affectionate', 'Your presence brightens my day - you mean the world to me.', ''),
('Affectionate', 'Just being near you makes me feel safe and loved.', ''),
('Affectionate', 'Your touch is like a soothing spell that melts away all worries.', ''),
('Affectionate', 'When you\'re happy, I\'m happy - your joy is contagious.', ''),
('Affectionate', 'When you\'re sad, I\'m here to offer solace and love through it all.', ''),
('Affectionate', 'No matter where we go, my love for you will always follow.', ''),
('Affectionate', 'You make my world brighter, and my heart overflows with affection.', ''),
('Affectionate', 'Your happiness is my priority; I\'ll always strive to see you smile.', ''),
('Affectionate', 'With you, every moment becomes a magical tale of affection.', '')
;

insert into ps_sayings 
(category, text, emoticon)
values
('Independent', 'Adventure awaits, and I\'ll venture forth on my own path.', ''),
('Independent', 'Don\'t worry about me; I\'m quite capable of navigating this realm.', ''),
('Independent', 'I\'ll find my own food and rest spots - independence is my strength.', ''),
('Independent', 'My heart is wild, and my spirit is free - I\'ll explore this world on my terms.', ''),
('Independent', 'Trust my instincts; I\'m skilled in unraveling the mysteries of this realm.', ''),
('Independent', 'I\'ll roam the forest, forage for sustenance, and thrive independently.', ''),
('Independent', 'With every stride, I embrace the beauty of being a wanderer of the unknown.', ''),
('Independent', 'The wilderness is my playground; I\'ll roam, conquer, and return victorious.', ''),
('Independent', 'My journeys are my treasure; each step taken with the grace of self-sufficiency.', ''),
('Independent', 'My heart roams free, echoing with the song of uncharted lands.', '')
;

insert into ps_sayings 
(category, text, emoticon)
values
('Social', 'Hey there, let\'s gather the gang for a grand adventure!', ''),
('Social', 'What\'s life without friends? Let\'s seek out kindred spirits!', ''),
('Social', 'I\'ve got the scoop on all the latest happenings - want to hear?', ''),
('Social', 'It\'s not just about the destination; it\'s about the company we keep!', ''),
('Social', 'There\'s a unity in sharing tales by the firelight - who\'s joining us?', ''),
('Social', 'Meeting new creatures and making friends? Count me in!', ''),
('Social', 'Let\'s seek out gatherings where we can swap tales and forge bonds.', ''),
('Social', 'I believe in building bridges of friendship that span across all realms.', ''),
('Social', 'I believe in the magic of camaraderie - let\'s create our own legend!', ''),
('Social', 'Parties, quests, and endless joy - let\'s make our mark in the world of social wonders!', '')
;

insert into ps_sayings 
(category, text, emoticon)
values
('Curious', 'Curiosity fuels my spirit - there\'s no puzzle I won\'t attempt to solve!', ''),
('Curious', 'Let\'s unravel the secrets of the ancient ruins - every stone has a tale to tell.', ''),
('Curious', 'I wonder what lies beyond the horizon - let\'s embark on an exploration!', ''),
('Curious', 'My imagination roams free; let\'s follow its path to the unknown!', ''),
('Curious', 'I\'ve heard tales of a forgotten library in the mountains - let\'s seek its wisdom!', ''),
('Curious', 'Every scroll, every tome - they hold the keys to unlocking hidden truths.', ''),
('Curious', 'What if rainbows are bridges to distant lands? Let\'s cross one and find out!', ''),
('Curious', 'Shall we seek out the wisest sage in the realm and learn their ancient lore?', ''),
('Curious', 'I\'ve heard whispers of a forgotten garden - shall we decipher its location?', ''),
('Curious', 'My curiosity knows no bounds; I\'ll seek answers until the stars grow tired!', '')
;


insert into ps_sayings 
(category, text, emoticon)
values
('Calm', 'The world may be full of chaos, but we can find tranquility within.', ''),
('Calm', 'Amidst the storms of life, I\'ll be your anchor of serenity.', ''),
('Calm', 'There\'s beauty in the stillness of the world - let\'s savor it together.', ''),
('Calm', 'The path to wisdom begins with a heart that\'s at peace.', ''),
('Calm', 'Our bond is a haven of tranquility amidst the whirlwind of life.', ''),
('Calm', 'The world may spin with magic, but within us lies the magic of inner peace.', ''),
('Calm', 'In the midst of change, our calm presence can be a beacon of stability.', ''),
('Calm', 'As we explore this realm, I\'ll remind you to keep your mind as calm as the sky.', ''),
('Calm', 'The key to unlocking the magic of this world lies in finding peace within.', ''),
('Calm', 'Our journey is as much about exploring the depths of our souls as the fantasy realms.', '')
;

insert into ps_sayings 
(category, text, emoticon)
values
('Mischievous', 'Watch as I rearrange the forest creatures\' homes for a bit of whimsy!', ''),
('Mischievous', 'Shall we sneak up on the wizards and give them a taste of their own magic?', ''),
('Mischievous', 'I\'ve got a prank in mind that will leave everyone laughing - are you in?', ''),
('Mischievous', 'I heard the talking trees are having a secret meeting - shall we eavesdrop?', ''),
('Mischievous', 'Shall we fill the castle moat with rainbow-colored water? It\'s mischief time!', ''),
('Mischievous', 'Let\'s play hide and seek with the forest creatures - they\'re in for a surprise!', ''),
('Mischievous', 'I\'ve got an idea for a magic show that will leave everyone bewildered and amused.', ''),
('Mischievous', 'I\'ve befriended the castle ghosts - they\'re up for a hauntingly funny time!', ''),
('Mischievous', 'The mermaids in the enchanted lake could use a bit of seaweed styling!', ''),
('Mischievous', 'The enchanted flowers are due for a bit of a tickling - care to join in?', '')
;

insert into ps_sayings 
(category, text, emoticon)
values
('Loyal', 'No matter the quest, adventure, or challenge, I\'m here by your side.', ''),
('Loyal', 'Through the magic and mysteries of this world, my loyalty to you remains unwavering.', ''),
('Loyal', 'Wherever you go, I\'ll follow - for you are my true north.', ''),
('Loyal', 'In a world of enchantment, my loyalty to you is the strongest bond.', ''),
('Loyal', 'I\'ll stand guard in the darkest of forests and the brightest of sunlit fields.', ''),
('Loyal', 'Trust in my loyalty, for it\'s a treasure I hold dear in the depths of my heart.', ''),
('Loyal', 'Wherever destiny leads, my loyalty is the compass that guides me to you.', ''),
('Loyal', 'No spell or charm can sever the bond of loyalty between us.', ''),
('Loyal', 'Your dreams are my mission, and your happiness is my ultimate quest.', ''),
('Loyal', 'I\'ll weather every storm and bask in every triumph, for my loyalty is forever.', '')
;


insert into ps_sayings 
(category, text, emoticon)
values
('Shy', 'Um, hi there. I, um, hope we can be friends.', ''),
('Shy', 'If it\'s okay, maybe we could, um, explore that enchanted forest together?', ''),
('Shy', 'I don\'t mean to be a bother, but, um, could we perhaps go on a quest?', ''),
('Shy', 'I noticed a really colorful bird earlier. It\'s quite beautiful.', ''),
('Shy', 'I hope it\'s okay to say this, but I\'m really grateful for your friendship.', ''),
('Shy', 'I brought this pretty flower. I thought you might like it.', ''),
('Shy', 'It\'s quiet here. I kind of like that - less people, you know?', ''),
('Shy', 'I enjoy our conversations. You make me feel at ease.', ''),
('Shy', 'I appreciate your patience with me. It means a lot.', ''),
('Shy', 'I hope you don\'t mind if I tag along on your adventures.', '')
;

insert into ps_sayings 
(category, text, emoticon)
values
('Fearless', 'Adventure beckons, and I\'m ready to charge ahead!', ''),
('Fearless', 'With every swing of my sword, fear crumbles and courage rises.', ''),
('Fearless', 'The shadows may lurk, but my fearless light will always shine brighter.', ''),
('Fearless', 'Dangerous quest ahead? Count me in - courage doesn\'t back down!', ''),
('Fearless', 'No dungeon is too dark, no labyrinth too complex - I\'ll find a way through.', ''),
('Fearless', 'Challenges are simply stepping stones to victory - watch me overcome them all!', ''),
('Fearless', 'No sorcery can weaken my resolve - I\'m a force to be reckoned with.', ''),
('Fearless', 'Let\'s dive into the heart of darkness and emerge victorious!', ''),
('Fearless', 'Let\'s venture where others fear to tread and create our own destiny.', ''),
('Fearless', 'In the face of danger, I\'ll be the light that guides us through the shadows.', '')
;

insert into ps_sayings
(category, text, emoticon)
values
('Forage', 'I want to wrap this food up in a hug and never let go!', ''),
('Forage', 'I bet even fairies would trade their wings for a taste of this!', ''),
('Forage', 'I\'m savoring the taste of giggles and grins in every bite!', ''),
('Forage', 'Who needs fairy dust when you have food this fantastic?', ''),
('Forage', 'I could eat this while floating on a cloud of marshmallow dreams!', ''),
('Forage', 'Is it possible for food to be adorable? Because this is!', ''),
('Forage', 'A dish so delightful, it must have been whisked up by giggling imps!', ''),
('Forage', 'My tummy thinks this food is straight out of a fairy tale!', ''),
('Forage', 'This dish is like a spell that turns hunger into smiles!', ''),
('Forage', 'I\'m in fluffy cloud heaven with every nibble!', '')
;

insert into ps_sayings
(category, text, emoticon)
values
('Train', 'I did it, I did it! Can I have a treat now, pretty please?', ''),
('Train', 'I learned new things today, and I\'m ready to show off!', ''),
('Train', 'I practiced and practiced, and now I\'m a pro at this!', ''),
('Train', 'Tiny steps, big leaps! Training is my special adventure!', ''),
('Train', 'Training was like a puzzle, and I just put the pieces together!', ''),
('Train', 'I earned my treats with all the hard work I put into training!', ''),
('Train', 'Training was tough, but so am I! I conquered it!', ''),
('Train', 'Can I have a training trophy? I\'m feeling extra adorable!', ''),
('Train', 'Training: complete! Now I\'m all ears for your praise!', ''),
('Train', 'I learned, practiced, and conquered - I\'m your super companion!', '')
;



insert into ps_sayings
(category, text, emoticon)
values
('Quest', 'I\'m back from my grand adventure, and I brought extra cuddles!', ''),
('Quest', 'Quest complete! Now I\'m ready for a heroic nap.', ''),
('Quest', 'I returned from the quest with pockets full of magical memories!', ''),
('Quest', 'I\'m a little explorer with a heart full of tales!', ''),
('Quest', 'Home from my adventure, ready to share stories and snuggles!', ''),
('Quest', 'My heart is full of courage and cuddles after that grand quest!', ''),
('Quest', 'I braved the unknown, and now I\'m here for epic snuggles!', ''),
('Quest', 'I brought back joy from my adventure, and I\'m sharing it with you!', ''),
('Quest', 'Adventure called, and I answered with boundless cuddles!', ''),
('Quest', 'Quest complete, and I\'m trading my sword for a snuggle!', '')
;

insert into ps_sayings
(category, text, emoticon)
values
('Rest', 'Mmm, that nap was snugglelicious!', ''),
('Rest', 'I\'m as refreshed as a morning sunbeam!', ''),
('Rest', 'Ready to flutter through enchanted gardens today!', ''),
('Rest', 'New day, new chances for adorable adventures!', ''),
('Rest', 'My slumber was as sweet as a pixie''s lullaby!', ''),
('Rest', 'Time to embark on a fluffy journey of wonder!', ''),
('Rest', 'Time to greet the day with a snuggle and a nose boop!', ''),
('Rest', 'Rising from slumber like a mischievous pixie sprite!', ''),
('Rest', 'Restful slumber for a pet of legendary cuddliness!', ''),
('Rest', 'Dreamt of dancing on stars and riding moonbeams!', '')
;


-- ----------------------------------------------------------------
-- generic genetics 

insert into ps_pet_gene
(gene_name, min_gvalue, max_gvalue, mutation_rate)
values
('constitution', 5, 500, 0.10),
('strength', 5, 500, 0.10),
('agility', 5, 500, 0.10),

('charm', 5, 500, 0.10),
('confidence', 5, 500, 0.10),
('empathy', 5, 500, 0.10),

('intelligence', 5, 500, 0.10),
('wisdom', 5, 500, 0.10),
('sorcery', 5, 500, 0.10),

('loyalty', 5, 500, 0.10),
('spirituality', 5, 500, 0.10),
('karma', 5, 500, 0.10),

('personality', 1, 12, 0.10)
;

-- ------------------------------------
insert into ps_log
(process, message)
values
('panda_pet_data.sql', 'run script');

set foreign_key_checks = 1;
