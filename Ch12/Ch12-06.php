<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>使用Calendar套件建立表格式月曆</title>
  <style>
    table{border:2px double;font-size:large}
    td{padding:2px;text-align:center;}
    image{height:24;vertical-align:middle;border:0px}
    .holiday{background-color:orange;}
  </style>
</head>
<body>
<?php
  // 月份名稱陣列
  $monthName=array ('一月','二月','三月','四月','五月','六月',
                    '七月','八月','九月','十月','十一月','十二月');

  // 建立 URL 字串的函式
  // 函式會在網址後面附上『?y=年份&m=月份』的 GET 參數
  // 年份和月份則由參數指定
  function buildURL($year,$month){
    // 將參數中的年及月數字, 附加在 URL 後面
    return $_SERVER['PHP_SELF'].'?y='.$year.'&m='.$month;
  }

  define('CALENDAR_ENGINE', 'PearDate');  // 使用 PearDate 引擎
  require_once('Calendar/Month/Weekdays.php'); // 引用類別 
  require_once('Calendar/Day.php');

  $now = getdate();                      // 取得今天日期
  
  // 若沒有 GET 參數, 則使用今天的年月當成 GET 參數
  if(!isset($_GET['y'])) $_GET['y'] = $now['year'];
  if(!isset($_GET['m'])) $_GET['m'] = $now['mon'];

  // 由 GET 參數建立月物件
  $month = new Calendar_Month_Weekdays($_GET['y'],$_GET['m']);

  // 建立去年和明年的連結字串
  $prevYear = buildURL($month->prevYear(),$month->thisMonth());
  $nextYear = buildURL($month->nextYear(),$month->thisMonth());
?>
<table>
<caption>
  <!-- 建立前一年連結、輸出目前年份、建立下一年的連結 -->
  <a href=" <?php echo $prevYear; // 輸出前一年的連結字串 ?> ">
  <!-- 顯示兩個向左箭頭 -->
  <img src="prev.gif"><img src="prev.gif">
  </a>&nbsp;
  <?php
  // 在前一年、下一年的連結之間, 輸出目前年份
  echo ( $month->thisYear()); 
  ?>
  &nbsp;
  <a href=" <?php echo $nextYear; // 輸出次年的連結字串 ?> ">
  <!-- 顯示兩個向右箭頭 -->
  <img src="next.gif"><img src="next.gif">
  </a><br />
  <?php
  // 建立上個月和下個月的連結
  // 當月份為 1 時, 上個月需的連結需指向為前一年 12 月
  // 如此在瀏覽月曆時才會連貫
  // 所以第 1 個參數需用 $month->prevYear()
  $prevMonth = buildURL($month->thisMonth()==1?$month->prevYear():
                                               $month->thisYear(), 
                        $month->prevMonth());

  // 同理, 當月份為 12 時, 下個月的連結需指向次年的 1 月
  // 所以第 1 個參數需用 $month->nextYear()
  $nextMonth = buildURL($month->thisMonth()==12?$month->nextYear():
                                                $month->thisYear(), 
                        $month->nextMonth());
  ?>
  <!-- 建立前一月連結、輸出目前月份、建立下一月的連結 -->
  <a href=" <?php echo $prevMonth; // 輸出前一月的連結字串 ?>">
  <img src="prev.gif"></a>
  &nbsp;&nbsp;
  <?php
  // 在前一月、下一月的連結之間, 輸出目前月份的中文名稱 
  echo $monthName[$month->thisMonth()-1]; 
  ?>
  &nbsp;&nbsp;
  <a href=" <?php echo $nextMonth; // 輸出下一月的連結字串 ?>">
    <img src="next.gif"></a>
</caption>
<tr>
  <th>一</th><th>二</th><th>三</th>
  <th>四</th><th>五</th><th>六</th><th>日</th>
</tr>
<?php
$selected = array (       // 特殊日期陣列
      new Calendar_Day($_GET['y'],1,1),
      new Calendar_Day($_GET['y'],2,28),
      new Calendar_Day($_GET['y'],4,5),
      new Calendar_Day($_GET['y'],10,10));
$month->build($selected); // 建立日物件

// 以下迴圈負責輸出表格中的日曆內容
while ( $day = $month->fetch() ) {
  if ( $day->isFirst() )  // 若是該週第1天
    echo ( "<tr>\n" );    // 則輸出 <tr>, 開始新的1列

  // 以下輸出月曆表格中的 <td> 標籤
  if ( $day->isEmpty() ) {   // 若為空白日期
    echo ( "<td>&nbsp;</td>\n" ); // 輸出空白 
  }
  elseif ( $day->isSelected() ) {  // 若為特殊日期
                               // 將 <td> 標籤之類別設為 "holiday"   
    echo ( '<td class="holiday">' . $day->thisDay(). "</td>\n");
  } 
  else                            // 若為一般日期
    echo ( '<td>' . $day->thisDay() . "</td>\n" );
    
  if ( $day->isLast() )  // 若是該週最後1天
    echo ( "</tr>\n" );  // 則輸出 </tr> 結束此列
}
?>
</table>
</body>
</html>
