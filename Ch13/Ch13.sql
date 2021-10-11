-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- 主機: localhost
-- 建立日期: Dec 15, 2007, 07:18 PM
-- 伺服器版本: 5.0.41
-- PHP 版本: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 資料庫: `ch13`
-- 
CREATE DATABASE `ch13` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `ch13`;

-- --------------------------------------------------------

-- 
-- 資料表格式： `bookmark`
-- 

CREATE TABLE `bookmark` (
  `bid` int(11) NOT NULL auto_increment,
  `url` varchar(256) collate utf8_unicode_ci NOT NULL,
  `title` varchar(256) collate utf8_unicode_ci NOT NULL,
  `description` varchar(512) collate utf8_unicode_ci default NULL,
  `click` int(11) NOT NULL,
  `last` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`bid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

-- 
-- 列出以下資料庫的數據： `bookmark`
-- 

INSERT INTO `bookmark` (`bid`, `url`, `title`, `description`, `click`, `last`) VALUES 
(1, 'http://www.php.net/', 'PHP', 'PHP官方網站', 2, '2007-08-15 06:33:59'),
(2, 'http://pear.php.net/', 'PEAR', 'PEAR官方網站', 1, '2007-08-15 06:33:59'),
(3, 'http://twpug.net/', '台灣PHP聯盟', 'PHP新聞,討論,資源', 2, '2007-08-15 11:32:31'),
(11, 'http://en.wikipedia.org/wiki/Pear', 'PEAR-Wikipedia', 'Wikipedia英文版的PEAR網頁', 1, '2007-08-16 16:43:23'),
(12, 'http://www.wampserver.com/en/', 'Wamp5', 'For Windows的Apache+MySQL+PHP', 6, '2007-09-11 20:18:23'),
(13, 'http://www.mysql.com/', 'MySQL 官方網站', 'MySQL Official Site', 1, '2007-09-12 06:51:32'),
(14, 'http://www.microsoft.com/sql/default.mspx', 'Microsoft SQL Server', '微軟SQL Server', 1, '2007-12-13 20:30:44'),
(15, 'http://www.mlb.com/mlb/scoreboard/', 'MLB Scoreboard', '美國職棒戰況', 10, '2007-09-12 18:17:20'),
(16, 'http://www.cpbl.com.tw/ ', 'CPBL', '台灣職棒', 0, '2007-08-17 19:02:52'),
(17, 'http://blog.yam.com/falohmum/', '法洛猛的天空球場 Falohmum''s Sky Field', '台灣的棒球，坐斷東南戰未休；台灣的球員，天下英雄誰敵手。 ', 4, '2007-09-11 20:17:20'),
(18, 'http://blog.accessibility.tw/', ' 網頁親和力', '作為起步，我開始在自己的專欄中撰寫一連串網頁親和力的文章，同時也要來弄一本書。而這個部落格也是在這樣的機緣下誕生的。', 2, '2007-08-17 19:48:19'),
(19, 'http://pear.php.net/package/MDB2/docs', 'PEAR::MDB2 Docs', 'PEAR::MDB2 線上文件', 4, '2007-08-17 19:57:17'),
(20, 'http://www.oreilly.com/store/newreleases.csp', 'O''Reilly New Book Release', 'O''Reilly 最近新書', 2, '2007-08-17 21:20:59'),
(21, 'http://www.mt-soft.com.ar/2007/08/18/tuning-mysql-server-boost-performance/', 'MySQL 效能調校', 'Tuning MySQL Server to boost performance', 0, '2007-08-18 10:35:36');

-- --------------------------------------------------------

-- 
-- 資料表格式： `tag`
-- 

CREATE TABLE `tag` (
  `tid` int(11) NOT NULL auto_increment,
  `bid` int(11) NOT NULL,
  `name` varchar(32) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=78 ;

-- 
-- 列出以下資料庫的數據： `tag`
-- 

INSERT INTO `tag` (`tid`, `bid`, `name`) VALUES 
(1, 1, 'PHP'),
(2, 2, 'PHP'),
(3, 2, 'PEAR'),
(4, 3, 'PHP'),
(5, 3, 'News'),
(6, 11, 'Wiki'),
(7, 11, 'PEAR'),
(8, 11, 'PHP'),
(24, 16, 'Baseball'),
(25, 16, 'CPBL'),
(29, 18, '親和力'),
(33, 20, '電腦書'),
(34, 21, 'MySQL'),
(35, 21, 'DataBase'),
(36, 19, 'PHP'),
(37, 19, 'PEAR'),
(38, 19, 'Database'),
(60, 17, 'MLB'),
(61, 17, 'CPBL'),
(62, 17, 'Baseball'),
(63, 12, 'Apache'),
(64, 12, 'MySQL'),
(65, 12, 'PHP'),
(68, 13, 'MsSQL'),
(69, 13, 'DataBase'),
(70, 15, 'MLB'),
(71, 15, 'Baseball'),
(75, 14, 'MSSQL'),
(76, 14, 'DATABASE'),
(77, 14, 'Microsoft');
