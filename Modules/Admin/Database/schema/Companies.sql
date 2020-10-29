
DROP TABLE IF EXISTS "Taxonomy"."CompaniesTable" CASCADE ;

CREATE TABLE "Taxonomy"."CompaniesTable"
(
    "Id" serial,
    "Name" character varying(255) COLLATE pg_catalog."default" NOT NULL,
    "GroupName" varchar,
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

DROP VIEW IF EXISTS "Taxonomy"."Companies";

CREATE OR REPLACE VIEW "Taxonomy"."Companies"
AS
SELECT "Id", "Name", "GroupName"
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
    INSERT INTO "Taxonomy"."CompaniesTable"("Name", "GroupName")
    VALUES (new."Name", new."GroupName")
    Returning "Id", "Name", "GroupName";

CREATE or replace rule "Companies_instead_of_update"
    as
    on UPDATE  to "Taxonomy"."Companies"
    do instead
    UPDATE "Taxonomy"."CompaniesTable"
    SET "Name" = new."Name",
        "GroupName" = new."GroupName"
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

-- Seeders

---Seed data into CompanyTypesTable

INSERT INTO "Taxonomy"."CompanyTypesTable" ("Id", "Name") VALUES (1, 'concessionaire');
INSERT INTO "Taxonomy"."CompanyTypesTable" ("Id", "Name") VALUES (2, 'transporter');
INSERT INTO "Taxonomy"."CompanyTypesTable" ("Id", "Name") VALUES (3, 'client');

---Seed data into CompaniesTable

INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('BAYONNE', 'BAYONNE');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('BOKOUE LOBE', 'PAPPFG');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('Bonus Harvest/CIPLAC', 'Rimbunan Hijau');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('Bordamur/Toujours Vert', 'Rimbunan Hijau');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('BSO Mitzic-Nord', 'BSO');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('BSO Ogooué Mitzic', 'BSO');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('BSO Ogooué Ndjolé', 'BSO');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('CAEB', 'CAEB');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('CBG Gamba', 'CBG');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('CBG Mandji', 'CBG');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('CFA/DLH', 'CFA');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('CIFHO Léké', 'Rougier');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('CIFHO Moyabi', 'Rougier');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('CORA Wood', 'CORA Wood');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('CORA Wood', 'CORA Wood');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('CORA Wood LASSIO', 'CORA Wood');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('EFM-SSMO', 'SSMO');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('EGG', 'EGG');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('ENB', 'HUA JIA');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('FDG', 'TBNI');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('FOREEX', 'FOREEX');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('GABON ALONG SARL', 'GABON ALONG SARL');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('GAW/GSEZW-HO/OI', 'OLAM INTERNATIONAL');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('GAW-Ngounié', 'OLAM INTERNATIONAL');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('GEB-ASSALA-CBK', 'GEB-ASSALA-CBK');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('GIB-Tale', 'GIB-Tale');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('GIE OKANO', 'GIE OKANO');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('GIW/GSEZW-Oyem', 'OLAM INTERNATIONAL');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('GIW-Estuaire', 'OLAM INTERNATIONAL');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('GIW-Minvoul', 'OLAM INTERNATIONAL');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('Grand Bois', 'Grand Bois');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('GRANDE MAYUMBA', 'GRANDE MAYUMBA');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('GSEZ/GSEZW-Sud Ngounié', 'OLAM INTERNATIONAL');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('GSEZ-Olam Zolendé', 'OLAM INTERNATIONAL');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('GSEZW-Lambaréné Lacs', 'OLAM INTERNATIONAL');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('HUA JIA', 'Hua Jia');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('IBNG', 'IBNG');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('IFL', 'IFL');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('IMENOU PLATEAU', 'IMENOU PLATEAU');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('Leroy', 'Leroy');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('MEF', 'MEF');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('MPB', 'TBNI');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('NOII', 'NEW ORIENTAL INTERNATIONAL INVESTIMENT');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('OBANGUE', 'OBANGUE');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('OLAM GABON / MOMBA', 'OLAM INTERNATIONAL');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('OLAM Gabon Makokou', 'OLAM GABON');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('OSSIE Industrie', 'OSSIE Industrie');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('PRECIOUS WOOD GABON', 'PRECIOUS WOOD GABON');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('PXS', 'Honest Timber');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('Regroupement FOREEX OKANO/TCBG', 'FOREEX');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('RFM', 'RFM');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('Rimbunan Hijau Gabon', 'Rimbunan Hijau Gabon');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('Rougier Haut Abanga', 'Rougier');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('Rougier Ogooué-Ivindo', 'Rougier');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('SBL/TRB', 'SBL/TRB');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('SEEF', 'SEEF');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('SFIK', 'Rimbunan Hijau');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('SIEB', 'SIEB');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('SNBG', 'SNBG-OVG');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('SNBG-OVG', 'SNBG-OVG');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('STIBG', 'STIBG');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('SUNLY GABON Centre Sud', 'SUNLY');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('SUNLY OKONDJA', 'COFCO');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('SUNRY GABON Nord Est', 'SUNLY');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('TALIBOIS', 'TALIBOIS');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('TAURIAN', 'TAURIAN');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('TBNI', 'TBNI');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('TLP', 'HUA JIA');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('TTIB', 'TTIB');
INSERT INTO "Taxonomy"."CompaniesTable" ("Name", "GroupName") VALUES ('WCTS', 'Honest Timber');

--- Seed data into CompanyHasTypesTable

INSERT INTO "Taxonomy"."CompanyHasTypesTable"("CompanyId", "CompanyTypeId")
SELECT cmp."Id", type."Id"
FROM "Taxonomy"."CompaniesTable" cmp, "Taxonomy"."CompanyTypesTable" type
