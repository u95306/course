<?php
require_once('Ch13Smarty.php');  // 引入自訂類別
$smarty = new Ch13Smarty();      // 建立自訂類別物件

$smarty->assign('title', '在樣版中使用大括號');
$smarty->assign('text', '樣版中的 CSS 樣式表有用到大括號');
$smarty->display('Ch13-02.tpl'); // 顯示網頁
?>
