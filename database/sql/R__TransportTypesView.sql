create or replace view "Transportation"."TransportTypes"("Id", "Name", "Parent") as
SELECT "TransportTypesTable"."Id",
       "TransportTypesTable"."Name",
       "TransportTypesTable"."Parent"
FROM "Transportation"."TransportTypesTable";


CREATE OR REPLACE RULE "TransportTypes_instead_of_delete" AS
    ON DELETE TO "Transportation"."TransportTypes" DO INSTEAD DELETE
                                                      FROM "Transportation"."TransportTypesTable"
                                                      WHERE "TransportTypesTable"."Id" = old."Id";

CREATE OR REPLACE RULE "TransportTypes_instead_of_insert" AS
    ON INSERT TO "Transportation"."TransportTypes" DO INSTEAD INSERT INTO "Transportation"."TransportTypesTable" ("Name","Parent")
                                                      VALUES (new."Name",new."Parent")
                                                      RETURNING "TransportTypesTable"."Id", "TransportTypesTable"."Name", "TransportTypesTable"."Parent";

CREATE OR REPLACE RULE "TransportTypes_instead_of_update" AS
    ON UPDATE TO "Transportation"."TransportTypes" DO INSTEAD UPDATE "Transportation"."TransportTypesTable"
                                                      SET "Name" = new."Name",
                                                       "Parent" = new."Parent"
                                                      WHERE "TransportTypesTable"."Id" = old."Id";

