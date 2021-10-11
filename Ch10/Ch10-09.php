<?php
header('Content-Type: text/html; charset=utf-8');
include("mysql.inc.php");

//設定本程式所使用的資料表
$myTable='surl';
//取得目前程式所在的網址與程式的檔案名稱
$myHost=$_SERVER['HTTP_HOST'];
$myUri=$_SERVER['PHP_SELF'];
//定義 $shortUrl 變數, 用以存放短網址
$shortUrl="";

function myStripslashes($value){
  if (get_magic_quotes_gpc())
    $value = stripslashes($value);
  return $value;
}



//---------------------- 取得 longUrl 與 id 參數 --------------------
//如果以 POST 方式傳遞過來的 longUrl 參數不是空字串
if ( isset($_POST['longUrl']) ) {
  //將表單傳遞過來的 longUrl 參數設定給變數 $longUrl
  $longUrl=myStripslashes($_POST['longUrl']);
}
else {
  $longUrl="";
}

//如果以 GET 方式傳遞過來的 id 參數不是空字串,
//便將 id 參數內的編號設定給變數 $id
if ( isset($_GET['id']) ) {
  $id=myStripslashes($_GET['id']);
}
else {
  $id="";
}



//---------------------- 縮短網址 -----------------------------------
//如果 $longUrl 變數不是空字串, 表示使用者想要縮短網址
if ($longUrl != "") {
  //將使用者輸入資料中的特殊字元加上反斜線
  $longUrl=mysql_real_escape_string($longUrl);
  //將長網址新增至資料庫中
  mysql_query("INSERT $myTable (url) VALUES ('$longUrl')");
  //取得剛才新增資料的編號
  $id=mysql_insert_id();
  //設定短網址
  $shortUrl="http://$myHost$myUri?id=$id";
}



//---------------------- 連線長網址 ---------------------------------
//如果 $id 變數不是空字串, 表示使用者想要使用短網址連線長網址
elseif ($id != "") {
  //將使用者輸入資料中的特殊字元加上反斜線
  $id=mysql_real_escape_string($id);
  //依照編號取得資料庫中的長網址
  $result=mysql_query("SELECT url FROM $myTable WHERE id=$id");
  $row=mysql_fetch_array($result);
  //將使用者轉向到長網址
  header("Location: ".$row['url']);
}
?>
<html>
<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">
  <title>短網址網站</title>
  <link href="Ch10.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="wrapper">
  <div id="title">
		<img id="title_img" src="logo.jpg" />
    <h1>短網址網站</h1>
  </div>
  <div id="maintext">
<?php
//---------------------- 顯示短網址 ---------------------------------
//如果 $shortUrl 變數不是空字串, 表示程式已經將網址縮短,
//所以顯示 $shortUrl 變數內的短網址
if ( $shortUrl != "") {
  echo "
  您的網址: <a href='$longUrl'>$longUrl</a><br />
  已經縮短為: <a href='$shortUrl'>$shortUrl</a>
  ";
  


//---------------------- 顯示輸入長網址的表單 -----------------------
//若 $shortUrl 變數是空字串, 表示此為第一次連線,
//所以顯示表單讓使用者輸入長網址
} else {
  echo '
  <form method="post" action="'.$myUri.'" name="addurl">
    請輸入想要縮短的網址：<br />
    <input maxlength="128" size="50" name="longUrl"><br />
    <input name="submit" value="送出" type="submit">
  </form>';
}
?>
  </div>
</body>
</html>
