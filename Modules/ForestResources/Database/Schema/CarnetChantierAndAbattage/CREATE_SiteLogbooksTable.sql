--
-- Carnet de chantier
--
create table "ForestResources"."SiteLogbooksTable"
(
	"Id" int not null ,
	"AnnualAllowableCut" int not null,
	"ManagementUnit" int not null,
	"DevelopmentUnit" int not null,
	"Concession" int not null,
	"Company" int not null,
	"Hammer" int,
	"Localization" varchar,
	"ReportNo" varchar,
	"ReportNote" varchar,
	"ObserveAt" timestamp not null,
    "CreatedAt" timestamp default current_timestamp not null,
    "UpdatedAt" timestamp default current_timestamp not null,
	"DeletedAt" timestamp,
	constraint "PK_SiteLogbooksTable" primary key ("Id")
);
--
-- Foreign Keys
--
alter table "ForestResources"."SiteLogbooksTable"
add constraint "FK_SiteLogbooksTable_AnnualAllowableCut"
    foreign key
        (
            "AnnualAllowableCut"
        )
    references "ForestResources"."AnnualAllowableCutsTable"("Id")
;

alter table "ForestResources"."SiteLogbooksTable"
add constraint "FK_SiteLogbooksTable_ManagementUnit"
    foreign key
        (
            "ManagementUnit"
        )
    references "ForestResources"."ManagementUnitsTable"("Id")
;

alter table "ForestResources"."SiteLogbooksTable"
add constraint "FK_SiteLogbooksTable_DevelopmentUnit"
    foreign key
        (
            "DevelopmentUnit"
        )
    references "ForestResources"."DevelopmentUnitsTable"("Id")
;

alter table "ForestResources"."SiteLogbooksTable"
add constraint "FK_SiteLogbooksTable_Company"
    foreign key
        (
            "Company"
        )
    references "Taxonomy"."CompaniesTable"("Id")
;

alter table "ForestResources"."SiteLogbooksTable"
add constraint "FK_SiteLogbooksTable_Concession"
    foreign key
        (
            "Concession"
        )
    references "ForestResources"."ConcessionsTable"("Id")
;
--
-- SEQ
--
create sequence if not exists "ForestResources"."SEQ_SiteLogbooksTable"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."SiteLogbooksTable"."Id"
;

--
-- View
--
create or replace view "ForestResources"."SiteLogbooks"
as
    select
        slb."Id",
        slb."AnnualAllowableCut",
        slb."ManagementUnit",
        slb."DevelopmentUnit",
        slb."Concession",
        slb."Company",
        slb."Hammer",
        slb."Localization",
        slb."ReportNo",
        slb."ReportNote",
        slb."ObserveAt",
        slb."CreatedAt",
        slb."UpdatedAt",
        slb."DeletedAt"
    from "ForestResources"."SiteLogbooksTable" as slb
;

-- update_timestamp function
create or replace function update_timestamp()
    returns trigger as $$
begin
    new."UpdatedAt" = now();
    return new;
end ;
$$ language 'plpgsql';

create trigger user_timestamp before insert or update on "ForestResources"."SiteLogbooksTable"
    for each row execute procedure update_timestamp();

--
-- Rules
--
create or replace rule "SiteLogbooks_instead_of_delete"
as
    on delete to "ForestResources"."SiteLogbooks"
    do instead
        delete from "ForestResources"."SiteLogbooksTable"
        where
            "ForestResources"."SiteLogbooksTable"."Id" = old."Id"
;

create or replace rule "SiteLogbooks_instead_of_insert"
as
    on insert to "ForestResources"."SiteLogbooks"
    do instead
        insert into "ForestResources"."SiteLogbooksTable"
        (
            "Id",
            "AnnualAllowableCut",
            "ManagementUnit",
            "DevelopmentUnit",
            "Concession",
            "Company",
            "Hammer",
            "Localization",
            "ReportNo",
            "ReportNote",
            "ObserveAt",
            "CreatedAt",
            "UpdatedAt"
        )
        values
        (
            nextval('"ForestResources"."SEQ_SiteLogbooksTable"'),
            new."AnnualAllowableCut",
            new."ManagementUnit",
            new."DevelopmentUnit",
            new."Concession",
            new."Company",
            new."Hammer",
            new."Localization",
            new."ReportNo",
            new."ReportNote",
            new."ObserveAt",
            new."CreatedAt",
            new."UpdatedAt"
        )
        returning
            "Id",
            "AnnualAllowableCut",
            "ManagementUnit",
            "DevelopmentUnit",
            "Concession",
            "Company",
            "Hammer",
            "Localization",
            "ReportNo",
            "ReportNote",
            "ObserveAt",
            "CreatedAt",
            "UpdatedAt",
            "DeletedAt"
;

create or replace rule "SiteLogbooks_instead_of_update"
as
    on update to "ForestResources"."SiteLogbooks"
    do instead
        update "ForestResources"."SiteLogbooksTable"
            set
                "AnnualAllowableCut" = new."AnnualAllowableCut",
                "ManagementUnit" = new."ManagementUnit",
                "DevelopmentUnit" = new."DevelopmentUnit",
                "Concession" = new."Concession",
                "Company" = new."Company",
                "Hammer" = new."Hammer",
                "Localization" = new."Localization",
                "ReportNo" = new."ReportNo",
                "ReportNote" = new."ReportNote",
                "ObserveAt" = new."ObserveAt",
                "CreatedAt" = new."CreatedAt",
                "UpdatedAt" = new."UpdatedAt",
                "DeletedAt" = new."DeletedAt"
            where
                "SiteLogbooksTable"."Id" = old."Id"
            returning
                "Id",
                "AnnualAllowableCut",
                "ManagementUnit",
                "DevelopmentUnit",
                "Concession",
                "Company",
                "Hammer",
                "Localization",
                "ReportNo",
                "ReportNote",
                "ObserveAt",
                "CreatedAt",
                "UpdatedAt",
                "DeletedAt"
;
