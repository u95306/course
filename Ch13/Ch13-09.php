<?php
header('Content-type:text/html;charset=UTF-8');
require_once('Ch13db.inc.php');   // 引用資料庫檔 
require_once('Ch13Smarty.php');   // 引用自訂類別
$smarty = new Ch13Smarty();

// GET 參數中有 bid 及網址, 表示使用者點選書籤的連結 
if(!empty($_GET['bid']) && !empty($_GET['url'])) {  
  $sql = 'SELECT click FROM bookmark WHERE bid =' . // 查詢該書籤的 
          $mdb2->quote($_GET['bid'],'integer');     // 點選次數
  $res =& $mdb2->query($sql); // 執行查詢
  if (PEAR::isError($res)) 
    die('查詢發生錯誤：' . $res->getMessage());
    
  $count = $res->fetchOne();  // 取得點選次數
  if (PEAR::isError($row)) 
    die('存取資料失敗：' . $rows->getMessage());  
    
  $exec = sprintf('UPDATE bookmark SET click=%d WHERE bid =%d',
                  $count+1 ,  // 將點選次數加 1 寫回資料庫
                  $mdb2->quote($_GET['bid'],'integer'));
  $res = $mdb2->exec($exec);  
  if (PEAR::isError($res)) 
    die('更新資料庫失敗：' . $res->getMessage());
  
  header('Location:' . $_GET['url']); // 轉到書籤的網址
  exit();                             // 結束程式
}
// GET 參數中有 bid 但無網址, 表示使用者要編輯書籤
elseif(!empty($_GET['bid'])) { // 修改
  $sql = 'SELECT * FROM bookmark WHERE bid =' .     // 查詢書籤所有欄位
         $mdb2->quote($_GET['bid'],'integer');
  $res =& $mdb2->query($sql); // 執行查詢
  if (PEAR::isError($res)) 
    die('查詢發生錯誤：' . $res->getMessage());
  
  if ($res->numRows()==0) { // 若找不到書籤, 表示參數有誤
    $row['descrption'] = '無此書籤,進新增模式';   // 建立示誤訊息
    $smarty->assign('bookmark',$row);             // 在表單中顯示訊息
  }
  else {                    // 若有找到書籤資料
    $row = $res->fetchRow();
    if (PEAR::isError($row)) 
      die('存取資料失敗：' . $rows->getMessage());
    $smarty->assign('bookmark',$row); // 將書籤資料設定給樣版 
    $smarty->assign('edit', true);    // 設定目前為編輯模式
  
    // 到 tag 資料表查詢編輯中書籤的所有標籤
    $sqlTag = 'SELECT name from tag WHERE bid =' . 
               $mdb2->quote($_GET['bid'],'integer');
    $res =& $mdb2->query($sqlTag); // 執行查詢
    if (PEAR::isError($res)) 
      die('查詢發生錯誤：' . $res->getMessage());
  
    while ($row = $res->fetchRow())   // 將標籤以空白分隔
      $alltag .= $row['name'] . ' ';  // 組成單一字串
  
    $smarty->assign('tags', $alltag); // 設定要顯示頁面資料
  }
}

$smarty->display('Ch13-09.tpl');
?>
