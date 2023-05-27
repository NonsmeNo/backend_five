CREATE TABLE application_5 (
  id int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name nvarchar(128) NOT NULL DEFAULT '',
  email varchar(128) NOT NULL DEFAULT '',
  biography nvarchar(1500) NOT NULL DEFAULT '',
  gender varchar(1) NOT NULL DEFAULT '',
  limbs int(1) NOT NULL DEFAULT 0,
  birth varchar(10) NOT NULL DEFAULT ''
);

CREATE TABLE ability_5 (
  id int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(128) NOT NULL DEFAULT ''
);

CREATE TABLE application_ability_5 (
application_id int(10) unsigned NOT NULL,
ability_id int(10) unsigned NOT NULL,
FOREIGN KEY (application_id) REFERENCES application(id),
FOREIGN KEY (ability_id) REFERENCES ability(id),
PRIMARY KEY (application_id, ability_id)
); 

CREATE TABLE users_5 (
id int(10) unsigned NOT NULL,
login varchar(128) NOT NULL DEFAULT '',
pass varchar(128) NOT NULL DEFAULT '',
FOREIGN KEY (id) REFERENCES application_5(id),
PRIMARY KEY (id)
); 

