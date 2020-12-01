create table table_name
(
	id serial,
	action int not null,
	logged_at timestamp not null,
	loggable_id int not null,
	loggable_type varchar not null,
	user_id int not null,
	data text not null,
	version int default 1 not null
);

