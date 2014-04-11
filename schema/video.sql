CREATE TABLE series (
  id          INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  alias       VARCHAR(128) NOT NULL,
  title       VARCHAR(128) NOT NULL,
  description TEXT         NOT NULL,

  UNIQUE (alias)
)
  ENGINE =innodb;

CREATE TABLE video_src (
  id   INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(128) NOT NULL,

  UNIQUE (name)
)
  ENGINE =innodb;

CREATE TABLE video (
  id          INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  alias       VARCHAR(128) NOT NULL,
  title       VARCHAR(128) NOT NULL,
  created     DATETIME     NOT NULL,
  description TEXT         NOT NULL,

  UNIQUE (alias)
)
  ENGINE =innodb;


CREATE TABLE video_series (
  id        INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  video_id  INT UNSIGNED NOT NULL,
  series_id INT UNSIGNED NOT NULL,
  seq       INT          NOT NULL DEFAULT 0,

  FOREIGN KEY (video_id) REFERENCES video (id),
  FOREIGN KEY (series_id) REFERENCES series (id)
)
  ENGINE =innodb;
