-- ------------------------------------------------------------------
-- Pandemonium pet system tables
--
--
--  mysql --host=localhost --user=pandemonium --password=panda4$ pandemonium_db
--



set foreign_key_checks = 0;

-- drop tables (in a safe order)
drop view if exists ps_avatar_info_view;
drop view if exists ps_player_pet_view;

-- general tables
drop table if exists ps_pet_gene;
drop table if exists ps_avatar_activity;
drop table if exists ps_wild_pets;
drop table if exists ps_pet;
drop table if exists ps_attribute_names;
drop table if exists ps_sayings;

-- quest tables
drop table if exists ps_stat_test;
drop table if exists ps_stat_cost;
drop table if exists ps_quest_choice;
drop table if exists ps_quest_action;
drop table if exists ps_quest_def;

-- more general tables
drop table if exists ps_habitat;
drop table if exists ps_rank_tier;
drop table if exists ps_food_cost;
drop table if exists ps_train_cost;
drop table if exists ps_food_info;
drop table if exists ps_train_info;
drop table if exists ps_food_stat;
drop table if exists ps_train_stat;

drop table if exists ps_grade;

drop table if exists ps_personality_info;
drop table if exists ps_attribute_habitat;
drop table if exists ps_attribute;
drop table if exists ps_settings;
drop table if exists ps_log;
drop table if exists ps_version;

-- drop user if exists pand_pet@localhost;


-- --------------------------------------------------------
-- Version information
create table if not exists ps_version
(
	id bigint auto_increment,
	version varchar (30),
	message varchar (512),
	update_time timestamp(6) default current_timestamp(),
	
	primary key (id)
);
insert into ps_version (version, message) values ('1.0.0.1', '- initial database creation via script.');
insert into ps_version (version, message) values ('1.0.0.2', '- revise quest tables');
insert into ps_version (version, message) values ('1.0.0.3', '- add wilds pets');
insert into ps_version (version, message) values ('1.0.0.4', '- add genetics to db structure');
insert into ps_version (version, message) values ('1.0.0.5', '- update habitat sn add partner tables');
insert into ps_version (version, message) values ('1.0.0.6', '- updates to habitat location table');
insert into ps_version (version, message) values ('1.0.0.7', '- updates to ps_sayings table to add emoticon');
insert into ps_version (version, message) values ('1.0.0.8', '- add settings table');


-- ----------------------------------------------------------
-- Log file to track Misc updates
create table if not exists ps_log
(
	id bigint auto_increment,
	process varchar (30),
	message varchar (512),
	update_time timestamp(6) default current_timestamp(),
	
	primary key (id)
);



-- ----------------------------------------------------------
-- Misc settings table
create table if not exists ps_settings
(
	keyName varchar (30),
	keyValue varchar (512),
	update_time timestamp(6) default current_timestamp on update current_timestamp,

	primary key (keyName)
);






-- ------------------------------------------------------------
-- pet attribute information

create table if not exists ps_attribute
(
	attribute varchar (30), 
	color varchar (30), -- rgb color value in #rrggbb format
	texture varchar (512), -- texture name for frame accent
	
	primary key (attribute), 
	constraint psattr_color_uk unique (color)
);


-- -----------------------------------------------------------
-- attribute to habitat mapping
create table if not exists ps_attribute_habitat
(
	id bigint auto_increment,
	attribute varchar (30),
	habitat varchar (30),
	
	primary key (id),
	constraint pah_attribute_nl check (attribute is not null),
	constraint pah_habitat_nl check (habitat is not null)
	
);
alter table ps_attribute_habitat auto_increment = 1001;



-- -------------------------------------------------------------
-- Grade information

create table if not exists ps_grade
(
	rarity	varchar (30),
	code varchar (1),
	min_value varchar (2),
	max_value varchar (2),
	
	primary key (rarity)
);



-- -------------------------------------------------------------
-- rank tier data (max stat)
create table if not exists ps_rank_tier
(
	rank_tier varchar (2),
	max_stat int,
	
	primary key (rank_tier)
);

-- ------------------------------------------------------------
-- training cost and stat bonuses
--
create table if not exists ps_train_info
(
	id bigint auto_increment,
	type varchar (30),
	cost int,
	texture varchar(512),
	constitution int,
	strength int,
	agility int,
	charm int,
	confidence int,
	empathy int,
	intelligence int,
	wisdom int,
	sorcery int,
	loyalty int,
	spirituality int,
	karma int,
	fatigue int,
	
	primary key (id),
	constraint pstrain_type_nl check (type is not null),
	constraint pstrain_type_uk unique (type)
);
alter table ps_train_info auto_increment = 1001;




