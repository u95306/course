<?php
header('Content-Type: text/html; charset=utf-8');
include("mysql.inc.php");

function myStripslashes($value){
  if (get_magic_quotes_gpc())
    $value = stripslashes($value);
  return $value;
}

//設定本程式所使用的資料表
$myTable='guestbook';
//定義 $errMsg 變數, 用以存放錯誤訊息
$errMsg='';

//檢查是否已輸入姓名
if ( isset($_POST['name']) && $_POST['name'] !='' ) {
  //將姓名放入 $name 變數
  $name=myStripslashes($_POST['name']);
//若否, 則將錯誤訊息寫入 $errMsg 變數
} else {
  $name='';
  $errMsg.='您忘記輸入姓名<br />';
}

//檢查是否已輸入留言
if ( isset($_POST['message']) && $_POST['message'] !='' ) {
  //將留言放入 $message 變數
  $message=myStripslashes($_POST['message']);
} else {
  $message='';
  $errMsg.='您忘記輸入留言<br />';
}
?>
<html>
<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">
  <title>簡易留言板</title>
  <link href="Ch10.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="wrapper">
  <div id="title">
		<img id="title_img" src="logo.jpg" />
    <h1>簡易留言板</h1>
  </div>
  <div id="maintext">
<?php
//如果 $errMsg 是空字串, 表示沒有錯誤,
//所以我們可以放心將留言寫入資料庫
if ($errMsg ==''){
  //設定使用台北時區
  date_default_timezone_set('Asia/Taipei');
  //將姓名、留言、目前的日期時間寫入資料庫
  $sql=sprintf("INSERT $myTable (`姓名`, `留言`, `日期時間`)
                VALUES ('%s', '%s', '%s')",
               mysql_real_escape_string($name),
               mysql_real_escape_string($message),
               date("Y-m-d H:i:s") );
  $result=mysql_query($sql);
  if (mysql_affected_rows() > 0){
    echo '已經成功新增一筆留言<br />';
  }
  else {
    echo '無法新增留言<br />';
  }
}
//如果 $errMsg 不是空字串, 便顯示錯誤訊息
else {
  echo $errMsg . '請按瀏覽器的上一頁鈕重新輸入<br />';
}
?>
    <p><a href="Ch10-10-01.php">回留言板</a></p>
  </div>
</body>
</html>
