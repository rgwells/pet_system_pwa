-- ----------------------------------------------------------------
-- Jing's pets


-- remove activity information
delete from ps_pet_activity where pet_id in (
select a.pet_id from ps_pet_activity a
inner join ps_player_pet p on a.pet_id = p.id
where p.avuuid = '06340496-1003-4399-a131-84bbc321dc87');

-- remove genome information
delete from ps_pet_genome where pet_id in (
select g.pet_id from ps_pet_genome g
inner join ps_player_pet p on g.pet_id = p.id
where p.avuuid = '06340496-1003-4399-a131-84bbc321dc87');

-- remove pet information
delete from ps_player_pet where avuuid = '06340496-1003-4399-a131-84bbc321dc87';



-- ----------------------------------------------------------------
-- Jing's pets 
insert into ps_player_pet
(pet_id, avuuid, health, habitat, personality, stage, fitness_rank_tier, constitution, strength, agility, fatigue, wizardry_rank_tier, intelligence, wisdom, sorcery, charisma_rank_tier, charm, confidence, empathy, nature_rank_tier, loyalty, spirituality, karma)
values
(1, '06340496-1003-4399-a131-84bbc321dc87', 'Healthy', 'Rainforest',   'Curious', 'Adult', 'C-',  30,  30,  30,  0, 'C+',  30,  30,  30, 'C',  30,  30,  30, 'C+',  30,  30,  30)
;

insert into ps_pet_genome
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values
(last_insert_id (), 0,1,1,0,1,0,1,1,0,0,1,0,0)
;

insert into ps_player_pet
(pet_id, avuuid, health, habitat, personality, stage, fitness_rank_tier, constitution, strength, agility, fatigue, wizardry_rank_tier, intelligence, wisdom, sorcery, charisma_rank_tier, charm, confidence, empathy, nature_rank_tier, loyalty, spirituality, karma)
values
(2, '06340496-1003-4399-a131-84bbc321dc87', 'Healthy', 'Plain',   'Mischievous', 'Adult', 'D-',  11,  11,  11,  0, 'D-',  10,  10,  10, 'D',  10,  10,  10, 'D+',  10,  10,  10)
;

insert into ps_pet_genome
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values
(last_insert_id (), 1,0,1,0,1,1,0,0,1,0,1,0,1)
;



insert into ps_player_pet
(pet_id, avuuid, health, habitat, personality, stage, fitness_rank_tier, constitution, strength, agility, fatigue, wizardry_rank_tier, intelligence, wisdom, sorcery, charisma_rank_tier, charm, confidence, empathy, nature_rank_tier, loyalty, spirituality, karma)
values
(14, '06340496-1003-4399-a131-84bbc321dc87', 'Healthy', 'Alpine',   'Shy', 'Adult', 'D-',  12,  12,  12,  0, 'D-',  10,  10,  10, 'D',  10,  10,  10, 'D+',  10,  10,  10)
;

insert into ps_pet_genome
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values
(last_insert_id (), 0,1,0,0,1,1,1,0,1,0,1,0,0)
;


insert into ps_player_pet
(pet_id, avuuid, health, habitat, personality, stage, fitness_rank_tier, constitution, strength, agility, fatigue, wizardry_rank_tier, intelligence, wisdom, sorcery, charisma_rank_tier, charm, confidence, empathy, nature_rank_tier, loyalty, spirituality, karma)
values
(10, '06340496-1003-4399-a131-84bbc321dc87', 'Healthy', 'Tundra',   'Protective', 'Adult', 'D-',  12,  12,  12,  0, 'D-',  10,  10,  10, 'D',  10,  10,  10, 'D+',  10,  10,  10)
;

insert into ps_pet_genome
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values
(last_insert_id (), 1,0,0,1,0,1,0,1,0,1,1,0,1)
;


insert into ps_player_pet
(pet_id, avuuid, health, habitat, personality, stage, fitness_rank_tier, constitution, strength, agility, fatigue, wizardry_rank_tier, intelligence, wisdom, sorcery, charisma_rank_tier, charm, confidence, empathy, nature_rank_tier, loyalty, spirituality, karma)
values
(24, '06340496-1003-4399-a131-84bbc321dc87', 'Healthy', 'Alpine',   'Social', 'Adult', 'D-',  10,  10,  10,  0, 'D-',  10,  10,  10, 'D',  10,  10,  10, 'D+',  10,  10,  10)
;

insert into ps_pet_genome
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values
(last_insert_id (), 0,1,0,1,1,0,1,0,1,0,1,0,1)
;



