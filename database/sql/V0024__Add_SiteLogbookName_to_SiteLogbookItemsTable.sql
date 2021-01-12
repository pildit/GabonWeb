alter table "ForestResources"."SiteLogbookItemsTable"
	add if not exists "SiteLogBookName" varchar(255);
