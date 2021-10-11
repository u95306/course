<?php
  header('Content-Type: text/html; charset=utf-8');
include("mysql.inc.php");

//如果網頁表單的 name 與 qty 欄位都不是空字串
if ($_POST['name'] !='' && $_POST['qty'] !='' ){
  //將 name 與 qty 欄位值新增至 【inventory】 資料表
  $sql="INSERT inventory (書籍名稱, 數量)
        VALUES ('{$_POST['name']}','{$_POST['qty']}')";
  mysql_query($sql);
}
?>
<html>
<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">
  <title>書籍存貨管理系統</title>
</head>
<body>
  <form method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
    書名: <input name="name" />
    數量: <input name="qty" style="width: 73px" />
    <input name="submit" type="submit" value="送出" />
  </form>
<?php

//使用【書籍名稱】排序, 查詢 【inventory】 資料表的所有資料
$sql="SELECT * FROM inventory ORDER BY 書籍名稱 ASC";
$result=mysql_query($sql);

//如果查到的記錄筆數大於 0, 便使用迴圈顯示所有資料
if (mysql_num_rows($result) >0){
  echo "<hr /><table border='1'>
        <tr><td>書籍名稱</td><td>數量</td></tr>";

  while ($row = mysql_fetch_array($result)) {
    echo "<tr><td>{$row['書籍名稱']}</td>
              <td>{$row['數量']}</td>
              <td><a href='Ch10-07-01.php?del={$row['編號']}'>
                  刪除</a></td></tr>";
  }
  echo '</table>';
}
?>
</body>
