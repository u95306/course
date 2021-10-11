<?php
//資料庫設定
$dbServer = "localhost";
$dbName = "ch10";
$dbUser = "root";
$dbPass = "123";

//連線資料庫伺服器
if ( ! @mysql_connect($dbServer, $dbUser, $dbPass) )
  die("無法連線資料庫伺服器");

//設定連線的文字集與校對為 UTF8 編碼
mysql_query("SET NAMES utf8");

//選擇資料庫
if ( ! @mysql_select_db($dbName) )
  die("無法使用資料庫");

?>
