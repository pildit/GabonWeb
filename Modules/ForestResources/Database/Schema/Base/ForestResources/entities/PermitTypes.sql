create table "ForestResources"."PermitTypesTable"
(
    "Id" int not null,
    "Name" text not null,
    "Abbreviation" text not null,
    constraint "PK_ForestResources.PermitTypesTable" primary key("Id"),
    constraint "CHK_ForestResources.PermitTypesTable.Name" check (length("Name") > 0),
    constraint "CHK_ForestResources.PermitTypesTable.Abbreviation" check (length("Abbreviation") > 0),
    constraint "UNIQ_ForestResources.PermitTypesTable.Name" unique("Name"),
    constraint "UNIQ_ForestResources.PermitTypesTable.Abbreviation" unique("Abbreviation")
);

create sequence if not exists "ForestResources"."SEQ_PermitTypes"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."PermitTypesTable"."Id"
;



create unique index "UX_PermitTypesTable.Name"
on "ForestResources"."PermitTypesTable"
    (
        "Name"
    )
;

create unique index "UX_PermitTypesTable.Abbreviation"
on "ForestResources"."PermitTypesTable"
    (
        "Abbreviation"
    )
;
