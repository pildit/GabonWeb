----------
-- VIEW --
----------
create or replace view "ForestResources"."AnnualAllowableCutInventory"
as
select
    aacit."Id",
    aacit."AnnualAllowableCut",
    aacit."Species",
    aacit."Quality",
    aacit."Parcel",
    aacit."TreeId",
    aacit."DiameterBreastHeight",
    aacit."Geometry",
    aacit."CreatedAt",
    aacit."UpdatedAt",
    aacit."DeletedAt"
from "ForestResources"."AnnualAllowableCutInventoryTable" as aacit
;

-----------
-- RULES --
-----------
create or replace rule "AnnualAllowableCutInventory_instead_of_delete"
    as
    on delete to "ForestResources"."AnnualAllowableCutInventory"
    do instead
    delete from "ForestResources"."AnnualAllowableCutInventoryTable"
    where
            "ForestResources"."AnnualAllowableCutInventoryTable"."Id" = old."Id"
;

create or replace rule "AnnualAllowableCutInventory_instead_of_insert"
    as
    on insert to "ForestResources"."AnnualAllowableCutInventory"
    do instead
    insert into "ForestResources"."AnnualAllowableCutInventoryTable"
    (
        "Id",
        "AnnualAllowableCut",
        "Species",
        "Quality",
        "Parcel",
        "TreeId",
        "DiameterBreastHeight",
        "Geometry",
        "CreatedAt",
        "UpdatedAt"
    )
    values
    (
        nextval('"ForestResources"."SEQ_AnnualAllowableCutInventory"'),
        new."AnnualAllowableCut",
        new."Species",
        new."Quality",
        new."Parcel",
        new."TreeId",
        new."DiameterBreastHeight",
        new."Geometry",
        new."CreatedAt",
        new."UpdatedAt"
    )
    returning
        "Id",
        "AnnualAllowableCut",
        "Species",
        "Quality",
        "Parcel",
        "TreeId",
        "DiameterBreastHeight",
        "Geometry",
        "CreatedAt",
        "UpdatedAt",
        "DeletedAt"
;

create or replace rule "AnnualAllowableCutInventory_instead_of_update"
    as
    on update to "ForestResources"."AnnualAllowableCutInventory"
    do instead
    update "ForestResources"."AnnualAllowableCutInventoryTable"
    set
        "AnnualAllowableCut" = new."AnnualAllowableCut",
        "Species" = new."Species",
        "Quality" = new."Quality",
        "Parcel" = new."Parcel",
        "TreeId" = new."TreeId",
        "DiameterBreastHeight" = new."DiameterBreastHeight",
        "Geometry" = new."Geometry",
        "UpdatedAt" = new."UpdatedAt",
        "DeletedAt" = new."DeletedAt"
    where
            "Id" = old."Id"
    returning
        "Id",
        "AnnualAllowableCut",
        "Species",
        "Quality",
        "Parcel",
        "TreeId",
        "DiameterBreastHeight",
        "Geometry",
        "CreatedAt",
        "UpdatedAt",
        "DeletedAt"
;
