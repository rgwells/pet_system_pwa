-- ------------------------------------------------------------------
-- Pandemonium pet system - Special pets
--


set foreign_key_checks = 0;

-- ----------------------------------------------------------------
-- Valentine Pet definition
-- ----------------------------------------------------------------
delete from ps_pet where id = 100;

insert into ps_pet
(id, species, owner_type, texture, face_texture, color, attribute_texture, attribute_name, grade)
values
(100, 'Valentine',   'any', 'img/pet-portrait/pet-fire-2-valentine.webp',  'img/pet-portrait/pet-fire-2-valentine-face.webp', (select color from ps_attribute where attribute = 'Fire'), (select texture as attribure_texture from ps_attribute where attribute = 'Fire'), 'Fire', 'Uncommon')
;


-- ----------------------------------------------------------------
-- Valentine pet instance
-- ----------------------------------------------------------------
delete from ps_player_pet where id = 801;

insert into ps_player_pet (id, pet_number, pet_id, enabled, parent_a, parent_b, avuuid, is_wild, birth_date, stage, health, habitat, personality, fatigue, fitness_rank_tier, constitution, strength, agility, wizardry_rank_tier, intelligence, wisdom, sorcery, charisma_rank_tier, charm, confidence, empathy, nature_rank_tier, loyalty, spirituality, karma, notes)
values
(801, 0, 100, true, null, null, '', 1, '2024-01-30', 'Adult', 'Healthy', 'Autumnal', 'Calm', 0, 'D', 10, 10, 10, 'C', 10, 10, 10, 'D+', 10, 10, 10, 'D+', 10, 10, 10, 'Special valentines day pet.')
;

-- Valentine genome
delete from ps_pet_genome where pet_id = 801;

insert into ps_pet_genome
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values
(801, true, false, true, true, false, false, true, false, true, false, true, false, true)
;

set foreign_key_checks = 1;