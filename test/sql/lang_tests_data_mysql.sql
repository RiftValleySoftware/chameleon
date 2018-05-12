DROP TABLE IF EXISTS `co_data_nodes`;
CREATE TABLE `co_data_nodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `access_class` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_access` datetime NOT NULL,
  `read_security_id` bigint(20) DEFAULT NULL,
  `write_security_id` bigint(20) DEFAULT NULL,
  `object_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `access_class_context` blob,
  `owner` bigint(20) UNSIGNED DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `tag0` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tag1` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tag2` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tag3` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tag4` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tag5` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tag6` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tag7` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tag8` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tag9` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `payload` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `co_data_nodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `access_class` (`access_class`),
  ADD KEY `last_access` (`last_access`),
  ADD KEY `write_security_id` (`write_security_id`),
  ADD KEY `read_security_id` (`read_security_id`),
  ADD KEY `object_name` (`object_name`),
  ADD KEY `owner` (`owner`),
  ADD KEY `longitude` (`longitude`),
  ADD KEY `latitude` (`latitude`),
  ADD KEY `tag0` (`tag0`),
  ADD KEY `tag1` (`tag1`),
  ADD KEY `tag2` (`tag2`),
  ADD KEY `tag3` (`tag3`),
  ADD KEY `tag4` (`tag4`),
  ADD KEY `tag5` (`tag5`),
  ADD KEY `tag6` (`tag6`),
  ADD KEY `tag7` (`tag7`),
  ADD KEY `tag8` (`tag8`),
  ADD KEY `tag9` (`tag9`);
  
INSERT INTO `co_data_nodes` (`id`, `access_class`, `last_access`, `read_security_id`, `write_security_id`, `object_name`, `access_class_context`, `owner`, `longitude`, `latitude`, `tag0`, `tag1`, `tag2`, `tag3`, `tag4`, `tag5`, `tag6`, `tag7`, `tag8`, `tag9`, `payload`) VALUES
(1, 'CO_Main_DB_Record', '1970-01-02 00:00:00', -1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'CO_User_Collection', '1970-01-02 00:00:00', 0, 3, 'Norm User', 'a:1:{s:4:"lang";s:2:"sv";}', NULL, NULL, NULL, '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'CO_User_Collection', '1970-01-02 00:00:00', 0, 4, 'Bob User', NULL, NULL, NULL, NULL, '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'CO_User_Collection', '1970-01-02 00:00:00', 0, 5, 'Cobra User', NULL, NULL, NULL, NULL, '5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'CO_US_Place', '1970-01-02 00:00:00', 0, 3, 'New Start', NULL, 7, -76.87700701, 39.05928327, 'Queens Chapel United Methodist Church', '7410 Old Muirkirk Road', '', 'Beltsville', '', 'MD', '20705', NULL, '6', '20:00:00', NULL),
(6, 'CO_US_Place', '1970-01-02 00:00:00', 0, 3, 'Italian Test', 'a:1:{s:4:"lang";s:2:"it";}', 7, -76.87700701, 39.05928327, 'Queens Chapel United Methodist Church', '7410 Old Muirkirk Road', '', 'Beltsville', '', 'MD', '20705', NULL, '6', '20:00:00', NULL);

ALTER TABLE `co_data_nodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;