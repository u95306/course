<?php
header("content-type:text/html; charset=utf-8");

if( ! @$fh=fopen("Ch07-04.txt","r") ){
  //若無法成功開啟檔案, 則中斷程式並顯示錯誤訊息
  die('無法開啟檔案');
}

//$i 變數用來計算並存放行號
$i=1;

//用 while 迴圈逐行讀取檔案
while( $str=fgets($fh) ){

  //加上行號
  $str=$i . '. ' . $str;
  
  //顯示在網頁上
  echo $str . '<br />';
  
  //行號加 1, 作為下一次使用的行號
  $i=$i+1;
}

//關閉檔案
fclose($fh);
?>
