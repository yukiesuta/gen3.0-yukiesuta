DROP SCHEMA IF EXISTS posse;

CREATE SCHEMA posse;

USE posse;

DROP TABLE IF EXISTS events;

CREATE TABLE
    events (
        id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
        name VARCHAR(20) NOT NULL,
        detail VARCHAR(128) DEFAULT NULL,
        start_at DATETIME,
        end_at DATETIME,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at DATETIME
    );

DROP TABLE IF EXISTS users;

CREATE TABLE
    users (
        id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
        email VARCHAR(128) NOT NULL,
        name VARCHAR(20) NOT NULL,
        password VARCHAR(128) NOT NULL,
        slack_id VARCHAR(128) NOT NULL,
        is_admin BOOLEAN,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at DATETIME
    );

DROP TABLE IF EXISTS event_user_attendance;

CREATE TABLE
    event_user_attendance (
        id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
        event_id INT NOT NULL,
        user_id INT NOT NULL,
        attendance_status INT DEFAULT 0,
        /*未回答：0、参加：1、不参加：2*/
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at DATETIME,
        FOREIGN KEY (event_id) REFERENCES events(id),
        FOREIGN KEY (user_id) REFERENCES users(id)
    );

INSERT INTO events
SET
    name = '縦モク',
    detail = '縦割りのメンバーでもくもくします',
    start_at = '2022/09/04 21:00',
    end_at = '2022/09/04 23:00';

INSERT INTO events
SET
    name = 'スペモク',
    detail = 'メンターさんともくもくします',
    start_at = '2022/09/05 20:00',
    end_at = '2022/09/03 22:00';

INSERT INTO events
SET
    name = '富士急',
    detail = '富士急にバスで行きます',
    start_at = '2022/09/06 21:00',
    end_at = '2022/09/09 23:00';

INSERT INTO events
SET
    name = '北海道',
    detail = 'フェリーで北海道に行きます',
    start_at = '2022/09/07 21:00',
    end_at = '2022/09/07 23:00';

INSERT INTO events
SET
    name = 'ラーメン二郎',
    detail = 'アブラカタメマシで注文します',
    start_at = '2022/09/08 20:00',
    end_at = '2022/09/08 22:00';

INSERT INTO events
SET
    name = 'カタール',
    detail = '石油の国',
    start_at = '2022/09/09 21:00',
    end_at = '2022/09/14 23:00';

INSERT INTO events
SET
    name = '山形',
    detail = '米沢牛食べます',
    start_at = '2022/09/10 19:00',
    end_at = '2022/09/11 22:00';

INSERT INTO events
SET
    name = '試合',
    detail = '国立競技場でキックオフ',
    start_at = '2022/09/11 18:00',
    end_at = '2022/09/11 22:00';

INSERT INTO events
SET
    name = 'ボドゲカフェ',
    detail = '皆で戦いましょう',
    start_at = '2022/09/12 18:00',
    end_at = '2022/09/13 22:00';

INSERT INTO events
SET
    name = '大阪に行こ',
    detail = 'たこ焼きを食べます',
    start_at = '2022/09/13 18:00',
    end_at = '2022/09/13 22:00';

INSERT INTO
    users (
        email,
        name,
        password,
        slack_id,
        is_admin
    )
VALUES (
        "user0@gmail.com",
        "松本透歩",
        SHA2('password0', 512),
        "U0426V2CJBS",
        true
    ), (
        "user1@gmail.com",
        "本城祐大",
        SHA2('password1', 512),
        "U041E9NM75K",
        false
    ), (
        "user2@gmail.com",
        "井戸宗達",
        SHA2('password2', 512),
        "U041H8XN7DG",
        false
    ), (
        "user3@gmail.com",
        "松本美智子",
        SHA2('password3', 512),
        "U041H5MSGAF",
        false
    );

INSERT INTO
    event_user_attendance
SET
    event_id = 1,
    user_id = 1,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 1,
    user_id = 2,
    attendance_status = 2;

INSERT INTO
    event_user_attendance
SET
    event_id = 1,
    user_id = 3,
    attendance_status = 0;

INSERT INTO
    event_user_attendance
SET
    event_id = 1,
    user_id = 4,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 2,
    user_id = 1,
    attendance_status = 2;

INSERT INTO
    event_user_attendance
SET
    event_id = 2,
    user_id = 2,
    attendance_status = 0;

INSERT INTO
    event_user_attendance
SET
    event_id = 2,
    user_id = 3,
    attendance_status = 0;

INSERT INTO
    event_user_attendance
SET
    event_id = 2,
    user_id = 4,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 3,
    user_id = 1,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 3,
    user_id = 2,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 3,
    user_id = 3,
    attendance_status = 0;

INSERT INTO
    event_user_attendance
SET
    event_id = 3,
    user_id = 4,
    attendance_status = 2;

INSERT INTO
    event_user_attendance
SET
    event_id = 4,
    user_id = 1,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 4,
    user_id = 2,
    attendance_status = 0;

INSERT INTO
    event_user_attendance
SET
    event_id = 4,
    user_id = 3,
    attendance_status = 0;

INSERT INTO
    event_user_attendance
SET
    event_id = 4,
    user_id = 4,
    attendance_status = 2;

INSERT INTO
    event_user_attendance
SET
    event_id = 5,
    user_id = 1,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 5,
    user_id = 2,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 5,
    user_id = 3,
    attendance_status = 0;

INSERT INTO
    event_user_attendance
SET
    event_id = 5,
    user_id = 4,
    attendance_status = 2;

INSERT INTO
    event_user_attendance
SET
    event_id = 6,
    user_id = 1,
    attendance_status = 0;

INSERT INTO
    event_user_attendance
SET
    event_id = 6,
    user_id = 2,
    attendance_status = 2;

INSERT INTO
    event_user_attendance
SET
    event_id = 6,
    user_id = 3,
    attendance_status = 0;

INSERT INTO
    event_user_attendance
SET
    event_id = 6,
    user_id = 4,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 7,
    user_id = 1,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 7,
    user_id = 2,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 7,
    user_id = 3,
    attendance_status = 0;

INSERT INTO
    event_user_attendance
SET
    event_id = 7,
    user_id = 4,
    attendance_status = 2;

INSERT INTO
    event_user_attendance
SET
    event_id = 8,
    user_id = 1,
    attendance_status = 0;

INSERT INTO
    event_user_attendance
SET
    event_id = 8,
    user_id = 2,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 8,
    user_id = 3,
    attendance_status = 2;

INSERT INTO
    event_user_attendance
SET
    event_id = 8,
    user_id = 4,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 9,
    user_id = 1,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 9,
    user_id = 2,
    attendance_status = 2;

INSERT INTO
    event_user_attendance
SET
    event_id = 9,
    user_id = 3,
    attendance_status = 2;

INSERT INTO
    event_user_attendance
SET
    event_id = 9,
    user_id = 4,
    attendance_status = 0;

INSERT INTO
    event_user_attendance
SET
    event_id = 10,
    user_id = 1,
    attendance_status = 1;

INSERT INTO
    event_user_attendance
SET
    event_id = 10,
    user_id = 2,
    attendance_status = 2;

INSERT INTO
    event_user_attendance
SET
    event_id = 10,
    user_id = 3,
    attendance_status = 0;

INSERT INTO
    event_user_attendance
SET
    event_id = 10,
    user_id = 4,
    attendance_status = 1;