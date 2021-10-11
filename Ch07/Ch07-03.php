<?php
header("content-type:text/html;charset=utf-8");

//開啟檔案
if( ! @$fh=fopen("Ch07-03.txt","w") ){
  //若無法成功開啟檔案, 則中斷程式並顯示錯誤訊息
  die('無法開啟檔案');
}

//寫入檔案
if ( @fputs($fh, '旗標出版社') ) {
  echo '成功寫入檔案';
}
else {
  echo '無法寫入檔案';
}

//關閉檔案
fclose($fh);
?>
