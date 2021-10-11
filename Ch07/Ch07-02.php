<?php
header("content-type:text/html;charset=utf-8");

if ( @$num=file_put_contents("Ch07-02.txt","旗標出版社") ) {
  echo "共寫入 $num 個位元組";
}
else {
  echo "無法寫入檔案！";
}
?>
