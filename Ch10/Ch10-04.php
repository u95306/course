<?php
header('Content-Type: text/html; charset=utf-8');
include("mysql.inc.php");

//查詢【books】資料表中價格大於 400 的記錄
//並且取得其中【書籍名稱】與【價格】兩個欄位的資料
$sql="SELECT 書籍名稱,價格 FROM books WHERE 價格 > 400";
$result=mysql_query($sql);

//取得查詢結果的筆數
$total=mysql_num_rows($result);

//使用表格顯示資料
echo "共有 $total 本價格大於 400 的書籍<br />
      <table border='1'><tr><td>書籍名稱</td><td>價格</td></tr>";

//使用迴圈逐筆讀取記錄
while ($row = mysql_fetch_array($result)) {
  echo "<tr><td> {$row['書籍名稱']} </td><td> $row[1] </td></tr>";
}

echo '</table>';
?>
