<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>建立日期子物件</title>
</head>
<body>
<form method="post">
  年:<input type="text" name="year" size="5" /><br />
  月:
  <select name="month"/>
    <?php
    require_once('Calendar/Year.php');// 引入 Calendar_Year 類別

    $year = new Calendar_Year(2000);  // 隨意建立一個年物件 
    $year->build();                   // 產生該年的所有月物件
    echo '<option>&nbsp</option>';
    
    // 逐一取得該年中的月物件
    // 並用該月物件輸出月份數字, 建立下拉式選單中的月選項
    while($month = $year->fetch())    
      echo '<option value="' . $month->thisMonth() . "'>" . 
           $month->thisMonth() . '</option>';
    ?>
  </select>
  <br /><input type="submit" value="顯示月曆" />    
</form>
<?php
// 用表單中的年、月數字建立月物件
$month = new Calendar_Month($_POST['year'],$_POST['month']);

// 若為有效月份則輸出該月的日期數字
if($month->isValid()) { 
  echo '<hr/>';
  echo htmlspecialchars($_POST['year']) . ' 年 ' .
       $_POST['month'] . ' 月有 ' . $month->size() . ' 天<br />';
  
  $month->build();            // 產生該月的所有日物件
  $days = $month->fetchall(); // 取得含所有日物件的陣列
  foreach ($days as $day)     // 逐一輸出陣列中各日物件的日期數字
    echo $day->thisDay() . '&nbsp;';
}
?>
</body>
</html>
