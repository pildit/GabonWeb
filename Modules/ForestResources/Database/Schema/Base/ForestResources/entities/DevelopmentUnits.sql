------------------------------------------
-- "ForestResources"."DevelopmentUnits" --
------------------------------------------
create table "ForestResources"."DevelopmentUnitsTable"
(
    "Concession" int null,
    "Start" date not null,
    "End" date not null,
    constraint "PK_DevelopmentUnitsTable" primary key ("Id"),
    constraint "CHK_DevelopmentUnitsTable_start_lte_end" check ("Start" <= "End")
)
inherits ("ForestResources"."BaseResourcesTable")
;

comment on table "ForestResources"."DevelopmentUnitsTable"
    is 'Unite Forestiere d''Amenagement (UFA)';


-- If you query by name, you are likely to filter by parent concession as well, not just name
create index "IX_DevelopmentUnitsTable.Name_Concession"
on "ForestResources"."DevelopmentUnitsTable"
    (
        "Name"
        , "Concession"
    )
;

create index "IX_DevelopmentUnitsTable.Concession"
on "ForestResources"."DevelopmentUnitsTable"
    (
        "Concession"
    )
;
