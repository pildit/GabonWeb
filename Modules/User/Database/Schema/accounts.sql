create table admin.accounts
(
    id             serial  not null,
    firstname      varchar not null,
    password       varchar not null,
    email          varchar not null,
    lastname       varchar,
    activationcode varchar,
    status         varchar,
    employee_type  integer,
    created_at     timestamp(0),
    updated_at     timestamp(0),
    company_id     integer,
    deleted_at     timestamp(0),
    constraint admin_conturi_pkey11
        primary key (id)
);

