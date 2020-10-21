create table "ForestResources"."AnnualAllowableCutInventoryTable"
(
    "Id" int not null,
    "AnnualAllowableCut" int not null,
    "Species" int not null,
    "Quality" int not null,
    "Parcel" int not null,
    "TreeId" text not null,
    "DiameterBreastHeight" decimal(8,3) not null,
    "Geometry" polygon not null,
    constraint "PK_AnnualAllowableCutInventoryTable" primary key("Id"),
    constraint "CHK_AnnualAllowableCutInventoryTable.TreeId" check (length("TreeId") > 0),
    constraint "CHK_AnnualAllowableCutInventoryTable.DiameterBreastHeight" check ("DiameterBreastHeight" >= 0),
    constraint "UNIQ_AnnualAllowableCutInventoryTable.AnnualAllowableCut_TreeId" unique ("AnnualAllowableCut", "TreeId")
)
;

create sequence if not exists "ForestResources"."SEQ_AnnualAllowableCutInventory"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."AnnualAllowableCutInventoryTable"."Id"
;

create index "IX_AnnualAllowableCutInventoryTable.AnnualAllowableCut_Species"
on "ForestResources"."AnnualAllowableCutInventoryTable"
    (
        "AnnualAllowableCut"
        , "Species"
    )
;

create index "IX_AnnualAllowableCutInventoryTable.AnnualAllowableCut_TreeId"
on "ForestResources"."AnnualAllowableCutInventoryTable"
    (
        "AnnualAllowableCut"
        , "TreeId"
    )
;

create index "IX_AnnualAllowableCutInventoryTable.AnnualAllowableCut"
on "ForestResources"."AnnualAllowableCutInventoryTable"
    (
        "AnnualAllowableCut"
    )
;
