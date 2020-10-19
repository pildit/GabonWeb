alter table "ForestResources"."AnnualAllowableCutsTable"
	add "ManagementPlan" integer;

alter table "ForestResources"."AnnualAllowableCutsTable"
	add constraint "FK_AnnualAllowableCutsTable_ManagementPlan"
		foreign key ("ManagementPlan") references "ForestResources"."ManagementPlansTable";

alter table "ForestResources"."AnnualAllowableCutsTable"
	add "AacId" text not null;