-- ------------------------------------------------------------
-- food stats and cost
--
create table if not exists ps_food_info
(
	id bigint auto_increment,
	type varchar (30),
	cost int,
	action_points int,
	texture varchar(512),
	req_fitness int,
	req_wizardry int,
	req_charisma int,
	req_nature int,
	constitution int,
	strength int,
	agility int,
	charm int,
	confidence int,
	empathy int,
	intelligence int,
	wisdom int,
	sorcery int,
	loyalty int,
	spirituality int,
	karma int,
	fatigue int,

	primary key (id),
	constraint psfc_type_nl check (type is not null),
	constraint psfc_type_uk unique (type),
	constraint psfc_texture_nl check (texture is not null)
);
alter table ps_food_info auto_increment = 1001;



-- -----------------------------------------------------------
-- habitat base information
create table if not exists ps_habitat
(
	id bigint auto_increment,
	habitat varchar (30) not null unique,
	texture varchar (512) not null unique,

	primary key (id)
);
alter table ps_habitat auto_increment = 1001;


-- -----------------------------------------------------------
-- ps_habitat_location
--
create table if not exists ps_habitat_location
(
    id bigint auto_increment,
    registration_id varchar (100) not null,
	name varchar (50) not null,
	type enum ('dispenser', 'affiliate', 'partner', 'universal') not null,
    habitat enum ('Alpine', 'Autumnal', 'Blossom', 'Cave', 'Coastal', 'Coral', 'Desert', 'Glacier', 'Graveyard', 'Heaven', 'Hell', 'Meadow', 'Rainforest', 'Swamp)', 'Tundra', 'Village', 'Volcano') not null,
    region_name varchar (30) not null,  -- second life region name
    region_coord varchar (45) not null, -- region coordinate in text  i.e.  <xxx.xxxxxxx, yyy.yyyyyyyyyy, zzz.zzzzzzzz>
	area varchar (45) not null,  -- 6 comma delimited integers
	parcel_id varchar (36) not null, -- parcel id
	texture_id varchar (36) not null,  -- texture uuid for advertising
	dispenser_version varchar (25), -- dispenser version number
    sl_value bigint null, -- SL update value
	update_time timestamp(6) default current_timestamp on update current_timestamp,

    primary key (id),
    constraint phl_reg_name_uk unique (registration_id, name)
);
alter table ps_habitat_location auto_increment = 1001;


-- -------------------------------------------
-- partner information
create table if not exists ps_partner
(
    id bigint auto_increment primary key, -- auto assigned id for the record
    registration_id varchar (100) not null unique, -- assigned registration number
    name varchar (50)  null, -- name of location
    region_name varchar (30)  null,  -- second life region name
    landing_coord varchar (45) null, -- region coordinate in text  i.e.  <xxx.xxxxxxx, yyy.yyyyyyyyyy, zzz.zzzzzzzz>
    parcel_id varchar (36) null, -- parcel id
	texture_id varchar (36) null,  -- texture uuid for advertising
	default_habitat enum ('Alpine', 'Autumnal', 'Blossom', 'Cave', 'Coastal', 'Coral', 'Desert', 'Glacier', 'Graveyard', 'Heaven', 'Hell', 'Meadow', 'Rainforest', 'Swamp)', 'Tundra', 'Village', 'Volcano') null,

    update_time timestamp(6) default current_timestamp on update current_timestamp
);



-- -------------------------------------------------------------
-- Attribute names
create table if not exists ps_attribute_names 
(
	id bigint auto_increment,
	category varchar (30),
	color varchar (30),
	name varchar (30),
	
	primary key (id)
);
alter table ps_attribute_names auto_increment = 1001;



-- ---------------------------------------------
-- 
create table if not exists ps_quest_def
(
	id bigint,
    enabled boolean default false,  -- is the quest active or not
	type enum ('Monster', 'Event', 'Puzzle', 'Encounter', 'Forage', 'Train', 'Rest' ) not null,  -- what type of quest is this?
    text  varchar (350), -- description of the quest
    texture varchar(512), -- pic of the quest
	next_action varchar (30), -- name of the action / choice to perform next
    grade varchar (30), -- difficulty grade for quest
	update_time timestamp(6) default current_timestamp on update current_timestamp,
        
    primary key (id),
    constraint psqu_text_nl check (text is not null),
    constraint psqu_enable_nl check (enabled is not null),
	constraint psqu_action_nl check (next_action is not null),
    constraint psqu_texture_nl check (texture is not null)
); 


