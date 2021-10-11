<?php
//設定網頁使用 UTF-8 編碼
header('Content-Type: text/html; charset=utf-8');

if ( ! @mysql_connect("localhost", "root", "wrongPass") )
  die("無法連線資料庫伺服器, 請聯絡系統管理員 mis@php.flag.com.tw");
?>
