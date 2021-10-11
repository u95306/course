<?php
require_once('Smarty.class.php'); // 引用類別檔
$smarty = new Smarty();           // 建立物件

// 設定樣版目錄及編譯結果目錄
$smarty->template_dir = "C:\\wamp\\www\\Ch13\\templates\\";
$smarty->compile_dir = "C:\\wamp\\www\\Ch13\\templates_c\\";

// 設定設定檔目錄及快取目錄 (未用到相關功能時可省略之)
$smarty->config_dir   = "C:\\wamp\\www\\Ch13\\configs\\";

$smarty->assign('title','第一個Smarty網頁');    // 設定樣板變數 title
$smarty->assign('text','利用樣版變數輸出資料'); // 設定樣板變數 text
$smarty->display('Ch13-01.tpl');                // 顯示樣板
?>
