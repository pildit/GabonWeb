-- drop view if exists admin."Accounts";
create or replace view admin."Accounts" as
select acc.id,
       acc.firstname,
       acc.password,
       acc.email,
       acc.lastname,
       acc.activationcode,
       acc.status,
       acc.employee_type,
       acc.created_at,
       acc.updated_at,
       acc.company_id,
       com."Name" as company_name,
       acc.deleted_at
from admin.accounts acc
left join "Taxonomy"."CompaniesTable" com on acc.company_id = com."Id";


CREATE OR REPLACE RULE "accounts_instead_of_delete" AS
    ON DELETE TO "admin"."Accounts" DO INSTEAD
    DELETE
    FROM "admin"."accounts"
    WHERE "accounts"."id" = old."id";

CREATE OR REPLACE RULE "accounts_insted_of_insert" AS
    ON INSERT TO "admin"."Accounts" DO INSTEAD
    INSERT INTO "admin"."accounts" (id, firstname, password, email, lastname, activationcode, status, employee_type, created_at, updated_at, company_id)
    VALUES (
               nextval('"admin"."accounts_id_seq"'::regclass),
            new."firstname",
            new."password",
            new."email",
            new."lastname",
            new."activationcode",
            new."status",
            new."employee_type",
            new."created_at",
            new."updated_at",
            new."company_id"
            )
            RETURNING
                "accounts".id,
                "accounts"."firstname",
                "accounts"."password",
                "accounts"."email",
                "accounts"."lastname",
                "accounts"."activationcode",
                "accounts"."status",
                "accounts"."employee_type",
                "accounts"."created_at",
                "accounts"."updated_at",
                "accounts"."company_id",
                (select com."Name" from "Taxonomy"."CompaniesTable" com where accounts."company_id" = com."Id" limit 1),
                "accounts"."deleted_at";

CREATE OR REPLACE RULE "accounts_instead_of_update" AS
    ON UPDATE TO "admin"."Accounts" DO INSTEAD
    UPDATE "admin"."accounts"
    SET "id"           = new."id",
        "firstname" = new."firstname",
        "password" = new."password",
        "email" = new."email",
        "lastname" = new."lastname",
        "activationcode" = new."activationcode",
        "status" = new."status",
        "employee_type" = new."employee_type",
        "created_at" = new."created_at",
        "updated_at" = new."updated_at",
        "deleted_at" = new."deleted_at",
        "company_id" = new."company_id"
    WHERE "accounts"."id" = old."id"
    RETURNING
        "accounts".id,
        "accounts"."firstname",
        "accounts"."password",
        "accounts"."email",
        "accounts"."lastname",
        "accounts"."activationcode",
        "accounts"."status",
        "accounts"."employee_type",
        "accounts"."created_at",
        "accounts"."updated_at",
        "accounts"."company_id",
        (select com."Name" from "Taxonomy"."CompaniesTable" com where accounts."company_id" = com."Id" limit 1),
        "accounts"."deleted_at";
