
drop table if exists ps_pet_gene;



create table if not exists ps_pet_gene
(
    gene_name varchar(35) primary key not null, 
    min_gvalue int not null,
    max_gvalue int not null,
    mutation_rate decimal (5, 3) not null
);


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
    
    constraint pgenome_pet_id_fk foreign key (pet_id) references ps_player_pet(id)
);




-- wild pet genomes
insert into ps_pet_genome 
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values 
(900, 1, 0, 1, 0, 1, 1, 0, 1, 0, 0, 1, 0, 1),
(901, 0, 1, 1, 1, 0, 0, 1, 0, 1, 0, 0, 1, 1),
(902, 1, 0, 0, 1, 1, 0, 1, 0, 0, 1, 1, 0, 1),
(903, 0, 1, 0, 1, 1, 1, 0, 1, 1, 0, 1, 0, 0)
;


-- Jing's pets genomes 
insert into ps_pet_genome 
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values 
(1, 0,1,1,0,1,0,1,1,0,0,1,0,0),
(2, 1,0,1,0,1,1,0,0,1,0,1,0,1),
(3, 0,1,0,0,1,1,1,0,1,0,1,0,0),
(4, 1,0,0,1,0,1,0,1,0,1,1,0,1),
(5, 0,1,0,1,1,0,1,0,1,0,1,0,1),
(6, 1,1,0,0,1,0,1,0,1,1,0,0,1),
(7, 0,1,0,1,1,0,0,1,0,1,1,0,0),
(8, 1,0,1,0,1,0,1,1,0,1,0,1,0),
(9, 0,0,1,1,0,1,0,1,0,0,1,1,0),
(10, 1,1,0,1,0,1,1,0,1,0,1,0,1),
(11, 0,1,0,0,1,0,1,0,0,1,0,1,0),
(12, 1,0,1,0,1,1,0,1,0,1,1,0,1),
-- (13, 0,0,1,1,0,0,1,1,0,0,1,1,0),
(14, 1,1,0,1,0,1,0,1,1,0,1,0,1),
(15, 0,1,0,0,1,0,1,0,0,1,0,1,0),
(16, 1,0,1,0,1,0,1,1,0,1,0,1,0),
(17, 0,0,1,1,0,1,0,1,0,0,1,1,0),
(18, 1,1,0,1,0,1,1,0,1,0,1,0,1),
(19, 0,1,0,0,1,0,1,0,0,1,0,1,0),
(20, 1,0,1,0,1,1,0,1,0,1,1,0,1),
(21, 0,0,1,1,0,0,1,1,0,0,1,1,0),
(22, 1,1,0,1,0,1,0,1,1,0,1,0,1),
(23, 0,1,0,0,1,0,1,0,0,1,0,1,0),
(24, 1,0,1,0,1,0,1,1,0,1,0,1,0),
(25, 0,0,1,1,0,1,0,1,0,0,1,1,0),
(26, 1,1,0,1,0,1,1,0,1,0,1,0,1),
(27, 0,1,0,0,1,0,1,0,0,1,0,1,0),
(28, 1,0,1,0,1,1,0,1,0,1,1,0,1)
;


