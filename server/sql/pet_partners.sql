
-- ---------------------------------------------------------------------------------------------

delete from ps_partner;

insert into ps_partner
(id, registration_id, name, region_name, landing_coord, parcel_id, texture_id, default_habitat)
values
(1, 'panda-5247654d-910b-4b84-9022-fb380653aa05', 'Pandemonium Hell Fantasy Roleplay', 'Pandemonium', '<27, 209, 3602>', '1af35e58-e3b7-b432-d1f9-44cb9570773f', '42709956-7310-2059-3e61-27c889a9d7ed', 'Hell')
;



-- ------------------------------------
insert into ps_log
(process, message)
values
('pet_partners.sql', 'run script');
