DROP TABLE IF EXISTS co_data_nodes;
DROP SEQUENCE IF EXISTS element_id_seq;
CREATE SEQUENCE element_id_seq;
CREATE TABLE co_data_nodes (
  id BIGINT NOT NULL DEFAULT nextval('element_id_seq'),
  access_class VARCHAR(255) NOT NULL,
  last_access TIMESTAMP NOT NULL,
  read_security_id BIGINT DEFAULT NULL,
  write_security_id BIGINT DEFAULT NULL,
  object_name VARCHAR(255) DEFAULT NULL,
  access_class_context TEXT DEFAULT NULL,
  owner BIGINT DEFAULT NULL,
  longitude DOUBLE PRECISION DEFAULT NULL,
  latitude DOUBLE PRECISION DEFAULT NULL,
  tag0 VARCHAR(255) DEFAULT NULL,
  tag1 VARCHAR(255) DEFAULT NULL,
  tag2 VARCHAR(255) DEFAULT NULL,
  tag3 VARCHAR(255) DEFAULT NULL,
  tag4 VARCHAR(255) DEFAULT NULL,
  tag5 VARCHAR(255) DEFAULT NULL,
  tag6 VARCHAR(255) DEFAULT NULL,
  tag7 VARCHAR(255) DEFAULT NULL,
  tag8 VARCHAR(255) DEFAULT NULL,
  tag9 VARCHAR(255) DEFAULT NULL,
  payload TEXT DEFAULT NULL
);

INSERT INTO co_data_nodes (access_class, last_access, read_security_id, write_security_id, object_name, access_class_context, owner, longitude, latitude, tag0, tag1, tag2, tag3, tag4, tag5, tag6, tag7, tag8, tag9, payload) VALUES
('CO_Main_DB_Record', '1970-01-02 00:00:00', -1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('CO_User_Collection', '1970-01-02 00:00:00', 0, 2, 'Admin User', 'a:1:{s:4:"lang";s:2:"sv";}', NULL, NULL, NULL, '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('CO_User_Collection', '1970-01-02 00:00:00', 0, 3, 'Norm User', 'a:1:{s:4:"lang";s:2:"sv";}', NULL, NULL, NULL, '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('CO_User_Collection', '1970-01-02 00:00:00', 0, 4, 'Bob User', NULL, NULL, NULL, NULL, '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('CO_User_Collection', '1970-01-02 00:00:00', 0, 5, 'Cobra User', NULL, NULL, NULL, NULL, '5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('CO_US_Place', '1970-01-02 00:00:00', 0, 3, 'New Start', NULL, 7, -76.87700701, 39.05928327, 'Queens Chapel United Methodist Church', '7410 Old Muirkirk Road', '', 'Beltsville', '', 'MD', '20705', NULL, '6', '20:00:00', NULL),
('CO_US_Place', '1970-01-02 00:00:00', 0, 3, 'Italian Test', 'a:1:{s:4:"lang";s:2:"it";}', 7, -76.87700701, 39.05928327, 'Queens Chapel United Methodist Church', '7410 Old Muirkirk Road', '', 'Beltsville', '', 'MD', '20705', NULL, '6', '20:00:00', NULL);
