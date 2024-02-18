
-- ---------------------------------------------------------------
-- before the update on the player_pet table calculate the Health
-- of the pet. calculate the age of the pet
-- 


DELIMITER  /


/
drop trigger if exists pp_before_update;
/

/
create or replace trigger pp_before_update
before update on ps_player_pet
for each row
begin
    declare tmp varchar (30);
    declare temp varchar (30);
    declare tmp2 int;

    -- Health calculation as it effects Health value
    set tmp = 'Healthy';
    if (new.fatigue > ((new.constitution + (new.loyalty * 0.25)) * 5.0)) then
        set tmp = 'Dead';
    elseif (new.fatigue > ((new.constitution + (new.loyalty * 0.25)) * 4.0)) then
        set tmp = 'Critical';
    elseif (new.fatigue > ((new.constitution + (new.loyalty * 0.25)) * 3.0)) then
        set tmp = 'Sick';
    elseif (new.fatigue > ((new.constitution + (new.loyalty * 0.25)) * 2.0)) then
        set tmp = 'Run Down';
    elseif (new.fatigue > ((new.constitution + (new.loyalty * 0.25)) * 1.0)) then
        set tmp = 'Tired';
    else
        set temp = 'Healthy';
    end if;
    set new.health = tmp;


    -- age calculation
    set tmp2 = (select count(*) as breed_count from ps_pet_activity pa where pa.pet_id = new.id and pa.activity = 'Breed');
    set temp = 'Adult';
    if (tmp2 >= 3) then
        set temp = 'Senior';
    end if;
    set new.stage = temp;

end
/



-- ---------------------------------------------------------------
-- before insert on player_pet table.
-- Sets the pet number of the pet
--

/
drop trigger if exists pp_before_insert;
/


/
create or replace trigger pp_before_insert
before insert on ps_player_pet
for each row
begin
    declare temp int;
    set temp = (select max(pet_number) + 1 as count from ps_player_pet pp where pp.avuuid = new.avuuid);
    set new.pet_number = ifnull (temp, 1);
end;
/




-- ---------------------------------------------------------------
-- login update (stat perks for logging in.
-- Get once per day max, if skip days only get perk once.
--

/
create or replace procedure ps_daily_update(in avId varchar(36))
modifies sql data
begin
    declare aid bigint;
    declare pers varchar (30);
    declare const int;
    declare str int;
    declare agi int;
    declare intel int;
    declare wisd int;
    declare sorc int;
    declare cha int;
    declare conf int;
    declare emp int;
    declare loy int;
    declare spirit int;
    declare kar int;
    declare fitTot int;
    declare wizTot int;
    declare charTot int;
    declare natTot int;
    declare fitMx int;
    declare wizMx int;
    declare charMx int;
    declare natMx int;
    declare done int;

    declare c1 cursor for
    select id, personality,
        constitution, strength, agility,
        intelligence, wisdom, sorcery,
        charm, confidence, empathy,
        loyalty, spirituality, karma,
        fitness, wizardry, charisma, nature,
        (select rt1.max_stat from ps_rank_tier rt1 where rt1.rank_tier = fitness_rank_tier) as fitness_max,
        (select rt1.max_stat from ps_rank_tier rt1 where rt1.rank_tier = wizardry_rank_tier) as wizardry_max,
        (select rt1.max_stat from ps_rank_tier rt1 where rt1.rank_tier = charisma_rank_tier) as charisma_max,
        (select rt1.max_stat from ps_rank_tier rt1 where rt1.rank_tier = nature_rank_tier) as nature_max
    from ps_player_pet
    where health != 'Dead'and avuuid = avId;

    declare continue handler for not found set done = 1;

    set done = 0;

    open c1;

loop1: loop

        fetch c1 into aid, pers, const, str, agi, intel, wisd, sorc, cha, conf, emp, loy, spirit, kar,
            fitTot, wizTot, charTot, natTot, fitMx, wizMx, charMx, natMx;

        if (done = 0) then

            if (('Energetic' = pers) && (fitTot < fitMx)) then
                set const = const + 1;
            elseif (('Protective' = pers) && (fitTot < fitMx)) then
                set str = str + 1;
            elseif (('Playful' = pers) && (fitTot < fitMx)) then
                set agi = agi + 1;
            elseif (('Affectionate' = pers) && (charTot < charMx)) then
                set cha = cha + 1;
            elseif (('Independent' = pers) && (charTot < charMx)) then
                set conf = conf + 1;
            elseif (('Social' = pers) && (charTot < charMx)) then
                set emp = emp + 1;
            elseif (('Curious' = pers) && (wizTot < wizMx)) then
                set intel = intel + 1;
            elseif (('Calm' = pers) && (wizTot < wizMx)) then
                set wisd = wisd + 1;
            elseif (('Mischievous' = pers) && (wizTot < wizMx)) then
                set sorc = sorc + 1;
            elseif (('Loyal' = pers) && (natTot < natMx)) then
                set loy = loy + 1;
            elseif (('Shy' = pers) && (natTot < natMx)) then
                set spirit = spirit + 1;
            elseif (('Fearless' = pers) && (natTot < natMx)) then
                set kar = kar + 1;
            end if;


            update ps_player_pet set
            constitution = const, strength = str, agility = agi, intelligence = intel, wisdom = wisd, sorcery = sorc,
            charm = cha, confidence = conf, empathy = emp, loyalty = loy, spirituality = spirit, karma = kar
            where id = aid;

        else
            leave loop1;
        end if;

    end loop loop1;

    close c1;


    insert into ps_log (process, message) values ('ps_daily_update', 'run');

end;
/



-- ---------------------------------------------------------------
-- Avatar info tables update handling
--

/
drop trigger if exists ai_after_update;
/

/
drop trigger if exists ai_before_update;
/

/
create or replace trigger ai_before_update 
before update on ps_avatar_info 
for each row 
begin 
    declare dt date;
    declare t1 int;
    declare tt int;

    set dt = current_date ();
    if (old.activity_time != dt) then

        select tier into t1 from dpatreon where avuuid = new.avuuid;

        set tt = 5;
        if ((t1 >= 8) && (t1 <= 19)) then
            set tt = 7;
        elseif ((t1 >= 20) && (t1 <= 49)) then
            set tt = 9;
        elseif ((t1 >= 50) && (t1 <= 99)) then
            set tt = 11;
        elseif (t1 >= 100) then
            set tt = 13;
        end if;

        set new.action_points = tt;
        set new.activity_time = dt;
        
        -- other dailies 
        call ps_daily_update(old.avuuid);
        
        insert into ps_log (process, message) values ('ai_before_update', 'run');
    end if;
    
end
/


insert into ps_log
(process, message)
values
('pet_triggers.sql', 'run script');

