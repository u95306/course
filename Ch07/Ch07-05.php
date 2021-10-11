<?php
header("content-type:text/html; charset=utf-8");

//設定訪客計數器存放人數的檔案
$counter_file='Ch07-05.txt';

//如果計數器檔案不存在, 便建立並存入人數 0
if ( ! file_exists($counter_file) ) {
  file_put_contents($counter_file, 0);
}

//取得計數器紀錄的上次到訪人數
$count=file_get_contents($counter_file);
  
//上次到訪人數加 1 便是本次到訪人數
$count=$count + 1;

//顯示到訪人數
echo "本站到訪人數: $count";
  
// 將新的到訪人數寫入檔案
file_put_contents($counter_file, $count);
?>
