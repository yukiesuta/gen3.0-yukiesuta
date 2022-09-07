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
  attendance_status INT DEFAULT 0,    /*未回答：0、参加：1、不参加：2*/
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME,
  FOREIGN KEY (event_id) REFERENCES events(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO events SET name='縦モク', start_at='2022/09/01 21:00', end_at='2022/09/01 23:00';
INSERT INTO events SET name='横モク', start_at='2022/09/02 21:00', end_at='2022/09/02 23:00';
INSERT INTO events SET name='スペモク', start_at='2022/09/03 20:00', end_at='2022/09/03 22:00';

INSERT INTO users (email, name, password, is_admin) VALUES
    ("user0@gmail.com", "user0", SHA2('password0',512), true),
    ("user1@gmail.com", "user1", SHA2('password1',512), false),
    ("user2@gmail.com", "user2", SHA2('password2',512), false),
    ("user3@gmail.com", "user3", SHA2('password3',512), false);

INSERT INTO event_user_attendance SET event_id=1, user_id=1, attendance_status=0;
INSERT INTO event_user_attendance SET event_id=1, user_id=2, attendance_status=0;
INSERT INTO event_user_attendance SET event_id=1, user_id=3, attendance_status=1;
INSERT INTO event_user_attendance SET event_id=1, user_id=4, attendance_status=2;
INSERT INTO event_user_attendance SET event_id=2, user_id=1, attendance_status=0;
INSERT INTO event_user_attendance SET event_id=2, user_id=2, attendance_status=1;
INSERT INTO event_user_attendance SET event_id=2, user_id=3, attendance_status=1;
INSERT INTO event_user_attendance SET event_id=2, user_id=4, attendance_status=2;
INSERT INTO event_user_attendance SET event_id=3, user_id=1, attendance_status=0;
INSERT INTO event_user_attendance SET event_id=3, user_id=2, attendance_status=0;
INSERT INTO event_user_attendance SET event_id=3, user_id=3, attendance_status=0;
INSERT INTO event_user_attendance SET event_id=3, user_id=4, attendance_status=0;
