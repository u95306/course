<html>
<head>
  <meta http-equiv="content-type" 
        content="text/html; charset=UTF-8">
  <title>簡易行事曆</title>
  <style>
    body{background:url(pinknet.jpg);font-size:12px}
    table{border:2px solid green;font-size:24px}
    td{padding:3px;text-align:center;}
    img{height:18px;vertical-align:middle;border:0px}
    
    /* .hasmemo 類別代表已有備忘錄的日期欄位, 讓欄位背景呈橘色 */
    .hasmemo{background-color:orange; }
  </style>
  <script type="text/javascript">
  // 以開啟新瀏覽器視窗的方式, 瀏覽 Ch12-11.php 網頁的函式
  // 參數 date_str 是以 GET 方式為傳送給 Ch12-11.php 的日期字串
  function popUp(date_str) {
    window.open("Ch12-11.php?date=" + date_str,
                "todoList",                 // 視窗名稱
                "toolbar=no,scrollbars=no," + // 無工具列及捲軸 
                "statusbar=no,menubar=no," +     // 無狀態列及功能表
                "width=250,height=315");    // 寬高為 250, 315px
  }  
  </script>
</head>
<body>
<?php
  // 月份名稱陣列
  $monthName=array ('一月','二月','三月','四月','五月','六月',
                    '七月','八月','九月','十月','十一月','十二月');

  // 建立連結字串的函式
  function buildURL($year,$month){
    return $_SERVER['PHP_SELF'].'?y='.$year.'&m='.$month;
  }

  define('CALENDAR_ENGINE', 'PearDate');  // 使用 PearDate 引擎
  require_once('Calendar/Month/Weekdays.php');  // 引用月曆類別
  require_once('Calendar/Day.php');       // 引用 Calendar_Day 類別
  require_once('Ch12db.inc.php');         // 引用資料庫設定檔

  $now = getdate();                      // 取得今天日期
  
  // 若沒有 GET 參數, 則使用今天的年當成 GET 參數
  if(!is_numeric($_GET['y'])) 
    $_GET['y']=$now['year'];
  // 若沒有 GET 參數, 或月份數超出範圍, 則使用今天的月份
  if(!is_numeric($_GET['m']) || ($_GET['m'] >12 || $_GET['m']<1)) 
    $_GET['m']=$now['mon'];
  
  // 由 GET 參數建立月物件
  $month = new Calendar_Month_Weekdays($_GET['y'],$_GET['m']);

  // 建立去年和明年的連結字串
  $prevYear = buildURL($month->prevYear(),$month->thisMonth());
  $nextYear = buildURL($month->nextYear(),$month->thisMonth());
?>
<table>
<caption>
  <!-- 建立前一年連結、輸出目前年份、建立下一年的連結 -->
  <a href="<?php echo ($prevYear);?>">
    <img src="prev.gif"><img src="prev.gif"></a>
  <?php echo ( $month->thisYear()); ?>
  <a href="<?php echo ($nextYear);?>">
    <img src="next.gif"><img src="next.gif"></a><br />
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
  <a href="<?php echo ($prevMonth);?>"><img src="prev.gif"></a>
  <?php echo $monthName[$month->thisMonth()-1]; ?>
  <a href="<?php echo ($nextMonth);?>"><img src="next.gif"></a>
</caption>
<tr>
<th>一</th><th>二</th><th>三</th>
<th>四</th><th>五</th><th>六</th><th>日</th>
</tr>
<?php
  // 設定查詢字串
  // 由 todolist 資料表找出 sdate 欄的年、月等於目前網頁年月的日期
  $query = sprintf('SELECT dayofmonth(sdate) FROM todolist  
                    WHERE year(sdate)=%s && month(sdate)=%s', 
                    $mdb2->quote($_GET['y']), 
                    $mdb2->quote($_GET['m']));
  
  $res =& $mdb2->query($query); // 執行查詢
  if (PEAR::isError($res)) 
    die('查詢發生錯誤：' . $res->getMessage());
  
  $rows = $res->fetchAll();
  if (PEAR::isError($rows)) 
    die('存取資料失敗：' . $rows->getMessage());
  
  // 以迴圈將查詢結果中的日期建立成 Calendar_Day 物件
  // 並將之加到 $selected 陣列當成特殊日期陣列
  foreach($rows as $date)  
    $selected[]  = new Calendar_Day($_GET['y'], 
                                    $_GET['m'] , 
                                    $date[0] );
  // 以含備忘錄的日期為特殊日期, 建立本月的日期子物件
  $month->build($selected);

  
  // 以下迴圈負責輸出表格中的日曆內容
  while ( $day = $month->fetch() ) {
    if ( $day->isFirst() )          // 若是該週第1天
      echo ( "<tr>\n" );            // 則輸出 <tr>, 開始新的1列    
    
    if ( $day->isEmpty() )          // 若為空白日期
      echo ( "<td>&nbsp;</td>\n" ); // 輸出空白 
    
    else {                          // 其它非空白日期
      echo ($day->isSelected())?    // 若為有備忘錄的日期 
           '<td class="hasmemo">':  // 則替標籤設定類別
           '<td>';                  // 否則只輸出 <td>    

      // 建立格式為 "年-月-日" 的字串, 用於呼叫 popUp() 時當參數
      $date_str = $day->thisYear() . '-' . 
                  $day->thisMonth() . '-' . 
                  $day->thisDay();
     
      // 將日期設為呼叫 JavaScript 函式 popUp() 的連結 
      // 並使用剛才建立的 "年-月-日" 字串當參數
      echo "<a href=\"javascript:popUp('$date_str')\">" .
           $day->thisDay() . "</a></td>\n"; // 輸出日期當成連結文字
    }
  
    if ( $day->isLast() )    // 若是該週最後1天
      echo ( "</tr>\n" );    // 則輸出 </tr> 結束此列
  }
?>
</table>
<p>按日期即可瀏覽與編輯當天行事備忘錄</p>
</body>
</html>
