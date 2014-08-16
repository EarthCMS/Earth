# ---> up

ALTER TABLE  `earth_pages` ADD  `redirect` VARCHAR( 255 ) NOT NULL AFTER  `controller` ;

# ---> down

ALTER TABLE `earth_pages` DROP `redirect`;