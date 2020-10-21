-------------------------------------
-- "ForestResources"."Parcels" --
-------------------------------------
create table "ForestResources"."ParcelsTable"
(
    constraint "PK_ParcelsTable" primary key("Id")
)
inherits ("ForestResources"."BaseResourcesTable")
;

comment on table "ForestResources"."ParcelsTable"
    is 'Parcels';

create unique index "UX_ParcelsTable.Name"
on "ForestResources"."ParcelsTable"
    (
        "Name"
    )
;
