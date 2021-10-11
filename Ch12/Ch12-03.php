<?php
  require_once('Calendar/Day.php'); // 引用 Calendar_Day 類別
  $day= new Calendar_Day(2008,1,1); // 建立 2008年1月1日的日期物件

  header("Content-type:text/html;charset=UTF-8");
  
  echo 'thisHour(true):';
  // 取得2008年1月1日0時0分0秒的時間戳記
  echo $day->thisHour(true).'<br/>'; // 呼叫任一個 thisXXX() 方法均可
  
  // 改用 mktime() 取得時間戳記
  echo 'mktime():';                 
  echo mktime($day->thisHour(),    // 呼叫 thisXXX() 方法傳回 
              $day->thisMinute(),  // 時、分、秒、月、日、年的值當參數
              $day->thisSecond(),
              $day->thisMonth(),
              $day->thisDay(),
              $day->thisYear());
?>
