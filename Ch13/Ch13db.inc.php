<?php
require_once('MDB2.php');         // 引用 MDB2
$dsn = 'mysql://root:123@localhost/Ch13?charset=utf8';
$mdb2 =& MDB2::factory($dsn);     // 建立連線
if (PEAR::isError($mdb2))    
  die('連線資料庫錯誤：' . $mdb2->getMessage());
  
$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);  // 以欄位名稱為索引
?>
