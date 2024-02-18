
drop database if exists pandemonium_pets;
create database if not exists pandemonium_pets;
use pandemonium_pets;


drop user if exists pand_pet@localhost;

-- -------------------------------------------
-- create user with password and then grant all privileges to that user.

create user if not exists pand_pet@localhost identified by 'panda4$';


grant all privileges on pandemonium_pets.* to pand_pet@localhost;

