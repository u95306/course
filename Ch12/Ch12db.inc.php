<?php
  require_once('MDB2.php');

  $dsn = "mysql://root:123@localhost/Ch12?charset=utf8";
  
  $mdb2 = & MDB2::factory($dsn);     // 建立連線
  if (PEAR::isError($mdb2))    
    die('連線資料庫錯誤：' . $mdb2->getMessage());
?>
