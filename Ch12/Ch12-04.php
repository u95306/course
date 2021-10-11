<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>使用Calendar套件的驗證功能</title>
</head>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
  年:<input type="text" name="year" size="4"/>
  月:<input type="text" name="month" size="2"/>
  日:<input type="text" name="day" size="2"/><br />
  <input type="submit" value="產生Calendar_Day物件"/>
</form>   
<hr />
  <?php
  require_once('Calendar/Day.php');  // 引入 Calendar_Day 類別

  // 檢查表單有無輸入值
  // 若表單無資料, 則使用2008年1月1日
  if(!isset($_POST['year']))  $_POST['year']=2008;
  if(!isset($_POST['month'])) $_POST['month']=1;
  if(!isset($_POST['day']))   $_POST['day']=1;

  // 建立日期物件
  $day= new Calendar_Day($_POST['year'],$_POST['month'],$_POST['day']);

  // 檢查物件的日期是否合法
  if ($day->isValid()) 
    echo '您輸入的是合法的日期';
  else {                                // 若日期不合法
    $validator= & $day->getValidator(); // 取得驗證物件
    // 取得 Calendar_Validation_Error 物件
    $error = $validator->fetch();  
    echo $error->getMessage();          // 輸出錯誤訊息
    $day->adjust();                     // 將日期調整為合法日期
    echo '<br/>調整後的日期是' . $day->thisYear() . '/' . 
         $day->thisMonth() . '/' . $day->thisDay() . '<br />'; 
  }

  // 建立 2 月 29 日的物件, 用檢查該日期是否有效
  // 以便判斷使用者輸入的年是否為閏年
  $day= new Calendar_Day($_POST['year'],2,29);  
  if ($day->isValid())                  // 若日期合法       
    echo $_POST['year'] . '年是閏年';            
  else                                  // 若日期不合法
    echo $_POST['year'] . '年不是閏年';
  ?>
</body>
</html>
