<?php
//header() 設定此頁面使用 UTF8 編碼,
//關於 header() 的說明請參考 5-6 節
header("content-type:text/html;charset=utf-8");

//@ 符號可抑制錯誤輸出, 可以避免無法讀取檔案時,
//PHP 輸出錯誤訊息, 影響網頁的版面與畫面
if ( @$contents=file_get_contents("Ch07-01.txt") ) {
  echo '以下是 Ch07-01.txt 的內容:<hr />' . $contents;
}
else {
  echo '讀取失敗';
}
?>