-- -----------------------------------------------
-- 
create table if not exists ps_quest_choice
(
	id bigint auto_increment,
	quest_id bigint, -- FK to the quest this choice belongs to
	action varchar (30),  -- name of the choice / action
	type enum ('choice', 'ask') default 'choice',
	choice_count int default 0,  -- how many choices are defined to be used.
	text varchar (350), -- text to display to the player
	texture varchar(512),  -- background texture to display during this choice
	face_img varchar (512) null, -- face image code
	emote_img varchar(512) null, -- emoticon image code

	quest_done int default 0,
	action_cmd varchar (30) null, 
	action_cost varchar (30) null,
	action_test varchar (30) null,
	
	choice_1 varchar(120),
	choice_2 varchar(120),
	choice_3 varchar(120),
	choice_4 varchar(120),
	choice_5 varchar(120),
	
	action_1 varchar(30),
	action_2 varchar(30),
	action_3 varchar(30),
	action_4 varchar(30),
	action_5 varchar(30),

	update_time timestamp(6) default current_timestamp on update current_timestamp,
			
	primary key (id),
	constraint psqco_action_nl check (action is not null),
	constraint psqco_quest_fk foreign key (quest_id) references ps_quest_def(id) on delete set null,
	constraint psqco_quest_action_uk unique (quest_id, action)
);
alter table ps_quest_choice auto_increment = 1001;




create table if not exists ps_stat_cost
(
	id bigint auto_increment,
	quest_id bigint, 
	action varchar (30),
	
	constitution varchar (120) default 0,
	strength varchar (120) default 0,
	agility varchar (120) default 0,
	charm varchar (120) default 0,
	confidence varchar (120) default 0,
	empathy varchar (120) default 0,
	intelligence varchar (120) default 0,
	wisdom varchar (120) default 0,
	sorcery varchar (120) default 0,
	loyalty varchar (120) default 0,
	spirituality varchar (120) default 0,
	karma varchar (120) default 0,
	fatigue varchar (120) default 0,
	food varchar (120) default 0,

	update_time timestamp(6) default current_timestamp on update current_timestamp,
	
	primary key (id),
	constraint pssc_action_nl check (action is not null),
	constraint pssc_quest_fk foreign key (quest_id) references ps_quest_def(id) on delete set null
);
alter table ps_stat_cost auto_increment = 1001;


create table if not exists ps_stat_test
(
	id bigint auto_increment,
	quest_id bigint, 
	action varchar (30),
	win_action varchar (30),
	lose_action varchar (30),
	
	constitution varchar (120) default 0,
	strength varchar (120) default 0,
	agility varchar (120) default 0,
	charm varchar (120) default 0,
	confidence varchar (120) default 0,
	empathy varchar (120) default 0,
	intelligence varchar (120) default 0,
	wisdom varchar (120) default 0,
	sorcery varchar (120) default 0,
	loyalty varchar (120) default 0,
	spirituality varchar (120) default 0,
	karma varchar (120) default 0,

	update_time timestamp(6) default current_timestamp on update current_timestamp,
	
	primary key (id),
	constraint psst_action_nl check (action is not null),
	constraint psst_quest_fk foreign key (quest_id) references ps_quest_def(id) on delete set null
);
alter table ps_stat_test auto_increment = 1001;



-- ---------------------------------------------------------------------
-- static information for each pet type.  
-- this is a partial template for each pet in the system, 
-- one record pet pet type and owner type.  
create table if not exists ps_pet 
(
    id bigint auto_increment,  -- pet id, main id for the pet
    species varchar (30), -- type of pet / species name 
    owner_type enum ('any', 'staff'), -- who can own this pet.  e.g any, staff, ...
    texture varchar (512), -- texture for pet picture
    face_texture varchar (512), -- face portrait
	color varchar (30), -- RGB vector for the pet attribute in #RRGGBB format
	attribute_texture varchar(512), -- texture for frame accent
	grade varchar (30),  -- pet grade (see ps_grade rarity column)
	attribute_name varchar (30), -- pet attribute  see ps_attribute_names
	update_time timestamp(6) default current_timestamp on update current_timestamp,
            
    -- constraints for the table columns 
    primary key (id),
	constraint pet_species_nl unique (species),
    constraint pet_owntype_nl check (owner_type is not null)
);

