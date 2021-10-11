<?php
header('Content-Type: text/html; charset=utf-8');
include("mysql.inc.php");

//如果以 POST 方式傳遞過來的 id, qty 參數都不是空字串
if ( $_POST['id'] !='' && 
     $_POST['qty'] !='' ){
  //更新 id 參數所指定編號的記錄
  $sql="UPDATE inventory
        SET 數量 = '{$_POST['qty']}'
        WHERE 編號 = '{$_POST['id']}' ";
  
  mysql_query($sql);
}

//取得被更新的記錄筆數
$rowUpdated=mysql_affected_rows();

//如果更新的筆數大於 0, 則顯示成功, 若否, 便顯示失敗
if ($rowUpdated >0){
  echo "資料更新成功";
}
else {
  echo "更新失敗, 或者您輸入的資料與原本相同";
}
?>
<p><a href="Ch10-08.php">回系統首頁</a></p>
