
--
-- データベース: kasn2026db
--
CREATE DATABASE IF NOT EXISTS kasn2026db COLLATE utf8mb4_general_ci;
--
-- テーブルの構造 xt_asn
--

CREATE TABLE xt_asn (
  sid char(7) NOT NULL,
  priority int DEFAULT 5,
  lbid varchar(16) NOT NULL,
  rtime datetime DEFAULT NULL,
  decision tinyint(1) DEFAULT 0,
  PRIMARY KEY (sid,priority)
) ;


--
-- テーブルの構造 xt_lab
--

CREATE TABLE xt_lab (
  lbid varchar(16) NOT NULL,
  lbname varchar(16) NOT NULL,
  lbseq smallint(6) NOT NULL,
  lastname varchar(16) NOT NULL,
  firstname varchar(16) NOT NULL,
  field varchar(64) DEFAULT NULL,
  url varchar(128) DEFAULT NULL,  
  office varchar(32) DEFAULT NULL,
  capacity smallint(6) DEFAULT NULL,
  gcapacity int(11) DEFAULT NULL,
  PRIMARY KEY (lbid)
) ;

--
-- テーブルの構造 xt_student
--

CREATE TABLE xt_student (
  sid char(7) NOT NULL,
  lastname varchar(16) NOT NULL,
  firstname varchar(16) NOT NULL,
  course char(1) NOT NULL,
  gpa float DEFAULT NULL,
  grank int(11) DEFAULT NULL,
  credit int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (sid)
) ;


--
-- テーブルの構造 xt_user
--

CREATE TABLE xt_user (
  uid varchar(16) NOT NULL,
  lastname varchar(16) NOT NULL,
  firstname varchar(16) NOT NULL,
  passwd varchar(36) DEFAULT NULL,
  txtpasswd varchar(16) DEFAULT NULL,
  utype varchar(32) DEFAULT NULL, -- 'student', 'staff', 'admin'
  email varchar(64) DEFAULT NULL,
  PRIMARY KEY (uid)
) ;

INSERT INTO xt_user (uid, lastname, firstname, passwd, txtpasswd, utype, email) VALUES
('admin', '管理者', '', md5('abcd'), 'abcd', 'admin', NULL);
