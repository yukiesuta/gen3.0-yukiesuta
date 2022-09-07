DROP SCHEMA IF EXISTS posse;
CREATE SCHEMA posse;
USE posse;

DROP TABLE IF EXISTS events;
CREATE TABLE events (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(10) NOT NULL,
  start_at DATETIME,
  end_at DATETIME,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME
);

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  email VARCHAR(128) NOT NULL,
  name VARCHAR(20) NOT NULL,
  password VARCHAR(128) NOT NULL,
  is_admin BOOLEAN,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME
);

DROP TABLE IF EXISTS event_user_attendance;
CREATE TABLE event_user_attendance (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  event_id INT NOT NULL,
  user_id INT NOT NULL,
  attendance_status INT DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME,
  FOREIGN KEY (event_id) REFERENCES events(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO events SET name='縦モク', start_at='2022/09/01 21:00', end_at='2022/09/01 23:00';
INSERT INTO events SET name='横モク', start_at='2022/09/02 21:00', end_at='2022/09/02 23:00';
INSERT INTO events SET name='スペモク', start_at='2022/09/03 20:00', end_at='2022/09/03 22:00';
INSERT INTO events SET name='縦モク', start_at='2022/09/08 21:00', end_at='2022/09/08 23:00';
INSERT INTO events SET name='横モク', start_at='2022/09/09 21:00', end_at='2022/09/09 23:00';
INSERT INTO events SET name='スペモク', start_at='2022/09/10 20:00', end_at='2022/09/10 22:00';
INSERT INTO events SET name='縦モク', start_at='2022/09/15 21:00', end_at='2022/09/15 23:00';
INSERT INTO events SET name='横モク', start_at='2022/09/16 21:00', end_at='2022/09/16 23:00';
INSERT INTO events SET name='スペモク', start_at='2022/09/17 20:00', end_at='2022/09/17 22:00';
INSERT INTO events SET name='縦モク', start_at='2022/09/22 21:00', end_at='2022/09/22 23:00';
INSERT INTO events SET name='横モク', start_at='2022/09/23 21:00', end_at='2022/09/23 23:00';
INSERT INTO events SET name='スペモク', start_at='2022/09/24 20:00', end_at='2022/09/24 22:00';
INSERT INTO events SET name='遊び', start_at='2022/09/22 19:00', end_at='2022/09/22 22:00';
INSERT INTO events SET name='ハッカソン', start_at='2023/09/03 10:00', end_at='2023/09/03 22:00';
INSERT INTO events SET name='遊び', start_at='2023/09/06 18:00', end_at='2023/09/06 22:00';

INSERT INTO users (email, name, password, is_admin) VALUES
    ("user0@gmail.com", "user0", "password0", true),
    ("user1@gmail.com", "user1", "password1", false),
    ("user2@gmail.com", "user2", "password2", false),
    ("user3@gmail.com", "user3", "password3", false);

INSERT INTO event_user_attendance SET event_id=1, user_id=1;
INSERT INTO event_user_attendance SET event_id=1, user_id=1;
INSERT INTO event_user_attendance SET event_id=1, user_id=1;
INSERT INTO event_user_attendance SET event_id=2, user_id=2;
INSERT INTO event_user_attendance SET event_id=2, user_id=2;
INSERT INTO event_user_attendance SET event_id=3, user_id=3;
