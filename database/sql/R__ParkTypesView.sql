create or replace view "Transportation"."ParkTypes"("Id", "Name") as
SELECT "ParkTypesTable"."Id",
       "ParkTypesTable"."Name"
FROM "Transportation"."ParkTypesTable";


CREATE OR REPLACE RULE "ParkTypes_instead_of_delete" AS
    ON DELETE TO "Transportation"."ParkTypes" DO INSTEAD DELETE
                                                      FROM "Transportation"."ParkTypesTable"
                                                      WHERE "ParkTypesTable"."Id" = old."Id";

CREATE OR REPLACE RULE "ParkTypes_instead_of_insert" AS
    ON INSERT TO "Transportation"."ParkTypes" DO INSTEAD INSERT INTO "Transportation"."ParkTypesTable" ("Name")
                                                      VALUES (new."Name")
                                                      RETURNING "ParkTypesTable"."Id", "ParkTypesTable"."Name";

CREATE OR REPLACE RULE "ParkTypes_instead_of_update" AS
    ON UPDATE TO "Transportation"."ParkTypes" DO INSTEAD UPDATE "Transportation"."ParkTypesTable"
                                                      SET "Name" = new."Name"
                                                      WHERE "ParkTypesTable"."Id" = old."Id";

