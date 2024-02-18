-- ------------------------------------------------------------------
-- Pandemonium pet system upgrades
--

-- ----------------------------------------------------------
-- 27-Oct-2023
-- add the hud version column to the avatar information table.
-- used to track HUD versions.
alter table ps_avatar_info add column if not exists hud_version varchar (64) null;

-- insert into ps_version (version, message)
-- select '1.0.0.9', ' add column to ps_avatar_info table' from dual
-- where (select count (*) from information_schema.columns where table_name = 'ps_avatar_info' and column_name = 'hud_version');

-- ------------------------------------------------------------------
-- 14-Nov-2023
-- add grade column to ps_quest_def table
alter table ps_quest_def add column if not exists grade varchar (30) null;

update ps_quest_def set grade = 'Common' where id = 1;
update ps_quest_def set grade = 'Common' where id = 2;
update ps_quest_def set grade = 'Common' where id = 3;
update ps_quest_def set grade = 'Common' where id = 4;
update ps_quest_def set grade = 'System' where id = 5;
update ps_quest_def set grade = 'System' where id = 6;
update ps_quest_def set grade = 'System' where id = 7;


-- ------------------------------------------------------------------
-- 15-Nov-2023
-- add avatar name column to ps_avatar_info table
alter table ps_avatar_info add column if not exists avname varchar (128) null;


-- ------------------------------------------------------------------
-- 14-Jan-2024
-- make the quest choice columns bigger
alter table ps_quest_choice modify choice_1 varchar(120);
alter table ps_quest_choice modify choice_2 varchar(120);
alter table ps_quest_choice modify choice_3 varchar(120);
alter table ps_quest_choice modify choice_4 varchar(120);
alter table ps_quest_choice modify choice_5 varchar(120);

alter table ps_quest_choice modify column type enum ('choice', 'ask') default 'choice';

-- --------------------------------------------------------
-- 01-Feb-2024
-- add enabled flag to pet table.
alter table ps_player_pet add column if not exists enabled boolean default true not null;

alter table ps_player_pet add column if not exists notes varchar (1000) null;


-- ------------------------------------------------------
-- 6-Feb-2023
-- add email column for alternate login use
alter table ps_avatar_info add column if not exists email varchar (320) null;


-- --------------------------------------------------------
-- refresh Main owner view
create or replace view ps_avatar_info_view
as select
    ai.*,
    (select count(*) from ps_player_pet p1 where p1.avuuid = ai.avuuid) as total_pets
from ps_avatar_info ai
;


-- ---------------------------------------------------
-- refresh main pet view
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



-- --------------------------------------------------
insert into ps_log (process, message) values ('pet_system_upgrade.sql', 'run script');

