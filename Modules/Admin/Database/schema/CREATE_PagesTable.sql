drop table if exists admin.pages;
create table admin.pages
(
    id       serial  not null
        constraint pages_pk
            primary key,
    name     varchar not null,
    path     varchar not null,
    resource varchar not null
);

drop table if exists admin.page_role;
create table admin.page_role
(
    id      serial  not null,
    page_id integer not null
        constraint page_permission_pages_id_fk
            references admin.pages
            on delete cascade,
    role_id integer not null
        constraint page_permission_roles_id_fk
            references admin.roles
            on delete set null
);

create unique index page_role_role_id_page_id_uindex
    on admin.page_role (role_id, page_id);

insert into admin.pages (id, name, path, resource) values (nextval('admin.pages_id_seq'), 'permits', '/permits', 'permits');
insert into admin.pages (id, name, path, resource) values (nextval('admin.pages_id_seq'), 'permits items', '/permits/{permit}/items', 'permit_items');
insert into admin.pages (id, name, path, resource) values (nextval('admin.pages_id_seq'), 'users', '/users', 'users');
insert into admin.pages (id, name, path, resource) values (nextval('admin.pages_id_seq'), 'translations', '/translations', 'translations');
insert into admin.pages (id, name, path, resource) values (nextval('admin.pages_id_seq'), 'roles', '/roles', 'roles');
insert into admin.pages (id, name, path, resource) values (nextval('admin.pages_id_seq'), 'permissions', '/permissions', 'permissions');
insert into admin.pages (id, name, path, resource) values (nextval('admin.pages_id_seq'), 'pages', '/pages', 'pages');


