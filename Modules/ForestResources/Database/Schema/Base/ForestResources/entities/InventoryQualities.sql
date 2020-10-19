create table "ForestResources"."InventoryQualitiesTable"
(
    "Id" int not null,
    "Description" text null,
    "Value" int not null,
    constraint "PK_ForestResources.InventoryQualitiesTable" primary key("Id"),
    constraint "CHK_ForestResources.InventoryQualitiesTable.Description" check ("Description" is null or length("Description") > 0),
    constraint "UNIQ_ForestResources.InventoryQualitiesTable.Description" unique("Description"),
    constraint "UNIQ_ForestResources.InventoryQualitiesTable.Value" unique("Value")
);

create sequence if not exists "ForestResources"."SEQ_InventoryQualities"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."InventoryQualitiesTable"."Id"
;



create unique index "UX_InventoryQualitiesTable.Description"
on "ForestResources"."InventoryQualitiesTable"
    (
        "Description"
    )
;

create unique index "UX_InventoryQualitiesTable.Value"
on "ForestResources"."InventoryQualitiesTable"
    (
        "Value"
    )
;
