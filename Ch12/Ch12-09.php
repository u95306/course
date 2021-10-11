<?php 
  session_start();   // 稍後將用 session 記錄每頁要顯示的項目數 
?>
<html>
<head>
  <meta http-equiv="content-type" 
        content="text/html; charset=UTF-8">
  <title>PEAR::Pager進階用法</title>
  <style>
    table{border:2px blue solid;
          border-collapse:collapse; width:360px}
    th,td{border:1px blue solid}
    img{height:18px; border:0px; vertical-align:middle}
  </style>
</head>
<body>
  <?php
  require_once('MDB2.php');   // 引用 MDB2 類别
  require_once('Pager.php');  // 引用 Pager 類别
  $dsn = 'mysql://root:123@localhost/Ch09?charset=utf8';  // DSN
  $query_str = 'SELECT `書籍名稱`,`價格` from books';     // 查詢字串

  $mdb2 =& MDB2::connect($dsn);     // 建立連線
  if (PEAR::isError($mdb2))    
    die('連線資料庫錯誤：' . $mdb2->getMessage());

  $res =& $mdb2->query($query_str); // 執行查詢
  if (PEAR::isError($res)) 
    die('查詢發生錯誤：' . $res->getMessage());

  $mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);  // 以欄位名稱為索引
  $rows = $res->fetchAll();                   // 取得所有資料
  if (PEAR::isError($rows)) 
    die('存取資料失敗：' . $rows->getMessage());
?>
<table>
<tr><th>書籍名稱</th><th width="60">價格</th></tr>
<?php
  // 程式用 $_SESSION['PerPage'] 記錄每頁要顯示的項目數
  // 因此檢查 session 中是否有 'PerPage', 沒有就設定預設值 
  if (!isset($_SESSION['PerPage'])){
    $_SESSION['PerPage']=4;   // 預設每頁顯示 4 筆記錄
  }
  // 若已有 $_SESSION['PerPage']
  else {
    // 檢查表單是否傳回 $_POST['setPerPage'] 
    // (getPerPageSelectBox() 產生的下拉式選單之選項值)
    // 若表單傳回使用者選擇的每頁項目數, 就將新的值寫入 session
    if (isset($_POST['setPerPage'])) {  
      $_SESSION['PerPage'] = $_POST['setPerPage'];
      $_GET[pageID]=1;        // 變更每頁項目數後, 自動跳回第 1 頁
    }    
  }
  
  $params = array(     // 分頁參數
      'mode'       => 'Jumping',      // 使用 Jumping 模式
                                      // 以 session 資料設定每頁項目數 
      'perPage'    => $_SESSION['PerPage'], 
      'itemData'   => $rows,          // 要分頁的資料存於 $rows 中
      'altPrev'     => '上一頁',      // 設定提示文字
      'altNext'     => '下一頁',
      'prevImg'     => '<img src="prev.gif">',  // 設定圖檔
      'nextImg'     => '<img src="next.gif">',
      'showAllText' => '全部');       // 用於 getPerPageSelectBox()
                                      // 的選項字串      
  $pager = & Pager::factory($params); // 建立分頁物件

  $links = $pager->getLinks();        // 取得連結陣列
  
  // 用 $_GET[pageID] 為參數呼叫 getPageData() 方法取得目前頁面資料
  // 第一次進入網頁時 $_GET[pageID] 沒有值, 所以會傳回第 1 頁的資料
  $data  = $pager->getPageData($_GET[pageID]);
  
  // 取得可選擇每頁項目數的下拉式選單之 HTML 字串
  // 以 1 為間隔顯示 2-6 之間的選項 (2,3,4,5,6)
  // 最後的參數 true 表示要再加一個『顯示全部』的選項
  // 該選項的文字就是 $params 陣列中 'showAllText' 元素的內容  
  $selectPerPage = $pager->getPerPageSelectBox(2,6,1,true);
  
  // 取得可選擇目前頁次的下拉式選單之 HTML 字串
  $selectPage = $pager->getPageSelectBox(
              array('optionText'=>'第 %d 頁', // 設定選項文字
                    'autoSubmit'=>true));     // 設定以 JavaScript 
                                              // 傳回選項
  // 用迴圈逐筆輸出本頁資料
  foreach($data as $row)                  // 每一筆資料都放在 <tr> 中
    echo '<tr><td>' . $row['書籍名稱'] .  // 每一欄則放在 <td> 中
         '</td><td>' . $row['價格']. '</td></tr>';
?>
<caption align="center">
<?php  
  echo $links['all'] .        // 輸出分頁連結
       '&nbsp;&nbsp;顯示：' . 
       $selectPage;           // 輸出可選擇目前頁次的下拉式選單
?>
</caption>
</table>
<form method="post" action=" <?php echo $_SERVER['PHP_SELF'];?> ">
  <!-- 輸出可選擇每頁項目數的下拉式選單 -->
  每頁顯示<?php echo $selectPerPage; ?>項
  <input type=submit value="確定">
</form>
</body>
</html>
