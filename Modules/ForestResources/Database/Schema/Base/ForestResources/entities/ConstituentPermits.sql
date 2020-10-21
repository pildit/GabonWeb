create table "ForestResources"."ConstituentPermitsTable"
(
    "Id" int not null,
    "User" int not null,
    "PermitType" int not null,
    "PermitNumber" text not null,
    "Geometry" geometry not null,
    constraint "PK_ConstituentPermitsTable" primary key("Id"),
    constraint "CHK_ConstituentPermitsTable_PermitNumber" check (length("PermitNumber") > 0)
)
;


create sequence if not exists "ForestResources"."SEQ_ConstituentPermits"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."ConstituentPermitsTable"."Id"
;


create index "IX_ConstituentPermitsTable.Name"
on "ForestResources"."ConstituentPermitsTable"
    (
        "User"
    )
;


create index "IX_ConstituentPermitsTable.PermitType"
on "ForestResources"."ConstituentPermitsTable"
    (
        "PermitType"
    )
;
