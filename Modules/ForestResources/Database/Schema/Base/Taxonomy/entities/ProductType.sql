
create table "Taxonomy"."ProductTypeTable"
(
    "Id"        serial not null
        constraint producttypetable_pk
            primary key,
    "Name"      varchar,
    "CreatedAt" timestamp,
    "UpdatedAt" timestamp,
    "UserId"    integer
);


create or replace view "Taxonomy"."ProductType"("Id", "Name", "CreatedAt", "UpdatedAt", "UserId") as
SELECT "ProductTypeTable"."Id",
       "ProductTypeTable"."Name",
       "ProductTypeTable"."CreatedAt",
       "ProductTypeTable"."UpdatedAt",
       "ProductTypeTable"."UserId"
FROM "Taxonomy"."ProductTypeTable";


CREATE or replace RULE "ProductType_instead_of_delete" AS
    ON DELETE TO "Taxonomy"."ProductType" DO INSTEAD  DELETE FROM "Taxonomy"."ProductTypeTable"
                                                      WHERE "ProductTypeTable"."Id" = old."Id";


CREATE or replace RULE "ProductType_instead_of_insert" AS
    ON INSERT TO "Taxonomy"."ProductType" DO INSTEAD  INSERT INTO "Taxonomy"."ProductTypeTable" ("Name", "UserId", "CreatedAt")
                                                      VALUES (new."Name", new."UserId", new."CreatedAt")
                                                      RETURNING "ProductTypeTable"."Id",
                                                          "ProductTypeTable"."Name",
                                                          "ProductTypeTable"."CreatedAt",
                                                          "ProductTypeTable"."UpdatedAt",
                                                          "ProductTypeTable"."UserId";




CREATE or replace RULE "ProductType_instead_of_update" AS
    ON UPDATE TO "Taxonomy"."ProductType"
    DO INSTEAD  UPDATE "Taxonomy"."ProductTypeTable"
                SET "Name" = new."Name"
                WHERE "ProductTypeTable"."Id" = old."Id"
                RETURNING "ProductTypeTable"."Id",
                    "ProductTypeTable"."Name",
                    "ProductTypeTable"."CreatedAt",
                    "ProductTypeTable"."UpdatedAt",
                    "ProductTypeTable"."UserId";

insert into "Taxonomy"."ProductType" ("Id", "Name", "CreatedAt", "UpdatedAt", "UserId") values (1, 'Log', now(), now(), null);
