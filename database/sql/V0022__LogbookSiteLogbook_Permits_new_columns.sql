drop view if exists "ForestResources"."SiteLogbooks";
drop view if exists "ForestResources"."Logbooks";
drop view if exists "Transportation"."Permits";

alter table "ForestResources"."SiteLogbooksTable"
	add if not exists "SiteLogBookName" varchar(255);

alter table "ForestResources"."LogbooksTable"
	add if not exists "LogBookName" varchar(255);

alter table "Transportation"."PermitsTable"
	add if not exists "ImgFront" varchar(255);

alter table "Transportation"."PermitsTable"
	add if not exists "ImgBack" varchar(255);

alter table "Transportation"."PermitsTable"
	add if not exists "ImgSide" varchar(255);