alter table ps_pet auto_increment = 1001;
create index pet_tex_idx on ps_pet (texture);


-- instance of an actual pet.  it is associated with a player
create table if not exists ps_player_pet
(
    -- association of pet and player
	id bigint auto_increment,  -- primary key
	pet_number int default 0,  -- on insert (select max(pp.put_number) from ps_player_pet pp where pp.avuuid = avuuid),
    enabled boolean default true not null,
    type enum ('normal', 'staff', 'special') default 'normal' not null,
	update_date timestamp(6) default current_timestamp on update current_timestamp,
    pet_id bigint,  -- fk to pet id
    parent_a bigint null,
    parent_b bigint null, 
    avuuid char(36) null, -- player id
    is_wild boolean default false not null,
    notes varchar (1000) null,

    -- pet attributes
	birth_date date default current_date, -- birth date 
    age int as (datediff (current_date, birth_date)),  -- age in days old from birth date
    stage enum ('Adult', 'Senior', 'Dead'),
    health enum ('Healthy', 'Dead', 'Critical', 'Sick', 'Run Down', 'Tired'), 
    habitat varchar (40), -- random based on attribute
    personality varchar (60), -- random at creation time
            
    -- fatigue
    fatigue int default 0,
            
    -- pet fitness
	fitness_rank_tier varchar (2),  -- fk to rank_tier
	fitness int as (constitution + strength + agility),
    constitution int default 0,
    strength int default 0,
    agility int default 0, 
    
    -- pet wizardry
	wizardry_rank_tier varchar (2),  -- fk to rank_tier
    wizardry int as (intelligence + wisdom + sorcery),
    intelligence int default 0, 
    wisdom int default 0,
    sorcery int default 0,
    
    -- pet charisma
	charisma_rank_tier varchar (2),  -- fk to rank_tier
    charisma int as (charm + confidence + empathy),
    charm int default 0, 
    confidence int default 0,
    empathy int default 0,
    
    -- pet nature
	nature_rank_tier varchar (2),  -- fk to rank_tier
    nature int as (loyalty + spirituality + karma),
    loyalty int default 0,
    spirituality int default 0,
    karma int default 0,

    primary key (id),	
    constraint playpet_pet_id_fk foreign key (pet_id) references ps_pet(id),
    constraint playpet_parenta_fk foreign key (parent_a) references ps_player_pet(id) on delete set null,
    constraint playpet_patentb_fk foreign key (parent_b) references ps_player_pet(id) on delete set null,
    constraint playpet_fit_rank_fk foreign key (fitness_rank_tier) references ps_rank_tier(rank_tier),
    constraint playpet_wizard_rank_fk foreign key (wizardry_rank_tier) references ps_rank_tier(rank_tier),
    constraint playpet_charisma_rank_fk foreign key (charisma_rank_tier) references ps_rank_tier(rank_tier),
    constraint playpet_nature_rank_fk foreign key (nature_rank_tier) references ps_rank_tier(rank_tier),
    
    constraint playper_personality_nl check (personality is not null)
);
alter table ps_player_pet auto_increment = 1001; 


-- -----------------------------------------
-- Pet activity records
--
create table if not exists ps_pet_activity
(
    id bigint auto_increment,
    pet_id bigint,
    activity varchar (45),
    activity_date timestamp(6) default current_timestamp on update current_timestamp,
    
    primary key (id),
	constraint petact_pet_id_fk foreign key (pet_id) references ps_player_pet(id) on delete cascade,
    constraint petact_pet_id_nl check (pet_id is not null),
    constraint petact_act_nl check (activity is not null),
    constraint petact_acttime_nl check (activity_date is not null),
	
	index petact_act_idx (activity)
);
alter table ps_pet_activity auto_increment = 1001; 





-- --------------------------------------------------------
-- track when an avatar uses the hud by inserting a activity time 
-- into a small record. 

create table if not exists ps_avatar_info 
(
    id bigint auto_increment,
    avuuid varchar (36),
    avname varchar (128),
    email varchar (320) null,
    food int default 0,
    action_points int default 0,
    activity_time date default current_date(),
    region varchar (64) null,
    coord varchar (64) null,
    hud_version varchar (64) null,
    parcel_id varchar (36) null,
    prim_url varchar (2000) null,
    update_time timestamp(6) default current_timestamp() on update current_timestamp(),
    primary key (id),
    constraint paa_uuid_nl check (avuuid is not null),
    constraint paa_uuid_uk unique (avuuid)
    
);
alter table ps_avatar_info auto_increment = 1001;



