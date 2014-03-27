
create table roles (
	role_id integer primary key,
	name varchar(50)
);
CREATE UNIQUE INDEX idx__roles__role_id ON roles (role_id);

insert into roles (role_id,name) values (1,'admin');
insert into roles (role_id,name) values (2,'customer');

create table organizations(
	org_id integer primary key autoincrement,
	role_id integer references roles(role_id),
	name varchar(255),
	is_deleted boolean default false,
	creation_date timestamp default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX idx__organizations__org_id ON organizations (org_id);
CREATE UNIQUE INDEX idx__organizations__name ON organizations (name);
CREATE INDEX idx__organizations__role_id ON organizations (role_id);

insert into organizations (role_id,name) values (1,'Admin');

create table users (
	user_id integer primary key autoincrement,
	org_id integer references organizations(org_id),
	email varchar(255),
	password varchar(255),
	first_name varchar(50),
	last_name varchar(50),
	phone_number varchar(50),
	is_deleted boolean default false,
	creation_date timestamp DEFAULT CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX idx__users__user_id ON users (user_id);
CREATE UNIQUE INDEX idx__users__email ON users (email);
CREATE INDEX idx__users__org_id ON users (org_id);

