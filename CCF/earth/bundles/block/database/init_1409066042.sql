# ---> up

CREATE TABLE IF NOT EXISTS `earth_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(144) NOT NULL,
  `language` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `content_build` text NOT NULL,
  `footer` text NOT NULL,
  `modified_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `earth_block_revisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block_id` int(11) NOT NULL,
  `revision` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

# ---> down

DROP TABLE `earth_blocks`;
DROP TABLE `earth_block_revisions`;