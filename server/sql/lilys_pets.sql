

-- --------------------------------------------------------
-- Lily's pets

-- remove activity information
delete from ps_pet_activity where pet_id in (
select a.pet_id from ps_pet_activity a
inner join ps_player_pet p on a.pet_id = p.id
where p.avuuid = 'eab6f2ed-f024-4923-9be6-05997b43b86e');

-- remove genome information
delete from ps_pet_genome where pet_id in (
select g.pet_id from ps_pet_genome g
inner join ps_player_pet p on g.pet_id = p.id
where p.avuuid = 'eab6f2ed-f024-4923-9be6-05997b43b86e');

delete from ps_player_pet where avuuid = 'eab6f2ed-f024-4923-9be6-05997b43b86e';


insert into ps_player_pet
(pet_id, avuuid, health, habitat, personality, stage, fitness_rank_tier, constitution, strength, agility, fatigue, wizardry_rank_tier, intelligence, wisdom, sorcery, charisma_rank_tier, charm, confidence, empathy, nature_rank_tier, loyalty, spirituality, karma)
values
(10, 'eab6f2ed-f024-4923-9be6-05997b43b86e', 'Healthy', 'Plain',   'Energetic', 'Adult', 'D-',  10,  10,  10,  0, 'D-',  10,  10,  10, 'D',  10,  10,  10, 'D+',  10,  10,  10)
;

insert into ps_pet_genome
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values
(last_insert_id (), 1, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 0, 0)
;

insert into ps_player_pet
(pet_id, avuuid, health, habitat, personality, stage, fitness_rank_tier, constitution, strength, agility, fatigue, wizardry_rank_tier, intelligence, wisdom, sorcery, charisma_rank_tier, charm, confidence, empathy, nature_rank_tier, loyalty, spirituality, karma)
values
(22, 'eab6f2ed-f024-4923-9be6-05997b43b86e', 'Healthy', 'Glacier', 'Bold',  'Adult', 'D-',  10,  10,  10,  2, 'D',  10,  10,  10, 'D',  10,  10,  10, 'D',  10,  10,  10)
;

insert into ps_pet_genome
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values
(last_insert_id (), 0, 0, 1, 0, 0, 1, 1, 0, 0, 1, 0, 1, 0)
;


insert into ps_player_pet
(pet_id, avuuid, health, habitat, personality, stage, fitness_rank_tier, constitution, strength, agility, fatigue, wizardry_rank_tier, intelligence, wisdom, sorcery, charisma_rank_tier, charm, confidence, empathy, nature_rank_tier, loyalty, spirituality, karma)
values
(72, 'eab6f2ed-f024-4923-9be6-05997b43b86e', 'Healthy', 'Meadow', 'Shy',  'Adult', 'D+',  10,  10,  10,  2, 'D+',  10,  10,  10, 'D+',  10,  10,  10, 'D+',  10,  10,  10)
;

insert into ps_pet_genome
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values
(last_insert_id (), 0, 1, 1, 0, 1, 1, 0, 0, 1, 0, 1, 0, 0)
;

insert into ps_player_pet
(pet_id, avuuid, health, habitat, personality, stage, fitness_rank_tier, constitution, strength, agility, fatigue, wizardry_rank_tier, intelligence, wisdom, sorcery, charisma_rank_tier, charm, confidence, empathy, nature_rank_tier, loyalty, spirituality, karma)
values
(91, 'eab6f2ed-f024-4923-9be6-05997b43b86e', 'Healthy', 'Coral', 'Fearless',  'Adult', 'D+',  10,  10,  10,  2, 'D+',  10,  10,  10, 'C-',  10,  10,  10, 'D+',  10,  10,  10)
;

insert into ps_pet_genome
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values
(last_insert_id (), 0, 1, 1, 1, 0, 0, 0, 1, 0, 1, 1, 0, 1)
;

insert into ps_player_pet
(pet_id, avuuid, health, habitat, personality, stage, fitness_rank_tier, constitution, strength, agility, fatigue, wizardry_rank_tier, intelligence, wisdom, sorcery, charisma_rank_tier, charm, confidence, empathy, nature_rank_tier, loyalty, spirituality, karma)
values
(2, 'eab6f2ed-f024-4923-9be6-05997b43b86e', 'Healthy', 'Plain',   'Mischievous', 'Adult', 'D-',  11,  11,  11,  2, 'D-',  10,  10,  10, 'D',  10,  10,  10, 'D+',  10,  10,  10)
;

insert into ps_pet_genome
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values
(last_insert_id (), 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1)
;


insert into ps_player_pet
(pet_id, avuuid, health, habitat, personality, stage, fitness_rank_tier, constitution, strength, agility, fatigue, wizardry_rank_tier, intelligence, wisdom, sorcery, charisma_rank_tier, charm, confidence, empathy, nature_rank_tier, loyalty, spirituality, karma)
values
(14, 'eab6f2ed-f024-4923-9be6-05997b43b86e', 'Healthy', 'Alpine',   'Shy', 'Adult', 'D-',  12,  12,  12,  2, 'D-',  10,  10,  10, 'D',  10,  10,  10, 'D+',  10,  10,  10)
;

insert into ps_pet_genome
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values
(last_insert_id (), 0, 0, 1, 1, 0, 0, 1, 0, 1, 1, 1, 0, 0)
;



-- ------------------------------------
insert into ps_log
(process, message)
values
('lilys_pets.sql', 'run script');

