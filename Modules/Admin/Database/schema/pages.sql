create table admin.pages
(
    id       serial  not null
        constraint pages_pk
            primary key,
    name     varchar not null,
    path     varchar,
    resource varchar not null
);


INSERT INTO admin.pages (id, name, path, resource) VALUES (1, 'permits', '/permits', 'permits');
INSERT INTO admin.pages (id, name, path, resource) VALUES (2, 'permits items', '/permits/{permit}/items', 'permit_items');
INSERT INTO admin.pages (id, name, path, resource) VALUES (3, 'users', '/users', 'users');
INSERT INTO admin.pages (id, name, path, resource) VALUES (4, 'translations', '/translations', 'translations');
INSERT INTO admin.pages (id, name, path, resource) VALUES (5, 'roles', '/roles', 'roles');
INSERT INTO admin.pages (id, name, path, resource) VALUES (6, 'permissions', '/permissions', 'permissions');
INSERT INTO admin.pages (id, name, path, resource) VALUES (7, 'pages', '/pages', 'pages');
INSERT INTO admin.pages (id, name, path, resource) VALUES (48, 'home', '/', 'home');
INSERT INTO admin.pages (id, name, path, resource) VALUES (49, 'geoportal', '/geoportal', 'geoportal');
INSERT INTO admin.pages (id, name, path, resource) VALUES (50, 'administration', '', 'administration');
INSERT INTO admin.pages (id, name, path, resource) VALUES (52, 'transportation', '/transportation', 'transportation');
INSERT INTO admin.pages (id, name, path, resource) VALUES (53, 'nomenclatures', '/nomenclatures', 'nomenclatures');
INSERT INTO admin.pages (id, name, path, resource) VALUES (56, 'carnet de chantier', '/sitelogbooks', 'sitelogbooks');
INSERT INTO admin.pages (id, name, path, resource) VALUES (51, 'management', '', 'management');
INSERT INTO admin.pages (id, name, path, resource) VALUES (54, 'concessions', '/concession', 'concessions');
INSERT INTO admin.pages (id, name, path, resource) VALUES (55, 'carnet d''abattage', '/logbooks', 'logbooks');