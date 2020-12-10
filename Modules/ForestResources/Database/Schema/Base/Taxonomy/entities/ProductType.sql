
create table "Taxonomy"."ProductTypeTable"
(
    "Id"        serial not null
        constraint producttypetable_pk
            primary key,
    "Name"      varchar,
    "CreatedAt" timestamp(0),
    "UpdatedAt" timestamp(0),
    "User"    integer,
    "Deleted" timestamp(0)
);


create or replace view "Taxonomy"."ProductType" as
SELECT "ProductTypeTable"."Id",
       "ProductTypeTable"."Name",
        "ProductTypeTable"."User",
        acc.email as Email,
       "ProductTypeTable"."CreatedAt",
       "ProductTypeTable"."UpdatedAt",
       "ProductTypeTable"."DeletedAt"
FROM "Taxonomy"."ProductTypeTable"
left join admin.accounts on "ProductTypeTable".User = acc.id;


CREATE or replace RULE "ProductType_instead_of_delete" AS
    ON DELETE TO "Taxonomy"."ProductType" DO INSTEAD  DELETE FROM "Taxonomy"."ProductTypeTable"
                                                      WHERE "ProductTypeTable"."Id" = old."Id";


CREATE or replace RULE "ProductType_instead_of_insert" AS
    ON INSERT TO "Taxonomy"."ProductType" DO INSTEAD  INSERT INTO "Taxonomy"."ProductTypeTable" ("Name", "User", "CreatedAt")
                                                      VALUES (new."Name", new."User", new."CreatedAt")
                                                      RETURNING "ProductTypeTable"."Id",
                                                          "ProductTypeTable"."Name",
                                                          "ProductTypeTable"."User",
                                                          (select acc.email from admin.accounts acc where "ProductTypeTable".User = acc.id limit 1),
                                                          "ProductTypeTable"."CreatedAt",
                                                          "ProductTypeTable"."UpdatedAt",
                                                          "ProductTypeTable"."DeletedAt",





CREATE or replace RULE "ProductType_instead_of_update" AS
    ON UPDATE TO "Taxonomy"."ProductType"
    DO INSTEAD  UPDATE "Taxonomy"."ProductTypeTable"
                SET "Name" = new."Name",
                    "UpdatedAt" = new."UpdatedAt",
                    "DeletedAt" = new."DeletedAt"
                WHERE "ProductTypeTable"."Id" = old."Id"
                RETURNING "ProductTypeTable"."Id",
                    "ProductTypeTable"."Name",
                    "ProductTypeTable"."User",
                    (select acc.email from admin.accounts acc where "ProductTypeTable".User = acc.id limit 1),
                    "ProductTypeTable"."CreatedAt",
                    "ProductTypeTable"."UpdatedAt",
                    "ProductTypeTable"."DeletedAt";

insert into "Taxonomy"."ProductType" ("Id", "Name", "CreatedAt", "UpdatedAt", "User") values (1, 'Log', now(), now(), null);
