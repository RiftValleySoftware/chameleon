DROP TABLE IF EXISTS co_security_nodes;
DROP SEQUENCE IF EXISTS element_id_seq;
CREATE SEQUENCE element_id_seq;
CREATE TABLE co_security_nodes (
  id BIGINT NOT NULL DEFAULT nextval('element_id_seq'),
  api_key VARCHAR(255) DEFAULT NULL,
  login_id VARCHAR(255) DEFAULT NULL,
  access_class VARCHAR(255) NOT NULL,
  last_access TIMESTAMP NOT NULL,
  read_security_id BIGINT DEFAULT NULL,
  write_security_id BIGINT DEFAULT NULL,
  object_name VARCHAR(255) DEFAULT NULL,
  access_class_context VARCHAR(4095) DEFAULT NULL,
  ids VARCHAR(4095) DEFAULT NULL
);

INSERT INTO co_security_nodes (api_key, login_id, access_class, last_access, read_security_id, write_security_id, object_name, access_class_context, ids) VALUES
(NULL, NULL, 'CO_Security_Node', '1970-01-01 00:00:00', -1, -1, NULL, NULL, NULL),
(NULL, 'admin', 'CO_Security_Login', '1970-01-01 00:00:00', 2, 2, 'Default Admin', 'a:2:{s:4:"lang";s:2:"en";s:15:\"hashed_password\";s:4:\"JUNK\";}', NULL),
(NULL, 'norm', 'CO_Security_Login', '1970-01-01 00:00:00', 3, 3, 'Low-Level 1', 'a:2:{s:4:"lang";s:2:"fr";s:15:"hashed_password";s:13:"62oAxuuttfjZI";}', NULL),
(NULL, 'bob', 'CO_Security_Login', '1970-01-01 00:00:00', 4, 4, 'Low-Level 2', 'a:2:{s:4:"lang";s:2:"fr";s:15:"hashed_password";s:13:"62oAxuuttfjZI";}', NULL),
(NULL, 'cobra', 'CO_Security_Login', '1970-01-01 00:00:00', 5, 5, 'Normal COBRA Login (cobra)', 'a:1:{s:15:"hashed_password";s:13:"62oAxuuttfjZI";}', NULL);
