create table admin.roles
(
    id         bigserial    not null
        constraint roles_pkey
            primary key,
    name       varchar(255) not null,
    guard_name varchar(255) not null,
    created_at timestamp(0),
    updated_at timestamp(0),
    type       integer
);