-- --------------------------------------------------------
-- Main pet view (has denormalized and calculated data)

create or replace view ps_player_pet_view
as select 
    pp.*, 
    p.texture as pet_texture,
    p.face_texture as face_texture,
    p.color as attribute_color,
    p.grade as grade, 
    p.species as species,
    (select p3.attribute_name from ps_pet p3 where p3.id = pp.pet_id) as attribute,
    (select p4.attribute_texture from ps_pet p4 where p4.id = pp.pet_id) as attribute_texture,
    (select rt1.max_stat from ps_rank_tier rt1 where rt1.rank_tier = pp.fitness_rank_tier) as fitness_max,
    (select rt1.max_stat from ps_rank_tier rt1 where rt1.rank_tier = pp.wizardry_rank_tier) as wizardry_max,
    (select rt1.max_stat from ps_rank_tier rt1 where rt1.rank_tier = pp.charisma_rank_tier) as charisma_max,
    (select rt1.max_stat from ps_rank_tier rt1 where rt1.rank_tier = pp.nature_rank_tier) as nature_max,
    (select count(*) from ps_pet_activity pa where pa.pet_id = id and pa.activity = 'Forage') as forage_count,
    (select count(*) from ps_pet_activity p1 where p1.pet_id = id and p1.activity = 'Train') as train_count,
    (select count(*) from ps_pet_activity p2 where p2.pet_id = id and p2.activity = 'Breed') as breeding_count,
    (select count(*) from ps_pet_activity pa where pa.pet_id = id and pa.activity != 'Train' and pa.activity != 'Forage' and pa.activity != 'Breed') as encounter_count
from ps_player_pet pp
inner join ps_pet p on pp.pet_id = p.id
; 



-- --------------------------------------------------------
-- Main owner view (has denormalized and calculated data)

create or replace view ps_avatar_info_view
as select 
    ai.*, 
    (select count(*) from ps_player_pet p1 where p1.avuuid = ai.avuuid) as total_pets
from ps_avatar_info ai
; 



-- ---------------------------------------------------------------------
-- saying table organized by category
create table if not exists ps_sayings
(
    id bigint auto_increment,
    category varchar (45) not null,
    text varchar (350) not null,
    emoticon varchar(512) null,
    
    primary key (id),
    constraint psay_cat_txt_uk unique (category, text)
);
alter table ps_sayings auto_increment = 1001;
create index psay_cat_idx on ps_sayings (category);


-- ----------------------------------------------------------------------
-- pet gene
drop table if exists ps_pet_gene;


create table if not exists ps_pet_gene
(
    gene_name varchar(35) primary key not null, 
    min_gvalue int not null,
    max_gvalue int not null,
    mutation_rate decimal (5, 3) not null
);


-- ------------------------------------------------------
-- pet genome

drop table if exists ps_pet_genome;

create table if not exists ps_pet_genome
(
    pet_id bigint primary key not null,
    constitution_dominant bit not null, 
    strength_dominant bit not null, 
    agility_dominant bit not null, 
    charm_dominant bit not null, 
    confidence_dominant bit not null, 
    empathy_dominant bit not null, 
    intelligence_dominant bit not null, 
    wisdom_dominant bit not null, 
    sorcery_dominant bit not null, 
    loyalty_dominant bit not null, 
    spirituality_dominant bit not null, 
    karma_dominant bit not null, 
    personality_dominant bit not null,
    update_time timestamp(6) default current_timestamp() on update current_timestamp(),
    
    constraint pgenome_pet_id_fk foreign key (pet_id) references ps_player_pet(id) on delete cascade
);


-- --------------------------------------------------------
-- 

