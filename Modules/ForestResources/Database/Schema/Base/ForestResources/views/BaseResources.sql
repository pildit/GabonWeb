----------
-- VIEW --
----------
create view "ForestResources"."BaseResources"
as
    select
        brt."Id"
        , brt."ResourceType"
        , brt."Name"
        , brt."Geometry"
    from
        "ForestResources"."BaseResourcesTable" as brt
;


-------------------------
-- Instead-of Triggers --
-------------------------

-- Instead of Insert

create function "ForestResources"."BaseResources_insteadof_insert" ()
	returns trigger
	language plpgsql
	volatile
	called on null input
	security invoker
	cost 100
	as $$
begin
	raise exception 'A ForestResources.BaseResource cannot be inserted by itself.';
end;
$$;

create trigger "TRIG_ForestResources.BaseResources_insteadof_insert"
	instead of insert
	on "ForestResources"."BaseResources"
	for each row
	execute procedure "ForestResources"."BaseResources_insteadof_insert"()
;


-- Instead of Delete

create function "ForestResources"."BaseResources_insteadof_delete" ()
	returns trigger
	language plpgsql
	volatile
	called on null input
	security invoker
	cost 100
	as $$
begin
	raise exception 'A ForestResources.BaseResource cannot be deleted by itself.';
end;
$$;

create trigger "TRIG_ForestResources.BaseResources_insteadof_delete"
	instead of delete
	on "ForestResources"."BaseResources"
	for each row
	execute procedure "ForestResources"."BaseResources_insteadof_delete"()
;


-- Instead of Update

create function "ForestResources"."BaseResources_insteadof_update" ()
	returns trigger
	language plpgsql
	volatile
	called on null input
	security invoker
	cost 100
	as $$
begin
	raise exception 'A ForestResources.BaseResource cannot be updated by itself.';
end;
$$;

create trigger "TRIG_ForestResources.BaseResources_insteadof_update"
	instead of update
	on "ForestResources"."BaseResources"
	for each row
	execute procedure "ForestResources"."BaseResources_insteadof_update"()
;
