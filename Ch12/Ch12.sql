-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- 主機: localhost
-- 建立日期: Dec 15, 2007, 07:14 PM
-- 伺服器版本: 5.0.41
-- PHP 版本: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 資料庫: `ch12`
-- 
CREATE DATABASE `ch12` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ch12`;

-- --------------------------------------------------------

-- 
-- 資料表格式： `todolist`
-- 

CREATE TABLE `todolist` (
  `sdate` date NOT NULL,
  `memo` varchar(512) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`sdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- 列出以下資料庫的數據： `todolist`
-- 

INSERT INTO `todolist` (`sdate`, `memo`) VALUES 
('2007-08-16', '19:00 讀書會\r\n21:00 看電影'),
('2007-08-23', '19:00 讀書會\r\n22:00 唱歌去'),
('2007-11-20', '07:00 跑步\r\n17:00 同學會');