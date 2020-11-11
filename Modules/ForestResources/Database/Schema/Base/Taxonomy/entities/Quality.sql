create table "QualityTable"
(
    "Id"          serial  not null
        constraint quality_pk
            primary key,
    "Value"       varchar not null,
    "Description" varchar,
    "CreatedAt"   timestamp,
    "UpdatedAt"   timestamp,
    "UserId"      integer
);


create view "Quality"("Id", "Value", "Description", "CreatedAt", "UpdatedAt", "UserId") as
SELECT "QualityTable"."Id",
       "QualityTable"."Value",
       "QualityTable"."Description",
       "QualityTable"."CreatedAt",
       "QualityTable"."UpdatedAt",
       "QualityTable"."UserId"
FROM "Taxonomy"."QualityTable";

alter table "Quality"
    owner to pildit;

CREATE RULE "Quality_instead_of_insert" AS
    ON INSERT TO "Taxonomy"."Quality" DO INSTEAD
    INSERT INTO "Taxonomy"."QualityTable" ("Value", "Description", "UserId")
    VALUES (new."Value", new."Description", new."UserId")
    RETURNING "QualityTable"."Id",
        "QualityTable"."Value",
        "QualityTable"."Description",
        "QualityTable"."CreatedAt",
        "QualityTable"."UpdatedAt",
        "QualityTable"."UserId";


CREATE RULE "Quality_instead_of_delete" AS
    ON DELETE TO "Taxonomy"."Quality" DO INSTEAD  DELETE FROM "Taxonomy"."QualityTable"
                                                  WHERE "QualityTable"."Id" = old."Id";

CREATE RULE "Quality_instead_of_update" AS
    ON UPDATE TO "Taxonomy"."Quality" DO INSTEAD
    UPDATE "Taxonomy"."QualityTable"
    SET "Value" = new."Value",
        "Description" = new."Description"
  WHERE "QualityTable"."Id" = old."Id"
    RETURNING "QualityTable"."Id",
        "QualityTable"."Value",
        "QualityTable"."Description",
        "QualityTable"."CreatedAt",
        "QualityTable"."UpdatedAt",
        "QualityTable"."UserId";


