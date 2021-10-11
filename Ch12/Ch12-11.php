<html>
<head>
  <meta http-equiv="content-type" 
        content="text/html; charset=UTF-8">      
  <title>單日行事備忘錄</title>
</head>
<body style ="background:url(2hearts.jpg);color:blue">
<?php
  define('CALENDAR_ENGINE', 'PearDate');  // 使用 PearDate 引擎
  require_once('Calendar/Day.php');       // 引用 Calendar_Day 類別
  require_once('Ch12db.inc.php');         // 引用資料庫設定檔                                 
  // 若沒有 GET 參數, 則使用今天的年月日當成 GET 參數
  if(empty($_GET['date'])) {
    $now = getdate();                      // 取得今天日期
    $date_str = $now['year'] . '-' . $now['mon'] . '-' . $now['mday'];
  }
  else
    $date_str = $_GET['date']; 
  

  // 查詢指定日期的備忘錄
  $query = 'SELECT memo FROM todoList WHERE sdate =' . 
           $mdb2->quote($date_str);
                                                                           
  $res =& $mdb2->query($query); // 執行查詢
  if (PEAR::isError($res))
    die('查詢發生錯誤：' . $res->getMessage());
  $memo = $res->fetchOne();     // 取出備忘錄資料

  // 若是送回表單 (非第一次瀏覽)
  if(isset($_GET['memo'])) {    
    if (get_magic_quotes_gpc())
      $memo = stripslashes($_GET['memo']);
    $memo = trim($memo);    // 去除前後空白
    
    // 依前面的查詢結果判斷要執行的 SQL 敘述 
    if ($res->numRows()==1) {    // 資料表中已有此日期的記錄
      // 檢查表單傳回的是否為空字串
      if (empty($memo))  // 是空字串, 則刪除資料
        $sql = 'DELETE FROM todoList WHERE sdate =' . 
               $mdb2->quote($date_str);
      else               // 非空字串 
                         // 則用表單傳回內容更新資料表
        $sql = sprintf('UPDATE todoList SET memo=%s WHERE sdate=%s', 
               $mdb2->quote($memo,'text'),
               $mdb2->quote($date_str));
                                                                           
      $res = $mdb2->exec($sql);
      if (PEAR::isError($res))
        die('更新發生錯誤：' . $res->getMessage());
      $message = '修改成功';      // 設定要顯示的訊息
    }                                                                      

    // 若資料表中無此日期的記錄, 且表單傳回備忘錄資料
    // 則使用 'INSERT INTO' 將備忘錄新增至資料庫
    elseif (!empty($memo)) { 
      $sql = sprintf('INSERT INTO todoList (sdate, memo) VALUES (%s,%s)',
                     $mdb2->quote($date_str),
                     $mdb2->quote($memo));
      $res = $mdb2->exec($sql);
      if (PEAR::isError($res))
        die('新增發生錯誤：' . $res->getMessage());
      $message = '新增成功';      // 設定要顯示的訊息
    }
  }
  
  // 輸出目前瀏覽的備忘錄所屬日期
  echo "<strong>$date_str 行事備忘錄</strong>";
?>
<form method="get" action=" <?php echo $_SERVER['PHP_SELF'];?> ">
  <textarea name="memo" rows="8"><?php 
    echo htmlspecialchars($memo); // 輸出當天備忘錄   
  ?></textarea>
  <!-- 儲存目前備忘錄所屬日期之隱藏欄位 -->
  <!-- 如此在送回表單時, 網頁也能得知目前處理的年、月、日-->                             
    <input type="hidden" name="date" value="<?php echo $date_str;?>">
  <!-- 隱藏欄位結束 -->
  <input type="submit" value="修改">

  <!-- 將按鈕動作設為執行 JavaScript 內建的 window.close() 函式 -->
  <!-- 此函式會關閉目前的瀏覽器視窗 -->
  <input type="button" value="關閉視窗" onClick="window.close()">
</form>
<span style="color:red;font-size:x-small">
  <?php echo $message; // 輸出更新資料庫的訊息  ?>
</span>
</body>
</html>
