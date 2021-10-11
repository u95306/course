<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>PEAR::MDB2套件fetchXXX()方法示範</title>
</head>
<body>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  方法:<select name="method"/>
    <option value="1">fetchRow()</option>
    <option value="2">fetchOne()</option>
    <option value="3">fetchAll()</option>
    <option value="4">fetchCol()</option>
  </select>
  <input type="checkbox" name="assoc" />結果陣列以欄位名稱為索引<br />
  fetchOne()或fetchCol()的參數：<input type="text" name="col"/><br />  
  <input type="submit" value="執行查詢"/>
  </form>
<hr />
  執行結果：
  <pre style="color:blue">
    <?php
    require_once('MDB2.php'); // 引入類別檔
    $dsn = 'mysql://root:123@localhost/Ch09?charset=utf8';  // 設定 DSN
    $query_str = 'SELECT * FROM books';          // 稍後要用的查詢敘述

    $mdb2 =& MDB2::connect($dsn);     // 建立連線
    if (PEAR::isError($mdb2))    
      die('連線資料庫錯誤：' . $mdb2->getMessage());
    
    $res =& $mdb2->query($query_str); // 執行查詢
    if (PEAR::isError($res)) 
      die('查詢發生錯誤：' . $res->getMessage());
    
    // 若 assoc 多選欄被勾選
    // 就將 fetchXXX() 傳回的結果陣列以以欄位名稱為索引
    if($_POST['assoc']=='on')
      $mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
    
    // 依 $_POST['method'] 的值決定要執行的動作
    switch($_POST['method']) { 
      case 1: // 使用 fetchRow() 
        // 利用迴圈逐筆取得查詢結果中的記錄
        while ($row = & $res->fetchRow()) {
          if(PEAR::isError($row))
            die('存取資料失敗：' . $row->getMessage());
          print_r($row);
        }
        break; 
      case 2: // 使用 fetchOne() 
              // 取得單筆記錄中的指定欄位
        $row = $res->fetchOne($_POST['col']);
        if(PEAR::isError($row))
          die('存取資料失敗：' . $row->getMessage());
        print_r($row);
        break;
      case 3: // 使用 fetchAll() 
              // 一次取得所有資料 (二維陣列)
        $row = $res->fetchAll();
        if(PEAR::isError($row))
          die('存取資料失敗：' . $row->getMessage());
        print_r($row);
        break;
      case 4: // 使用 fetchCol()
              // 取得每筆資料中的單一欄位
        $row = $res->fetchCol($_POST['col']);
        if(PEAR::isError($row))
          die('存取資料失敗：' . $row->getMessage());
        print_r($row);
        break;
    }
    ?>
  </pre>
</body>
</html>
