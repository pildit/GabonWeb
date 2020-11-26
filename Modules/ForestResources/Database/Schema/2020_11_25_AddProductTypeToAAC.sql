alter table "ForestResources"."AnnualAllowableCutsTable"
	add "ProductType" int default '1';

alter table "ForestResources"."AnnualAllowableCutsTable"
    add constraint "FK_AnnualAllowableCutsTable_ProductType"
        foreign key
            (
             "ProductType"
                )
            references "Taxonomy"."ProductTypeTable"("Id")
;

DROP VIEW "ForestResources"."AnnualAllowableCuts";

create view "ForestResources"."AnnualAllowableCuts"
            ("Id", "Name", "AacId", "ManagementUnit", "ManagementPlan", "Geometry", "ProductType", "Approved", "CreatedAt",
             "UpdatedAt", "DeletedAt")
as
SELECT mut."Id",
       mut."Name",
       mut."AacId",
       mut."ManagementUnit",
       mut."ManagementPlan",
       mut."Geometry",
       mut."ProductType",
       mut."Approved",
       mut."CreatedAt",
       mut."UpdatedAt",
       mut."DeletedAt"
FROM "ForestResources"."AnnualAllowableCutsTable" mut;

alter table "ForestResources"."AnnualAllowableCuts"
    owner to postgres;

CREATE RULE "AnnualAllowableCuts_instead_of_delete" AS
    ON DELETE TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD DELETE
                                                                    FROM "ForestResources"."AnnualAllowableCutsTable"
                                                                    WHERE "AnnualAllowableCutsTable"."Id" = old."Id";

CREATE RULE "AnnualAllowableCuts_instead_of_insert" AS
    ON INSERT TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD INSERT INTO "ForestResources"."AnnualAllowableCutsTable" ("Id",
                                                                                                                              "ResourceType",
                                                                                                                              "Name",
                                                                                                                              "AacId",
                                                                                                                              "ManagementUnit",
                                                                                                                              "ManagementPlan",
                                                                                                                              "Geometry",
                                                                                                                              "ProductType",
                                                                                                                              "Approved",
                                                                                                                              "CreatedAt",
                                                                                                                              "UpdatedAt")
                                                                    VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass),
                                                                            (SELECT rt."Id"
                                                                             FROM "ForestResources"."ResourceTypes" rt
                                                                             WHERE rt."Name" = 'Annual Allowable Cut'::text
                                                                             LIMIT 1), new."Name", new."AacId",
                                                                            new."ManagementUnit", new."ManagementPlan",
                                                                            new."Geometry",new."ProductType", new."Approved",
                                                                            new."CreatedAt", new."UpdatedAt")
                                                                    RETURNING "AnnualAllowableCutsTable"."Id", "AnnualAllowableCutsTable"."Name", "AnnualAllowableCutsTable"."AacId", "AnnualAllowableCutsTable"."ManagementUnit", "AnnualAllowableCutsTable"."ManagementPlan", "AnnualAllowableCutsTable"."Geometry", "AnnualAllowableCutsTable"."ProductType", "AnnualAllowableCutsTable"."Approved", "AnnualAllowableCutsTable"."CreatedAt", "AnnualAllowableCutsTable"."UpdatedAt", "AnnualAllowableCutsTable"."DeletedAt";

CREATE RULE "AnnualAllowableCuts_instead_of_update" AS
    ON UPDATE TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD UPDATE "ForestResources"."AnnualAllowableCutsTable"
                                                                    SET "Name"           = new."Name",
                                                                        "AacId"          = new."AacId",
                                                                        "ManagementUnit" = new."ManagementUnit",
                                                                        "ManagementPlan" = new."ManagementPlan",
                                                                        "Geometry"       = new."Geometry",
                                                                        "ProductType"    = new."ProductType",
                                                                        "Approved"       = new."Approved",
                                                                        "UpdatedAt"      = new."UpdatedAt",
                                                                        "DeletedAt"      = new."DeletedAt"
                                                                    WHERE "AnnualAllowableCutsTable"."Id" = old."Id"
                                                                    RETURNING "AnnualAllowableCutsTable"."Id", "AnnualAllowableCutsTable"."Name", "AnnualAllowableCutsTable"."AacId", "AnnualAllowableCutsTable"."ManagementUnit", "AnnualAllowableCutsTable"."ManagementPlan", "AnnualAllowableCutsTable"."Geometry", "AnnualAllowableCutsTable"."ProductType", "AnnualAllowableCutsTable"."Approved", "AnnualAllowableCutsTable"."CreatedAt", "AnnualAllowableCutsTable"."UpdatedAt", "AnnualAllowableCutsTable"."DeletedAt";

