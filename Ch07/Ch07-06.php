<?php
header("content-type:text/html; charset=utf-8");

//設定要讀取的目錄
$dirname = 'C:/Windows/IME/';

//讀取目錄後, 將檔案與子目錄名稱放入 $dirlist 陣列
$dirlist = scandir($dirname);

//逐筆讀取檔案與子目錄名稱
foreach ( $dirlist as $key => $name){
  echo "\$dirlist[$key] = " . $name . '<br />';
}
?>
