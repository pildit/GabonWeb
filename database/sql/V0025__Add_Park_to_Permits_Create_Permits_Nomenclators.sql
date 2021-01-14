create table "Transportation"."TransportTypesTable"
(
	"Id" serial
		constraint transporttypestable_pk
			primary key,
	"Name" varchar(255) not null,
	"Parent" int default 0
);

create table "Transportation"."ParkTypesTable"
(
	"Id" serial
		constraint parktypestable_pk
			primary key,
	"Name" varchar(255) not null
);

drop view if exists "Transportation"."Permits";

alter table "Transportation"."PermitsTable"
	add "Park" int;

ALTER TABLE ONLY "Transportation"."PermitsTable"
    ADD CONSTRAINT "FK_PermitsTable_Park" FOREIGN KEY ("Park") REFERENCES "Transportation"."ParkTypesTable"("Id");
