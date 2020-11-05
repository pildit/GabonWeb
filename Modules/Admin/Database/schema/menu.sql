create table admin.menu
(
    menu     varchar,
    submenu  varchar,
    position double precision,
    page_id  integer,
    id       serial not null
        constraint admin_menu_pkey
            primary key
);


INSERT INTO admin.menu (menu, submenu, position, page_id, id) VALUES ('', 'Roles', 3.1, 5, 43);
INSERT INTO admin.menu (menu, submenu, position, page_id, id) VALUES ('', 'Nomenclatures', 3.3, 53, 45);
INSERT INTO admin.menu (menu, submenu, position, page_id, id) VALUES ('', 'Carnet de chantier', 5.2, 56, 48);
INSERT INTO admin.menu (menu, submenu, position, page_id, id) VALUES ('Administration', null, 3, 50, 40);
INSERT INTO admin.menu (menu, submenu, position, page_id, id) VALUES ('Geoportal', null, 2, 9, 39);
INSERT INTO admin.menu (menu, submenu, position, page_id, id) VALUES ('', 'Carnet d''abattage', 5.1, 55, 47);
INSERT INTO admin.menu (menu, submenu, position, page_id, id) VALUES ('', 'Concessions', 3.4, 54, 46);
INSERT INTO admin.menu (menu, submenu, position, page_id, id) VALUES ('Transportation', null, 5, 52, 42);
INSERT INTO admin.menu (menu, submenu, position, page_id, id) VALUES ('', 'Users', 3.2, 3, 44);
INSERT INTO admin.menu (menu, submenu, position, page_id, id) VALUES ('', 'Transport permit', 5.3, 1, 49);
INSERT INTO admin.menu (menu, submenu, position, page_id, id) VALUES ('Management', null, 4, 51, 41);
INSERT INTO admin.menu (menu, submenu, position, page_id, id) VALUES ('Home', null, 1, 48, 38);