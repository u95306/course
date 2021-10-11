<html>
<head>
  <meta http-equiv="content-type" 
        content="text/html; charset=UTF-8">
  <title>PEAR::Pager分頁示範</title>
  <style>
    table{border:2px blue solid;
          border-collapse:collapse; width:360px}
    th,td{border:1px blue solid}
  </style>
</head>
<body>
  <?php
  require_once('MDB2.php');   // 引用 MDB2 類别
  require_once('Pager.php');  // 引用 Pager 類别
  $dsn = "mysql://root:123@localhost/Ch09?charset=utf8";  // DSN
  $query_str = 'SELECT `書籍名稱`,`價格` from books';     // 查詢字串

  $mdb2 =& MDB2::connect($dsn);     // 建立連線
  if (PEAR::isError($mdb2))    
    die("連線資料庫錯誤：".$mdb2->getMessage());

  $res =& $mdb2->query($query_str); // 執行查詢
  if (PEAR::isError($res)) 
    die("查詢發生錯誤：".$res->getMessage());

  $mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);  // 以欄位名稱為索引
  $rows = $res->fetchAll();                   // 取得所有資料
  if (PEAR::isError($rows)) 
    die("存取資料失敗：".$rows->getMessage());
  ?>
<table>
<tr><th>書籍名稱</th><th width="60">價格</th></tr>
  <?php
  $params = array(     // 分頁參數
      'mode'       => 'Jumping',      // 使用 Jumping 模式 
      'perPage'    => 4,              // 每頁四筆
      'itemData'   => $rows,          // 要分頁的資料存於 $rows 中
      'delta'      => 3);             // 每次列出 3 頁的連結
  $pager = & Pager::factory($params); // 建立分頁物件
  
  $links = $pager->getLinks();        // 取得連結陣列
  
  // 用 $_GET[pageID] 為參數呼叫 getPageData() 方法取得目前頁面資料
  // 第一次進入網頁時 $_GET[pageID] 沒有值, 所以會傳回第 1 頁的資料
  $data  = $pager->getPageData($_GET[pageID]); 
  
  // 用迴圈逐筆輸出本頁資料
  foreach($data as $row)                  // 每一筆資料都放在 <tr> 中
    echo '<tr><td>' . $row['書籍名稱'] .  // 每一欄則放在 <td> 中
         '</td><td>' . $row['價格']. '</td></tr>';
  ?>
<caption align="center">
<?php echo $links['all'];   // 輸出分頁連結 ?> 
</caption>
</table>
</body>
</html>
