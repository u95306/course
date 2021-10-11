<?php
require_once('Ch13Smarty.php');  // 引用自訂類別
$smarty = new Ch13Smarty();      // 建立自訂類別物件 
$smarty->display('Ch13-04.tpl'); // 顯示網頁
?>