-- Xander's pet genomes
insert into ps_pet_genome 
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values 
(50, 0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0, 1, 1),
(51, 1, 0, 0, 1, 1, 0, 1, 0, 1, 0, 1, 0, 1),
(52, 0, 1, 0, 1, 0, 0, 1, 1, 0, 1, 0, 1, 0),
(53, 1, 0, 1, 0, 0, 1, 0, 1, 1, 0, 1, 0, 0),
(54, 1, 0, 1, 0, 1, 1, 0, 0, 1, 0, 1, 1, 0),
(55, 0, 1, 0, 0, 1, 0, 1, 1, 1, 0, 1, 0, 0),
(56, 1, 0, 1, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1),
(57, 0, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, 1, 0),
(58, 1, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 0, 1),
(59, 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 1, 0, 1),
(60, 0, 1, 0, 1, 1, 0, 1, 0, 1, 0, 1, 0, 1),
(61, 1, 0, 0, 1, 0, 1, 0, 1, 0, 0, 1, 1, 0),
(62, 0, 1, 0, 1, 0, 0, 1, 1, 0, 1, 0, 1, 0),
(63, 1, 0, 1, 0, 0, 1, 0, 1, 1, 0, 1, 0, 0),
(64, 1, 0, 1, 0, 1, 1, 0, 0, 1, 0, 1, 1, 0),
(65, 0, 1, 0, 0, 1, 0, 1, 1, 1, 0, 1, 0, 0),
(66, 1, 0, 1, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1),
(67, 0, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, 1, 0),
(68, 1, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 0, 1),
(69, 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 1, 0, 1),
(70, 1, 0, 1, 1, 0, 0, 1, 0, 1, 1, 0, 1, 0),
(71, 0, 1, 1, 0, 1, 1, 0, 0, 1, 0, 0, 1, 1),
(72, 1, 0, 1, 0, 1, 1, 0, 1, 0, 0, 1, 1, 0),
(73, 0, 0, 1, 1, 0, 1, 0, 1, 1, 0, 0, 1, 1),
(74, 1, 0, 0, 1, 1, 0, 1, 0, 1, 0, 1, 0, 0),
(75, 1, 1, 0, 1, 0, 1, 0, 0, 1, 1, 0, 1, 0),
(76, 0, 1, 1, 0, 0, 1, 0, 1, 1, 0, 1, 0, 1),
(77, 0, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1),
(78, 1, 0, 1, 1, 0, 0, 1, 0, 1, 0, 1, 1, 0),
(79, 1, 0, 0, 1, 1, 0, 1, 0, 0, 1, 0, 1, 1),
(80, 0, 1, 1, 0, 1, 1, 0, 0, 1, 1, 0, 1, 0),
(81, 1, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 0, 1),
(82, 0, 1, 0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 1),
(83, 1, 0, 1, 1, 0, 1, 0, 0, 1, 0, 1, 1, 0),
(84, 0, 0, 1, 1, 1, 0, 1, 0, 1, 0, 0, 1, 1),
(85, 1, 0, 1, 0, 1, 1, 0, 1, 0, 0, 1, 0, 1),
(86, 1, 0, 0, 1, 1, 1, 0, 0, 1, 1, 1, 1, 0),
(87, 0, 1, 0, 0, 0, 1, 1, 0, 1, 0, 0, 1, 0),
(88, 1, 1, 0, 1, 1, 1, 1, 0, 0, 1, 1, 0, 1),
(89, 0, 0, 1, 0, 1, 0, 1, 0, 0, 0, 1, 1, 1),
(90, 1, 0, 1, 1, 0, 0, 0, 1, 1, 1, 0, 0, 1),
(91, 0, 0, 1, 1, 1, 0, 1, 1, 0, 0, 1, 0, 1),
(92, 1, 1, 0, 0, 1, 0, 1, 0, 1, 1, 0, 1, 0),
(93, 0, 1, 0, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0),
(94, 1, 0, 1, 0, 1, 0, 1, 1, 0, 1, 0, 0, 1),
(95, 0, 1, 1, 1, 0, 0, 0, 1, 0, 0, 1, 1, 1),
(96, 1, 0, 0, 1, 1, 1, 0, 1, 1, 0, 1, 0, 0),
(97, 0, 1, 0, 0, 0, 1, 1, 0, 1, 0, 0, 1, 0),
(98, 1, 1, 0, 1, 1, 1, 1, 0, 0, 1, 1, 0, 1),
(99, 0, 0, 1, 0, 1, 0, 1, 0, 0, 0, 1, 1, 1)
;



-- Lily's pet genomes
insert into ps_pet_genome 
(pet_id, constitution_dominant, strength_dominant, agility_dominant, charm_dominant, confidence_dominant, empathy_dominant, intelligence_dominant, wisdom_dominant, sorcery_dominant, loyalty_dominant, spirituality_dominant, karma_dominant, personality_dominant)
values 
(300, 1, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 0, 0),
(301, 0, 0, 1, 0, 0, 1, 1, 0, 0, 1, 0, 1, 0),
(302, 0, 1, 1, 0, 1, 1, 0, 0, 1, 0, 1, 0, 0),
(303, 0, 1, 1, 1, 0, 0, 0, 1, 0, 1, 1, 0, 1),
(304, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1),
(305, 0, 0, 1, 1, 0, 0, 1, 0, 1, 1, 1, 0, 0),
(306, 0, 0, 0, 0, 0, 1, 0, 1, 1, 1, 0, 0, 1),
(307, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 0, 1),
(308, 0, 1, 1, 1, 0, 0, 0, 0, 1, 1, 0, 0, 1),
(309, 0, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1),
(310, 1, 1, 1, 0, 0, 1, 1, 0, 1, 0, 1, 0, 1),
(311, 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 0, 1, 0),
(312, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 0, 1, 0),
(313, 0, 0, 0, 1, 0, 1, 0, 0, 1, 1, 0, 1, 1),
(314, 1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 1, 0, 0),
(315, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, 0, 1),
(316, 0, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1),
(317, 1, 0, 1, 1, 0, 1, 0, 0, 0, 0, 1, 0, 1),
(318, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(319, 0, 0, 0, 0, 1, 1, 1, 0, 1, 1, 0, 1, 0),
(320, 1, 0, 1, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0),
(321, 1, 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1)
;







