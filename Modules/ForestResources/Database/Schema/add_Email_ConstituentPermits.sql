DROP VIEW IF EXISTS "ForestResources"."ConstituentPermits";

--
-- Name: ConstituentPermits; Type: VIEW; Schema: ForestResources; Owner: pildit
--

CREATE VIEW "ForestResources"."ConstituentPermits" AS
 SELECT cpt."Id",
    cpt."User",
    acc."email" as "Email",
	cpt."PermitType",
    cpt."PermitNumber",
    cpt."Geometry",
    cpt."deleted_at"
   FROM "ForestResources"."ConstituentPermitsTable" cpt, "admin"."accounts" acc
   WHERE cpt."User" = acc."id" ;



--
-- Name: ConstituentPermits ConstituentPermits_instead_of_delete; Type: RULE; Schema: ForestResources; Owner: pildit
--

CREATE RULE "ConstituentPermits_instead_of_delete" AS
    ON DELETE TO "ForestResources"."ConstituentPermits" DO INSTEAD  DELETE FROM "ForestResources"."ConstituentPermitsTable"
  WHERE ("ConstituentPermitsTable"."Id" = old."Id");


--
-- Name: ConstituentPermits ConstituentPermits_instead_of_insert; Type: RULE; Schema: ForestResources; Owner: pildit
--

CREATE RULE "ConstituentPermits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."ConstituentPermits" DO INSTEAD  INSERT INTO "ForestResources"."ConstituentPermitsTable" ("Id", "User", "PermitType", "PermitNumber", "Geometry")
  VALUES (nextval('"ForestResources"."SEQ_ConstituentPermits"'::regclass), new."User", new."PermitType", new."PermitNumber", new."Geometry")
  RETURNING "ConstituentPermitsTable"."Id",
    "ConstituentPermitsTable"."User",
    (SELECT acc."email" FROM "admin"."accounts" acc WHERE "ForestResources"."ConstituentPermitsTable"."User" = acc.id),
	"ConstituentPermitsTable"."PermitType",
    "ConstituentPermitsTable"."PermitNumber",
    "ConstituentPermitsTable"."Geometry",
    "ConstituentPermitsTable"."deleted_at";


--
-- Name: ConstituentPermits ConstituentPermits_instead_of_update; Type: RULE; Schema: ForestResources; Owner: pildit
--

CREATE RULE "ConstituentPermits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."ConstituentPermits" DO INSTEAD  
    UPDATE "ForestResources"."ConstituentPermitsTable" 
    SET "User" = new."User", 
        "PermitType" = new."PermitType", 
        "PermitNumber" = new."PermitNumber", 
        "Geometry" = new."Geometry",
        "deleted_at" = new."deleted_at"
  WHERE ("ConstituentPermitsTable"."Id" = old."Id")
  RETURNING "ConstituentPermitsTable"."Id",
    "ConstituentPermitsTable"."User",
    (SELECT acc."email" FROM "admin"."accounts" acc WHERE "ForestResources"."ConstituentPermitsTable"."User" = acc.id),
  "ConstituentPermitsTable"."PermitType",
    "ConstituentPermitsTable"."PermitNumber",
    "ConstituentPermitsTable"."Geometry",
    "ConstituentPermitsTable"."deleted_at";