create or replace view ps_pet_genome_view
as select 
    p.id,
    
    (select min_gvalue from ps_pet_gene where gene_name = 'fitness') as fit_min_value,
    (select max_gvalue from ps_pet_gene where gene_name = 'fitness') as fit_max_value,
    (select mutation_rate from ps_pet_gene where gene_name = 'fitness') as fit_mutation_rate,
    
    (select min_gvalue from ps_pet_gene where gene_name = 'charisma') as chr_min_value,
    (select max_gvalue from ps_pet_gene where gene_name = 'charisma') as chr_max_value,
    (select mutation_rate from ps_pet_gene where gene_name = 'charisma') as chr_mutation_rate,
    
    (select min_gvalue from ps_pet_gene where gene_name = 'wizardry') as wiz_min_value,
    (select max_gvalue from ps_pet_gene where gene_name = 'wizardry') as wiz_max_value,
    (select mutation_rate from ps_pet_gene where gene_name = 'wizardry') as wiz_mutation_rate,
    
    (select min_gvalue from ps_pet_gene where gene_name = 'nature') as nat_min_value,
    (select max_gvalue from ps_pet_gene where gene_name = 'nature') as nat_max_value,
    (select mutation_rate from ps_pet_gene where gene_name = 'nature') as nat_mutation_rate,
  
    (select min_gvalue from ps_pet_gene where gene_name = 'constitution') as con_min_value,
    (select min_gvalue from ps_pet_gene where gene_name = 'strength') as str_min_value,
    (select min_gvalue from ps_pet_gene where gene_name = 'agility') as agi_min_value,
    (select min_gvalue from ps_pet_gene where gene_name = 'charm') as cha_min_value, 
    (select min_gvalue from ps_pet_gene where gene_name = 'confidence') as cfd_min_value,
    (select min_gvalue from ps_pet_gene where gene_name = 'empathy') as emp_min_value,
    (select min_gvalue from ps_pet_gene where gene_name = 'intelligence') as int_min_value,
    (select min_gvalue from ps_pet_gene where gene_name = 'wisdom') as wis_min_value,
    (select min_gvalue from ps_pet_gene where gene_name = 'sorcery') as src_min_value,
    (select min_gvalue from ps_pet_gene where gene_name = 'loyalty') as loy_min_value,
    (select min_gvalue from ps_pet_gene where gene_name = 'spirituality') as spr_min_value,
    (select min_gvalue from ps_pet_gene where gene_name = 'karma') as kar_min_value,
        
    (select max_gvalue from ps_pet_gene where gene_name = 'constitution') as con_max_value,
    (select max_gvalue from ps_pet_gene where gene_name = 'strength') as str_max_value,
    (select max_gvalue from ps_pet_gene where gene_name = 'agility') as agi_max_value,
    (select max_gvalue from ps_pet_gene where gene_name = 'charm') as cha_max_value, 
    (select max_gvalue from ps_pet_gene where gene_name = 'confidence') as cfd_max_value,
    (select max_gvalue from ps_pet_gene where gene_name = 'empathy') as emp_max_value,
    (select max_gvalue from ps_pet_gene where gene_name = 'intelligence') as int_max_value,
    (select max_gvalue from ps_pet_gene where gene_name = 'wisdom') as wis_max_value,
    (select max_gvalue from ps_pet_gene where gene_name = 'sorcery') as src_max_value,
    (select max_gvalue from ps_pet_gene where gene_name = 'loyalty') as loy_max_value,
    (select max_gvalue from ps_pet_gene where gene_name = 'spirituality') as spr_max_value,
    (select max_gvalue from ps_pet_gene where gene_name = 'karma') as kar_max_value,
    
    (select mutation_rate from ps_pet_gene where gene_name = 'constitution') as con_mutation_rate,
    (select mutation_rate from ps_pet_gene where gene_name = 'strength') as str_mutation_rate,
    (select mutation_rate from ps_pet_gene where gene_name = 'agility') as agi_mutation_rate,
    (select mutation_rate from ps_pet_gene where gene_name = 'charm') as cha_mutation_rate, 
    (select mutation_rate from ps_pet_gene where gene_name = 'confidence') as cfd_mutation_rate,
    (select mutation_rate from ps_pet_gene where gene_name = 'empathy') as emp_mutation_rate,
    (select mutation_rate from ps_pet_gene where gene_name = 'intelligence') as int_mutation_rate,
    (select mutation_rate from ps_pet_gene where gene_name = 'wisdom') as wis_mutation_rate,
    (select mutation_rate from ps_pet_gene where gene_name = 'sorcery') as src_mutation_rate,
    (select mutation_rate from ps_pet_gene where gene_name = 'loyalty') as loy_mutation_rate,
    (select mutation_rate from ps_pet_gene where gene_name = 'spirituality') as spr_mutation_rate,
    (select mutation_rate from ps_pet_gene where gene_name = 'karma') as kar_mutation_rate,
    
    g.*
from ps_player_pet p
inner join ps_pet_genome g on g.pet_id = p.id
; 



insert into ps_log
(process, message)
values
('pet_system.sql', 'run script');

