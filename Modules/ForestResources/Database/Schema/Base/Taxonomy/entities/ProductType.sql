
create table "Taxonomy"."ProductTypeTable"
(
    "Id"        serial not null primary key,
    "Name"      varchar,
    "CreatedAt" timestamp,
    "UpdatedAt" timestamp,
    "UserId"    integer
);


create view "Taxonomy"."ProductType"("Id", "Name", "CreatedAt", "UpdatedAt", "UserId") as
SELECT "Taxonomy"."ProductTypeTable"."Id",
       "Taxonomy"."ProductTypeTable"."Name",
       "Taxonomy"."ProductTypeTable"."CreatedAt",
       "Taxonomy"."ProductTypeTable"."UpdatedAt",
       "Taxonomy"."ProductTypeTable"."UserId"
FROM "Taxonomy"."ProductTypeTable";


CREATE RULE "ProductType_instead_of_delete" AS
    ON DELETE TO "Taxonomy"."ProductType" DO INSTEAD  DELETE FROM "Taxonomy"."ProductTypeTable"
  WHERE "Taxonomy"."ProductTypeTable"."Id" = old."Id";


CREATE RULE "ProductType_instead_of_insert" AS
    ON INSERT TO "Taxonomy"."ProductType" DO INSTEAD
    INSERT INTO "Taxonomy"."ProductTypeTable" ("Name", "UserId")
      VALUES (new."Name",  new."UserId")
      RETURNING "Taxonomy"."ProductTypeTable"."Id",
          "Taxonomy"."ProductTypeTable"."Name",
          "Taxonomy"."ProductTypeTable"."CreatedAt",
          "Taxonomy"."ProductTypeTable"."UpdatedAt",
          "Taxonomy"."ProductTypeTable"."UserId";


CREATE RULE "ProductType_instead_of_update" AS
    ON UPDATE TO "Taxonomy"."ProductType"
    DO INSTEAD  UPDATE "Taxonomy"."ProductTypeTable"
    SET "Name" = new."Name"
  WHERE "ProductTypeTable"."Id" = old."Id"
  RETURNING "Taxonomy"."ProductTypeTable"."Id",
      "Taxonomy"."ProductTypeTable"."Name",
      "Taxonomy"."ProductTypeTable"."CreatedAt",
      "Taxonomy"."ProductTypeTable"."UpdatedAt",
      "Taxonomy"."ProductTypeTable"."UserId";
