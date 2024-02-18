

create table if not exists dpatreon
(
    avuuid varchar(36) primary key,
	avname varchar (128) null,
    tier int default 0, 
    note text null
);


insert into dpatreon
(avuuid, avname, tier, note)
values
('06340496-1003-4399-a131-84bbc321dc87', 'Jing', 50, '')
;

select * from dpatreon;
