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

DROP TABLE IF EXISTS industry_condition;

CREATE TABLE industry_condition (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  industry VARCHAR(255) NOT NULL
);
INSERT INTO industry_condition SET industry = 'コンサル';
INSERT INTO industry_condition SET industry = 'エンジニア';
INSERT INTO industry_condition SET industry = 'メーカー';
INSERT INTO industry_condition SET industry = '金融';
INSERT INTO industry_condition SET industry = '商社';
INSERT INTO industry_condition SET industry = 'ベンチャー';
INSERT INTO industry_condition SET industry = 'サービス';
INSERT INTO industry_condition SET industry = 'インフラ';

  DROP TABLE IF EXISTS major_condition;

CREATE TABLE major_condition(
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  major VARCHAR(255) NOT NULL
);
INSERT INTO major_condition SET major = '理系';
INSERT INTO major_condition SET major = '文系';


  DROP TABLE IF EXISTS feature_condition;

CREATE TABLE feature_condition (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  feature VARCHAR(255) NOT NULL
);
INSERT INTO feature_condition SET feature = 'ES添削あり';
INSERT INTO feature_condition SET feature = '面接対策あり';
INSERT INTO feature_condition SET feature = '即日連絡';
INSERT INTO feature_condition SET feature = 'オンライン可能';
INSERT INTO feature_condition SET feature = '担当者変更可能';
INSERT INTO feature_condition SET feature = 'ウェイよー';
INSERT INTO feature_condition SET feature = 'わーー';
INSERT INTO feature_condition SET feature = 'ウーー';


DROP TABLE IF EXISTS agency_information;

CREATE TABLE agency_information (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  agency_name VARCHAR(255) NOT NULL,
  catch_copy VARCHAR(255) NOT NULL,
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
agency_information(agency_name,catch_copy,mail_adress,phone_number,img,achievements,contract_numbers,bases_numbers,support,place,industry_id,major_id,feature_id) VALUES
(
  'わーー',
  '楽しい会社',
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
);
INSERT INTO
agency_information(agency_name,catch_copy,mail_adress,phone_number,img,achievements,contract_numbers,bases_numbers,support,place,industry_id,major_id,feature_id) VALUES
(
  'POSEE',
  '風通しの良い会社',
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
);
INSERT INTO
agency_information(agency_name,catch_copy,mail_adress,phone_number,img,achievements,contract_numbers,bases_numbers,support,place,industry_id,major_id,feature_id) VALUES
(
  'アマゾン',
  '風通しの悪い会社',
  'aaaa@gmail.com',
  '0120104030',
  'posselogo.img',
  '100万',
  '2万',
  '50',
  'ES添削',
  '神奈川',
  1,
  2,
  3
);
INSERT INTO
agency_information(agency_name,catch_copy,mail_adress,phone_number,img,achievements,contract_numbers,bases_numbers,support,place,industry_id,major_id,feature_id) VALUES
(
  'まーーー',
  '普通の会社',
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
);