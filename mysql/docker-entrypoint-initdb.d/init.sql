DROP SCHEMA IF EXISTS shukatsu;

CREATE SCHEMA shukatsu;

USE shukatsu;

DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  email VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO
  users
SET
  email = 'test@posse-ap.com',
  password = sha1('password');

DROP TABLE IF EXISTS events;

CREATE TABLE events (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO
  events
SET
  title = 'イベント1';

INSERT INTO
  events
SET
  title = 'イベント2';

  DROP TABLE IF EXISTS agency_information;

  CREATE TABLE agency_information (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    agency_name VARCHAR(255) NOT NULL,
    mail_adress VARCHAR(255) NOT NULL,
    phone_number VARCHAR(255) NOT NULL,
    img VARCHAR(255) NOT NULL,
    achievements VARCHAR(255) NOT NULL,
    contract_numbers VARCHAR(255) NOT NULL,
    bases_numbers VARCHAR(255) NOT NULL,
    support VARCHAR(255) NOT NULL,
    place VARCHAR(255) NOT NULL,
    industry_id INT NOT NULL,
    major_id INT NOT NULL,
    feature_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );

INSERT INTO
  agency_information(agency_name,mail_adress,phone_number,img,achievements,contract_numbers,bases_numbers,support,place,industry_id,major_id,feature_id) VALUES
  (
    'POSE',
    'sumple@gmail.com',
    '0120102030',
    'posselogo.img',
    '100万',
    '2万',
    '50',
    'ES添削',
    '神奈川',
    1,
    2,
    3
  )