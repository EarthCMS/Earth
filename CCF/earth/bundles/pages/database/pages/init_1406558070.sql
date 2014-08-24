# ---> up

CREATE TABLE IF NOT EXISTS `earth_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `sequence` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `full_url` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `redirect` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `content_build` text NOT NULL,
  `modules` text NOT NULL,
  `options` text NOT NULL,
  `created_at` int(11) NOT NULL,
  `modified_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `status` (`status`),
  KEY `hidden` (`hidden`),
  KEY `url` (`url`),
  KEY `full_url` (`full_url`),
  KEY `sequence` (`sequence`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `earth_pages` (`id`, `type`, `status`, `hidden`, `sequence`, `parent_id`, `url`, `full_url`, `name`, `description`, `image`, `controller`, `redirect`, `modules`, `options`, `created_at`, `modified_at`) VALUES (NULL, '1', '1', '0', '1', '0', '/', '/', 'Root', '', '', '', '', '', '', UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

# ---> down

DROP TABLE `earth_pages`;