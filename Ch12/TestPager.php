<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>PEAR::Pager分頁示範</title>
  <style>
    table{border:2px blue solid;border-collapse:collapse;width="360"}
    th,td{border:1px blue solid}
  </style>
</head>
<body>
<?php
  require_once('MDB2.php');
  require_once('Pager.php');
  $dsn = "mysql://root:123@localhost/Ch09?charset=utf8";
  $query_str = 'SELECT 書籍名稱,價格 from books';

  $mdb2 =& MDB2::connect($dsn);     // 建立連線
  if (PEAR::isError($mdb2))    
    die("連線資料庫錯誤：".$mdb2->getMessage());

  $res =& $mdb2->query($query_str); // 執行查詢
  if (PEAR::isError($res)) 
    die("查詢發生錯誤：".$res->getMessage());

  $rows = $res->fetchAll();
  if (PEAR::isError($rows)) 
    die("存取資料失敗：".$rows->getMessage());
?>
<table>
<tr><th>書籍名稱</th><th width="60">價格</th></tr>
<?php
  $params = array(     // 分頁參數
      'mode'       => 'Jumping',
      'perPage'    => 1,
      'itemData'   => $rows,
      'delta'      => 12);
  $pager = & Pager::factory($params);          // 建立分頁
  $links = $pager->getLinks();                 // 取得分頁連結
  $data  = $pager->getPageData($_GET[pageID]); // 取得目前頁面資料

  foreach($data as $row)    // 用迴圈顯示本頁的每一筆資料
    echo "<tr><td>" . $row[0] ."</td><td>". $row[1]. "</td></tr>";
?>
<caption align="center">
  <?php  
    echo $links['all']; // 顯示分頁連結
  ?>
</caption>
</table>
<pre>
<?php print_r($links); ?>
</pre>
</body></html>
