drop table "ForestResources"."InventoryQualitiesTable" cascade;
create table "ForestResources"."InventoryQualitiesTable"
(
    "Id"          serial                              not null
        constraint "PK_ForestResources.InventoryQualitiesTable"
            primary key,
    "Description" text
        constraint "UNIQ_ForestResources.InventoryQualitiesTable.Description"
            unique
        constraint "CHK_ForestResources.InventoryQualitiesTable.Description"
            check (("Description" IS NULL) OR (length("Description") > 0)),
    "Value"       integer                             not null
        constraint "UNIQ_ForestResources.InventoryQualitiesTable.Value"
            unique,
    "User"      integer,
    "CreatedAt"   timestamp default CURRENT_TIMESTAMP not null,
    "UpdatedAt"   timestamp default CURRENT_TIMESTAMP not null,
    "DeletedAt"   timestamp
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

INSERT INTO "ForestResources"."InventoryQualitiesTable" ("Id", "Description", "Value", "User") VALUES (0, '1', 1, null);
INSERT INTO "ForestResources"."InventoryQualitiesTable" ("Id", "Description", "Value", "User") VALUES (1, '3', 3, null);
INSERT INTO "ForestResources"."InventoryQualitiesTable" ("Id", "Description", "Value", "User") VALUES (2, '2', 2, null);
INSERT INTO "ForestResources"."InventoryQualitiesTable" ("Id", "Description", "Value", "User") VALUES (3, '4', 4, null);

