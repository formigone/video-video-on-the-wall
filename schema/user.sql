CREATE TABLE user (
  id       INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(32) NOT NULL,
  password VARCHAR(64) NOT NULL,
  salt     VARCHAR(32) NOT NULL
)
  ENGINE =innodb;

CREATE TABLE ci_sessions (
  session_id    VARCHAR(40) DEFAULT '0'    NOT NULL,
  ip_address    VARCHAR(45) DEFAULT '0'    NOT NULL,
  user_agent    VARCHAR(120)               NOT NULL,
  last_activity INT(10) UNSIGNED DEFAULT 0 NOT NULL,
  user_data     TEXT                       NOT NULL,
  PRIMARY KEY (session_id),
  KEY last_activity_idx (last_activity)
)
  ENGINE =innodb;
