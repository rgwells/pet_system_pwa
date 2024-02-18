

create table if not exists dcurrency
(
    avuuid varchar(36) primary key,
    avname varchar (128) not null,
    soulpoint int default 0
);


insert into dcurrency
(avuuid, avname)
values
('06340496-1003-4399-a131-84bbc321dc87', 'Jing')
;

update dcurrency set soulpoint = 30000000 where avuuid = '06340496-1003-4399-a131-84bbc321dc87';

select * from dcurrency;
