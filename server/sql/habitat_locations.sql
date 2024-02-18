
-- delete data from tables as needed.
delete from ps_habitat_location;

-- ------------------------------------------------------------------
-- habitat locations
-- ------------------------------------------------------------------
insert into ps_habitat_location
(id, registration_id, name, type, habitat, region_name, region_coord, area, dispenser_version, texture_id, parcel_id)
values
(10, 'panda-5247654d-910b-4b84-9022-fb380653aa05', 'Hell Realm', 'universal', 'Hell', 'Pandemonium', '<103, 42, 26>>', '0, 0, 0, 255, 255, 500', 'v0.1', '3f968ee0-a57c-267f-cd7f-a102d0717d56', '1af35e58-e3b7-b432-d1f9-44cb9570773f'),
(11, 'panda-5247654d-910b-4b84-9022-fb380653aa05', 'Emerald Forest of Limbo', 'universal', 'Rainforest', 'Pandemonium', '<141, 98, 806>', '0, 0, 801, 255, 255, 1100', 'v0.1', '3f968ee0-a57c-267f-cd7f-a102d0717d56', '1af35e58-e3b7-b432-d1f9-44cb9570773f'),
(12, 'panda-5247654d-910b-4b84-9022-fb380653aa05', 'Angel''s Outpost', 'universal', 'Heaven', 'Pandemonium', '<118, 174, 1201>', '0, 0, 1101, 255, 255, 1400', 'v0.1', '3f968ee0-a57c-267f-cd7f-a102d0717d56', '1af35e58-e3b7-b432-d1f9-44cb9570773f'),
(13, 'panda-5247654d-910b-4b84-9022-fb380653aa05', 'Mortal''s Village', 'universal', 'Village', 'Pandemonium', '<51, 205, 1826>', '0, 0, 1800, 255, 255, 2000', 'v0.1', '3f968ee0-a57c-267f-cd7f-a102d0717d56', '1af35e58-e3b7-b432-d1f9-44cb9570773f')
;

-- ------------------------------------
insert into ps_log
(process, message)
values
('habitat_location.sql', 'run script');
