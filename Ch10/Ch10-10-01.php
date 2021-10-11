<?php
header('Content-Type: text/html; charset=utf-8');
include("mysql.inc.php");

//設定本程式所使用的資料表
$myTable='guestbook';

//查詢資料表內所有內容, 並且依照編號遞減排序, 讓最新留言顯示在最前面
$result=mysql_query("SELECT * FROM $myTable ORDER BY 留言編號 DESC");

//取得留言的總筆數
$numRows=mysql_numRows($result);
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
  
<?php echo "共有 $numRows 筆留言 "; ?>

 	<div id="navigation"><a href="Ch10-10-02.html">我要留言</a></div>
    <ul>
<?php
//如果留言筆數大於 0, 便顯示留言的內容
if ($numRows>0) {
  $i=1;
  while ($row = mysql_fetch_array($result)) {
    //將姓名中的特殊字元轉成 HTML 碼
    $name=htmlspecialchars($row['姓名'], ENT_QUOTES);
    //將留言中的特殊字元、換行字元、與空白轉成 HTML 碼
    $message=htmlspecialchars($row['留言'], ENT_QUOTES);
    $message=str_replace('  ', '&nbsp;&nbsp;', nl2br($message));

    //顯示不同的背景顏色, 方便閱讀
    if ($i%2==0){$liclass='even';}
    else {$liclass='odd';}

    //顯示留言者姓名、留言日期時間、與留言內容
    echo "<li class=\"$liclass\"><p><strong>$name</strong><em> 於 {$row['日期時間']}
         留言</em></p><p>$message</p></li>";
    $i++;
  }
}
?>
    </ul>
  </div>
</body>
</html>
