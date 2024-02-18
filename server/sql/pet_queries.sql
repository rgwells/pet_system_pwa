
-- pet detail query
select 
    pp.*, 
    p.texture as pet_texture,
    p.color as attribute_color,
    p.attribute_name as attribute_name,
    p.grade as grade
from ps_player_pet pp
inner join ps_pet p on pp.pet_id = p.id
; 



-- count of pets for player
select count(*) as pet_count 
from ps_player_pet 
where avuuid = '06340496-1003-4399-a131-84bbc321dc87';


-- count of pets for player filtered
select count(*) as pet_count 
from ps_player_pet_view
where avuuid = '06340496-1003-4399-a131-84bbc321dc87' and attribute = 'Plant'
;


-- pet list for player (id and texture) 
select pp.id as pet_id, p.texture 
from ps_player_pet pp 
    inner join ps_pet p on  pp.pet_id = p.id 
where pp.avuuid = '06340496-1003-4399-a131-84bbc321dc87'
order by pp.id 
limit 0, 8
;


-- pet list for player (id and texture) filtered
select pp.id as pet_id, p.texture
from ps_player_pet_view pp
    inner join ps_pet p on  pp.pet_id = p.id 
where pp.avuuid = '06340496-1003-4399-a131-84bbc321dc87' and pp.attribute = 42
order by pp.id 
limit 0, 8
;


select * from ps_player_pet;
;



select id, personality, 
    constitution, strength, agility, 
    intelligence, wisdom, sorcery, 
    charm, confidence, empathy,
    loyalty, spirituality, karma
from ps_player_pet
where health != 'Dead'
;  



select pp.id as id, p.id as pet_id, p.texture, pp.pet_number, pp.health 
from ps_player_pet_view pp inner join ps_pet p on  pp.pet_id = p.id 
where pp.avuuid = '06340496-1003-4399-a131-84bbc321dc87' 
order by pp.pet_number limit 0, 8
;


-- -----------------------------------------------------------------
-- Available quests . 
select id, text from ps_quest_def where enabled = true order by id;

-- get desc for quest
select id, text, next_action from ps_quest_def where id = 1;


select * from ps_quest_choice where quest_id = 1 and action = (select next_action from ps_quest_def where id = 1);


select * from ps_quest_choice where quest_id = 1 and action = 'unicorn2';

select * from ps_quest_choice where quest_id = 1 and action = 'unicorn3';

select * from ps_quest_choice where quest_id = 1 and action = 'unicorn4';

-- -----------------------------------------------------------------------------


select * from ps_avatar_info where avuuid = '06340496-1003-4399-a131-84bbc321dc87';

update ps_avatar_info ai set ai.food = ai.food + 1 where ai.avuuid = '06340496-1003-4399-a131-84bbc321dc87';


select * from ps_player_pet_view;

select * from ps_avatar_info_view;

select * from ps_rank_tier;

select * from ps_attribute_habitat where attribute = 'Plants';


-- daily update stored procedure.
call ps_daily_update('06340496-1003-4399-a131-84bbc321dc87');


select * from ps_player_pet where fatigue < 0;

update ps_player_pet set fatigue = fatigue + -10 where avuuid = '06340496-1003-4399-a131-84bbc321dc87';

update ps_player_pet set fatigue = fatigue = 0 where avuuid = '06340496-1003-4399-a131-84bbc321dc87' and fatigue < 0;



-- ---------------------------------------------------------------------
select * from ps_pet;

select * from ps_pet_activity;

select * from ps_avatar_info;


select * from ps_pet_activity where pet_id = 1 order by pet_id limit 0, 8;

update ps_avatar_info set food = food + 1 where avuuid = '06340496-1003-4399-a131-84bbc321dc87';

select * from ps_version;

select * from ps_log;


update ps_avatar_info set action_points = 50 where avuuid = '06340496-1003-4399-a131-84bbc321dc87';
update ps_avatar_info set food = 5000 where avuuid = '06340496-1003-4399-a131-84bbc321dc87';




