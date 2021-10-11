<?php
header('Content-Type: text/html; charset=utf-8');
include("mysql.inc.php");

//如果以 GET 方式傳遞過來的 edit 參數不是空字串
if ($_GET['edit'] !=''){
  //查詢 edit 參數所指定編號的記錄, 從資料庫將原有的資料取出
  $sql="SELECT * FROM inventory WHERE 編號 = '{$_GET['edit']}' ";
  $result=mysql_query($sql);
  //將查詢到的資料放在 $row 陣列
  $row=mysql_fetch_array($result);
}
else {
  //如果沒有 edit 參數, 表示此為錯誤執行, 所以轉向回主頁面
  header("Location: CH10-08.php");
}
?>
<html>
<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">
  <title>書籍存貨管理系統</title>
</head>
<body>
  <!--定義一個編輯資料的表單, 並且將編輯好的資料
      傳遞給 Ch10-08-02.php 進行處理 -->
  <form method="post" action="Ch10-08-02.php">
    書名: <?php echo $row['書籍名稱'];?>

    <!--將原本的資料設定於 <input> 標籤的 value 參數, 如此
       【數量】欄位內就會自動填上原本的資料 -->
    數量: <input name="qty" value="<?php echo $row['數量'];?>"
           style="width: 73px" />

    <!--將編號設定於隱藏的 <input> 標籤,
        以便將編號數字傳遞給 Ch10-08-02.php -->
    <input name="id" type="hidden" value="<?php echo $row['編號'];?>" />
    <input name="submit" type="submit" value="送出" />
  </form>
  <p><a href="Ch10-08.php">回系統首頁</a></p>
</body>
