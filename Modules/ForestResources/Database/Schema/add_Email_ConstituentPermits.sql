DROP VIEW IF EXISTS "ForestResources"."ConstituentPermits";

--
-- Name: ConstituentPermits; Type: VIEW; Schema: ForestResources; Owner: pildit
--

CREATE VIEW "ForestResources"."ConstituentPermits" AS
SELECT cpt."Id",
       cpt."User",
       acc.email AS "Email",
       cpt."PermitType",
       cpt."PermitNumber",
       cpt."Geometry",
       cpt."Approved",
       cpt."CreatedAt",
       cpt."UpdatedAt",
       cpt."DeletedAt"
FROM "ForestResources"."ConstituentPermitsTable" cpt left join
     admin.accounts acc on cpt."User" = acc.id;



--
-- Name: ConstituentPermits ConstituentPermits_instead_of_delete; Type: RULE; Schema: ForestResources; Owner: pildit
--

CREATE or replace RULE "ConstituentPermits_instead_of_delete" AS
    ON DELETE TO "ForestResources"."ConstituentPermits" DO INSTEAD  DELETE FROM "ForestResources"."ConstituentPermitsTable"
  WHERE ("ConstituentPermitsTable"."Id" = old."Id");


--
-- Name: ConstituentPermits ConstituentPermits_instead_of_insert; Type: RULE; Schema: ForestResources; Owner: pildit
--

CREATE or replace RULE "ConstituentPermits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."ConstituentPermits"
    DO INSTEAD  INSERT INTO "ForestResources"."ConstituentPermitsTable"
        ("Id", "User", "PermitType", "PermitNumber", "Geometry", "CreatedAt")
  VALUES
         (
          nextval('"ForestResources"."SEQ_ConstituentPermits"'::regclass),
          new."User",
          new."PermitType",
          new."PermitNumber",
          new."Geometry",
          new."CreatedAt"
          )
  RETURNING
      "Id",
      "User",
      (SELECT acc."email" FROM "admin"."accounts" acc WHERE "ForestResources"."ConstituentPermitsTable"."User" = acc.id),
	  "PermitType",
      "PermitNumber",
      "Geometry",
      "CreatedAt",
      "UpdatedAt",
      "DeletedAt";


--
-- Name: ConstituentPermits ConstituentPermits_instead_of_update; Type: RULE; Schema: ForestResources; Owner: pildit
--

CREATE or replace RULE "ConstituentPermits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."ConstituentPermits" DO INSTEAD
    UPDATE "ForestResources"."ConstituentPermitsTable"
    SET "User" = new."User",
        "PermitType" = new."PermitType",
        "PermitNumber" = new."PermitNumber",
        "Geometry" = new."Geometry",
        "UpdatedAt" = new."UpdatedAt",
        "DeletedAt" = new."DeletedAt"
  WHERE ("ConstituentPermitsTable"."Id" = old."Id")
  RETURNING
        "Id",
        "User",
        (SELECT acc."email" FROM "admin"."accounts" acc WHERE "ForestResources"."ConstituentPermitsTable"."User" = acc.id),
        "PermitType",
        "PermitNumber",
        "Geometry",
        "CreatedAt",
        "UpdatedAt",
        "DeletedAt";