select * 
from ps_player_pet_view 
where 
    avuuid = '06340496-1003-4399-a131-84bbc321dc87' and 
    pet_number = (select min(pet_number) from ps_player_pet_view where avuuid = '06340496-1003-4399-a131-84bbc321dc87') 
;

select 
    pp.id as id, p.id as pet_id, p.texture, pp.pet_number 
from 
    ps_player_pet pp 
    inner join ps_pet p on pp.pet_id = p.id 
where pp.avuuid = '06340496-1003-4399-a131-84bbc321dc87' 
order by p.id limit 0, 8
;


select rt1.max_stat from ps_rank_tier rt1 where rt1.rank_tier = 'D-';



select * from ps_player_pet_view where avuuid = '06340496-1003-4399-a131-84bbc321dc87' and pet_number = 1;

select count(*) as count from ps_player_pet_view 
where avuuid = '06340496-1003-4399-a131-84bbc321dc87' and ('none' = 'none' or attribute = 'none');


update ps_avatar_info set region = 'Pandemonium', coord = '<70.0, 210.0, 56.0>' where avuuid = '06340496-1003-4399-a131-84bbc321dc87'; 


update ps_avatar_info set action_points = 0 where avuuid = '06340496-1003-4399-a131-84bbc321dc87';


-- --------------------------------------------------------------
-- Wild Pets

-- basic 
select * from ps_player_pet p where p.is_wild = true;


select * from ps_player_pet where is_wild = true order by rand() limit 1;


select * from ps_player_pet 
where is_wild = true 
order by id 
limit 4, 1 
;


select * from ps_pet_activity;



-- -----------------------------------------
-- update Lily's stuff (eab6f2ed-f024-4923-9be6-05997b43b86e)

update ps_avatar_info set action_points = 0 where avuuid = 'eab6f2ed-f024-4923-9be6-05997b43b86e';


insert into dcurrency
(avuuid, soulpoint)
values
('06340496-1003-4399-a131-84bbc321dc87', 3000000)
;


select * from ps_player_pet where avuuid = '06340496-1003-4399-a131-84bbc321dc87';


update ps_player_pet set fatigue = 100 where id = 1; 

update ps_player_pet set fatigue = 30 where id = 2; 


update ps_avatar_info set food = food + 500 where avuuid = '06340496-1003-4399-a131-84bbc321dc87';

select * from dcurrency
;


update ps_avatar_info set action_points = 500 where avuuid = '06340496-1003-4399-a131-84bbc321dc87';


update ps_avatar_info set food = 500 where avuuid = '06340496-1003-4399-a131-84bbc321dc87';



update ps_avatar_info ai set ai.action_points = ai.action_points + -1 where ai.avuuid = '06340496-1003-4399-a131-84bbc321dc87';

select * from ps_avatar_info where avuuid = '06340496-1003-4399-a131-84bbc321dc87';

select * from ps_pet_genome_view;

-- -----------------------------------------------------------------
-- Show habitat locations that have not updated in 2 days

select id, name, update_time, datediff(current_date(), update_time) as days
from ps_habitat_location
-- where current_date() > date_add(update_time, interval 2 day)
order by days desc
;

select * from ps_pet_genome;


delete from ps_pet_genome
where pet_id in
(select p.pet_id from ps_pet_genome g
inner join ps_player_pet p on p.pet_id = g.pet_id
where p.is_wild = true)
;



select *
from ps_player_pet_view
where
    is_wild = 1
  and enabled = true
  and attribute in (select attribute from ps_attribute_habitat where habitat = 'Plain')
  and ('any' = 'Common' OR grade = 'Common')
-- order by rand() limit 1
;


select max (id) from ps_player_pet;


SELECT * FROM ps_player_pet WHERE avuuid = '06340496-1003-4399-a131-84bbc321dc87';
SELECT * FROM ps_avatar_info WHERE avuuid = '06340496-1003-4399-a131-84bbc321dc87';

select * from ps_player_pet where avuuid = '06340496-1003-4399-a131-84bbc321dc87' and pet_number = 1;