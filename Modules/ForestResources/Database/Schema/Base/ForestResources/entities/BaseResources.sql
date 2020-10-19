----------------------------------------
-- "ForestResources"."BaseResources"  --
----------------------------------------
create table "ForestResources"."BaseResourcesTable"
(
    "Id" int not null,
    "ResourceType" int not null,    -- NOTE: implementation detail
    "Name" text not null,
    "Geometry" geometry not null,
    constraint "PK_BaseResourcesTable" primary key ("Id"),
    constraint "CHK_BaseResourcesTable.Name" check (length("Name") > 0)
)
;

create sequence if not exists "ForestResources"."SEQ_BaseResources"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."BaseResourcesTable"."Id"
;

create index "IX_BaseResourcesTable.Name"
on "ForestResources"."BaseResourcesTable"
    (
        "Name"
    )
;

create index "IX_BaseResourcesTable.ResourceType"
on "ForestResources"."BaseResourcesTable"
    (
        "ResourceType"
    )
;
