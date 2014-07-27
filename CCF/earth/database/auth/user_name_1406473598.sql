# ---> up

ALTER TABLE  `auth_users` ADD `name` VARCHAR( 255 ) NOT NULL AFTER `email`;

# ---> down

ALTER TABLE `auth_users`
DROP `name`;