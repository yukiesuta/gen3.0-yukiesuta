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
  email = 'voozer-inc@voozer.com',
  password = sha1('password');

DROP TABLE IF EXISTS agency_users;

CREATE TABLE agency_users (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  agency_id INT NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO
  agency_users
SET
  agency_id = 1,
  email = 'mynaviagent@mynavi.com',
  password = sha1('password');

INSERT INTO
  agency_users
SET
  agency_id = 2,
  email = 'careeragent@career.com',
  password = sha1('password');

INSERT INTO
  agency_users
SET
  agency_id = 3,
  email = 'digupcareer@digupcareer.com',
  password = sha1('password');


DROP TABLE IF EXISTS events;

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
INSERT INTO major_condition SET major = '文系';
INSERT INTO major_condition SET major = '理系';


  DROP TABLE IF EXISTS feature_condition;

CREATE TABLE feature_condition (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  feature VARCHAR(255) NOT NULL
);
INSERT INTO feature_condition SET feature = 'ES添削';
INSERT INTO feature_condition SET feature = '面接対策';
INSERT INTO feature_condition SET feature = '即日連絡';
INSERT INTO feature_condition SET feature = 'オンライン面談';
INSERT INTO feature_condition SET feature = '自己分析サポート';


DROP TABLE IF EXISTS features;

CREATE TABLE features (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  feature VARCHAR(255) NOT NULL
);

INSERT INTO features SET feature = 'コンサル';
INSERT INTO features SET feature = 'エンジニア';
INSERT INTO features SET feature = 'メーカー';
INSERT INTO features SET feature = '金融';
INSERT INTO features SET feature = '商社';
INSERT INTO features SET feature = 'ベンチャー';
INSERT INTO features SET feature = 'サービス';
INSERT INTO features SET feature = 'インフラ';
INSERT INTO features SET feature = '理系';
INSERT INTO features SET feature = '文系';
INSERT INTO features SET feature = 'ES添削';
INSERT INTO features SET feature = '面接対策';
INSERT INTO features SET feature = '即日連絡';
INSERT INTO features SET feature = 'オンライン面談';
INSERT INTO features SET feature = '自己分析サポート';




DROP TABLE IF EXISTS agency_information;

CREATE TABLE agency_information (
id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
agency_name VARCHAR(255) NOT NULL,
catch_copy VARCHAR(255) NOT NULL,
detail VARCHAR(255) NOT NULL,
mail_address VARCHAR(255) NOT NULL,
manager VARCHAR(255) NOT NULL,
phone_number VARCHAR(255) NOT NULL,
img BLOB NOT NULL,
unit_price INT NOT NULL,
achievements VARCHAR(255) NOT NULL,
contract_numbers VARCHAR(255) NOT NULL,
bases_numbers VARCHAR(255) NOT NULL,
support VARCHAR(255) NOT NULL,
-- place VARCHAR(255) NOT NULL,
claim_status INT NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO agency_information
SET
agency_name ='マイナビ新卒紹介',
catch_copy ='徹底的なキャリアカウンセリングが魅力',
detail= '株式会社マイナビが提供している新卒学生向けの無料就職エージェントサービスです。キャリアアドバイザーが個別に面談（キャリアカウンセリング）を行い、皆さまの志向や適性に合った求人をご紹介します。また、履歴書やエントリーシートなど書類作成のポイントや面接に関するアドバイスも行います。',
mail_address = 'kyarisen@mail.com',
manager = '湯田晃大',
phone_number = '08012341111',
img  = '0xE382B9E382AFE383AAE383BCE383B3E382B7E383A7E38383E3838820323032322D30352D32372031332E34352E33392E706E67',
unit_price = 5000,
achievements = '関東全域',
contract_numbers = '4000件以上',
bases_numbers = '渋谷/新宿/池袋/横浜/浦和',
support = '30件',
claim_status = 0;

INSERT INTO agency_information
SET
agency_name ='キャリセン',
catch_copy ='2009年に設立された、新卒紹介業界のパイオニア的存在',
detail= 'キャリセンは何年間も企業と直接対峙してきた採用コンサルタントが多く在籍している点が特徴的です。長年に渡る企業紹介で積み重ねられたノウハウや、紹介企業との繋がり、多くの採用実績は同社の大きな強みとなっています。',
mail_address = 'dig@mail.com',
manager = '添田昴',
phone_number = '08012342222',
img  = '0xE382B9E382AFE383AAE383BCE383B3E382B7E383A7E38383E3838820323032322D30352D32372031332E34352E33392E706E67',
unit_price = 4000,
achievements = '全国（北海道・沖縄を除く）',
contract_numbers = '2100件以上',
bases_numbers = '全国各地の主要駅近く',
support = '30件',
claim_status = 0;

INSERT INTO agency_information
SET
agency_name ='DIG　UP　CAREER',
catch_copy ='満足度90%超、友人紹介率60%超！寄り添い型でとにかく支援が手厚い',
detail= 'DiGは就活生ひとりひとりに寄り添うことをモットーにES添削・面接対策といった内定前のフォローから新社会人に向けての準備といった内定後のサポートまで充実しております。',
mail_address = 'dig@mail.com',
manager = '田中隆行',
phone_number = '08012343333',
img  = '0xE382B9E382AFE383AAE383BCE383B3E382B7E383A7E38383E3838820323032322D30352D32372031332E34352E33392E706E67',
unit_price = 4000,
achievements = '東京・神奈川・埼玉',
contract_numbers = '1200件以上',
bases_numbers = '渋谷/新宿/横浜/浦和',
support = '30件',
claim_status = 0;

INSERT INTO agency_information
SET
agency_name ='レバテックルーキー',
catch_copy ='レバテックルーキーはITエンジニア専門の就活エージェント',
detail= '厳選された多くのベンチャー企業からあなたのスキルに最適な職業をご案内致します。求人はITエンジニア専門であり、キャリアアドバイザーも業界対する知見が豊富なことが特徴です。エンジニアを目指す就活生は必須',
mail_address = 'revatech@mail.com',
manager = '田中隆行',
phone_number = '08012344444',
img  = '0xE382B9E382AFE383AAE383BCE383B3E382B7E383A7E38383E3838820323032322D30352D32372031332E34352E33392E706E67',
unit_price = 3000,
achievements = '全国',
contract_numbers = '2000件以上',
bases_numbers = '全国各地',
support = '30件',
claim_status = 0;






DROP TABLE IF EXISTS agency_industry;

CREATE TABLE agency_industry (

agency_id INT NOT NULL,
industry_id INT NOT NULL

);

INSERT INTO agency_industry(agency_id, industry_id)VALUES(1,1);
INSERT INTO agency_industry(agency_id, industry_id)VALUES(1,2);
INSERT INTO agency_industry(agency_id, industry_id)VALUES(1,3);
INSERT INTO agency_industry(agency_id, industry_id)VALUES(2,2);
INSERT INTO agency_industry(agency_id, industry_id)VALUES(2,4);
INSERT INTO agency_industry(agency_id, industry_id)VALUES(2,5);
INSERT INTO agency_industry(agency_id, industry_id)VALUES(3,1);
INSERT INTO agency_industry(agency_id, industry_id)VALUES(3,2);
INSERT INTO agency_industry(agency_id, industry_id)VALUES(3,4);
INSERT INTO agency_industry(agency_id, industry_id)VALUES(4,1);
INSERT INTO agency_industry(agency_id, industry_id)VALUES(4,2);
INSERT INTO agency_industry(agency_id, industry_id)VALUES(4,4);




DROP TABLE IF EXISTS agency_major;

CREATE TABLE agency_major (

agency_id INT NOT NULL,
major_id INT NOT NULL

);


DROP TABLE IF EXISTS agency_feature;

CREATE TABLE agency_feature (

agency_id INT NOT NULL,
feature_id INT NOT NULL

);

INSERT INTO agency_feature(agency_id,feature_id)VALUES(1,1);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(1,2);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(1,3);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(1,8);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(1,10);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(1,11);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(2,2);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(2,4);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(2,5);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(2,8);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(2,12);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(2,14);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(3,1);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(3,2);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(3,4);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(3,8);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(3,13);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(3,14);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(4,1);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(4,2);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(4,4);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(4,8);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(4,11);
INSERT INTO agency_feature(agency_id,feature_id)VALUES(4,14);

DROP TABLE IF EXISTS inquiry;

CREATE TABLE inquiry (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(255)  NOT NULL,
  birthday VARCHAR(255) NOT NULL,
  university VARCHAR(255)  NOT NULL,
  phone VARCHAR(255)  NOT NULL,
  address VARCHAR(255)  NOT NULL,
  email VARCHAR(255)  NOT NULL,
  cryptography VARCHAR(255)  NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dt DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO
  inquiry
SET
  name = '西森慶太',
  birthday = '2001-05-11',
  university = '早稲田大学',
  phone = '09052378876',
  address = '東京都',
  email = 'wawawa.keita-keikei@waseda.jp',
  cryptography = 'jkfsdvbcfcmsdbmkd';

INSERT INTO
  inquiry
SET
  name = '谷中雄大',
  birthday = '2001-03-21',
  university = '明治大学',
  phone = '09077885411',
  address = '神奈川県',
  email = 'wawtanitanii@meiji.jp',
  cryptography = 'jsjdabibdsidcvihc';


DROP TABLE IF EXISTS inquiry_agency;

CREATE TABLE inquiry_agency (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  cryptography VARCHAR(255)  NOT NULL,
  agency_id INT  NOT NULL,
  progress INT NOT NULL
);
INSERT INTO
  inquiry_agency
SET
  cryptography = 'jkfsdvbcfcmsdbmkd',
  agency_id = 1,
  progress = 0;

INSERT INTO
  inquiry_agency
SET
  cryptography = 'jkfsdvbcfcmsdbmkd',
  agency_id = 2,
  progress = 0;

INSERT INTO
  inquiry_agency
SET
  cryptography = 'jkfsdvbcfcmsdbmkd',
  agency_id = 3,
  progress = 0;


INSERT INTO
  inquiry_agency
SET
  cryptography = 'jsjdabibdsidcvihc',
  agency_id = 1,
  progress = 0;

INSERT INTO
  inquiry_agency
SET
  cryptography = 'jsjdabibdsidcvihc',
  agency_id = 3,
  progress = 0;
