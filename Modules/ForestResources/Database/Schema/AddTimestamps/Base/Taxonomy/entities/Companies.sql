
DROP TABLE IF EXISTS "Taxonomy"."CompaniesTable" CASCADE ;

CREATE TABLE "Taxonomy"."CompaniesTable"
(
    "Id" serial,
    "Name" character varying(255) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT companies_pkey PRIMARY KEY ("Id")
);

DROP TABLE IF EXISTS  "Taxonomy"."CompanyTypesTable" CASCADE ;

CREATE TABLE "Taxonomy"."CompanyTypesTable"
(
    "Id" serial,
    "Name" character varying(255) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT company_types_pkey PRIMARY KEY ("Id")
);

DROP TABLE IF EXISTS "Taxonomy"."CompanyHasTypesTable";

CREATE TABLE "Taxonomy"."CompanyHasTypesTable"
(
    "CompanyId" integer NOT NULL,
    "CompanyTypeId" integer NOT NULL
);

CREATE OR REPLACE VIEW "Taxonomy"."Companies"
AS
SELECT "Id", "Name"
FROM "Taxonomy"."CompaniesTable";

CREATE OR REPLACE VIEW "Taxonomy"."CompanyTypes"
AS
SELECT "Id", "Name"
FROM "Taxonomy"."CompanyTypesTable";



---RULES ---


create or replace rule "Companies_instead_of_delete"
    as
    on delete to "Taxonomy"."Companies"
    do instead
    delete from "Taxonomy"."CompaniesTable"
    where "Taxonomy"."CompaniesTable"."Id" = old."Id"
;

CREATE or replace rule "Companies_instead_of_insert"
    as
    on insert  to "Taxonomy"."Companies"
    do instead
    INSERT INTO "Taxonomy"."CompaniesTable"("Name")
    VALUES (new."Name")
    Returning "Id", "Name";

CREATE or replace rule "Companies_instead_of_update"
    as
    on UPDATE  to "Taxonomy"."Companies"
    do instead
    UPDATE "Taxonomy"."CompaniesTable"
    SET "Name" = new."Name"
    WHERE "Id" = old."Id";


create or replace rule "CompanyTypes_instead_of_delete"
    as
    on delete to "Taxonomy"."CompanyTypes"
    do instead
    delete from "Taxonomy"."CompanyTypesTable"
    where "Taxonomy"."CompanyTypesTable"."Id" = old."Id"
;

CREATE or replace rule "CompanyTypes_instead_of_insert"
    as
    on insert  to "Taxonomy"."CompanyTypes"
    do instead
    INSERT INTO "Taxonomy"."CompanyTypesTable"("Name")
    VALUES (new."Name")
    Returning "Id", "Name";

CREATE or replace rule "CompanyTypes_instead_of_update"
    as
    on UPDATE  to "Taxonomy"."CompanyTypes"
    do instead
    UPDATE "Taxonomy"."CompanyTypesTable"
    SET "Name" = new."Name"
    WHERE "Id" = old."Id";
