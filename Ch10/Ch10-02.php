<?php
header('Content-Type: text/html; charset=utf-8');
include("mysql.inc.php");

//查詢【books】資料表的【書籍名稱】與【價格】兩個欄位的資料
$result=mysql_query("SELECT 書籍名稱,價格 FROM books");

//---------------------- 讀取第 1 筆記錄 ----------------------------
//使用 mysql_fetch_array() 讀取一筆記錄,
//然後將回傳的陣列設定為 $row 陣列
$row=mysql_fetch_array($result);
//以 $row[0] 取得第一個欄位的資料
echo "第 1 筆記錄的第 1 個欄位：$row[0]";
//以 $row['書籍名稱'] 取得【書籍名稱】欄位的資料
echo "<br />第 1 筆記錄的【書籍名稱】欄位：". $row['書籍名稱'];
echo "<br />第 1 筆記錄的第 2 個欄位：$row[1]";
echo "<br />第 1 筆記錄的【價格】欄位：{$row['價格']}";

//---------------------- 讀取第 2 筆記錄 ----------------------------
$row=mysql_fetch_array($result);
echo "<br /><br />第 2 筆記錄的第 1 個欄位：$row[0]";
echo "<br />第 2 筆記錄的【書籍名稱】欄位：{$row['書籍名稱']}";
?>
