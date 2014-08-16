# ---> up

ALTER TABLE  `earth_pages` ADD `type` tinyint(1) NOT NULL AFTER  `id` ;

# ---> down

ALTER TABLE `earth_pages` DROP `type`;