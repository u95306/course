<?php
header('content-type: text/html; charset=utf-8');
require_once('MDB2.php');         // 引用 MDB2
$dsn = 'mysql://root:123@localhost/Ch09?charset=utf8';
$query_str = 'SELECT 書籍名稱,價格 FROM books';

$mdb2 =& MDB2::factory($dsn);     // 建立連線
if(PEAR::isError($mdb2))    
  die('連線資料庫錯誤：' . $mdb2->getMessage());

$res =& $mdb2->query($query_str); // 執行查詢
if(PEAR::isError($res)) 
  die('查詢發生錯誤：'. $res->getMessage());

$rows = $res->fetchAll();
if(PEAR::isError($rows)) 
  die('存取資料失敗：' . $rows->getMessage());

require_once('Ch13Smarty.php');  // 引用自訂類別
$smarty = new Ch13Smarty();      // 建立自訂類別物件 

$smarty->assign('header',array('書籍名稱','價格'));
$smarty->assign('data',$rows);   // 設定要顯示的資料   
$smarty->display('Ch13-06.tpl'); // 顯示網頁
?>
