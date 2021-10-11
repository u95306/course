<?php
header('Content-type:text/html;charset=UTF-8');
require_once('Ch13db.inc.php');   // 引用資料庫檔
require_once('Pager.php');        // 引用 Pager 類別
require_once('Ch13Smarty.php');   // 引用自訂類別

// 查點閱前 5 名的書籤
$queryTop5 = 'SELECT bid,url,title FROM bookmark ' .
             'ORDER BY click DESC LIMIT 0,5';    
$res =& $mdb2->query($queryTop5); // 執行查詢
if (PEAR::isError($res)) 
  die('查詢發生錯誤：' . $res->getMessage());
  
$top5 = $res->fetchAll();         // 取得前 5 名書籤的資料
if (PEAR::isError($top5)) 
  die('存取資料失敗：' . $top5->getMessage());

// 依 GET 參數, 設定查詢書籤的查詢敘述
if(isset($_GET['tag'])) {    // 若有設定標籤, 則查含指定標籤的書籤
  if(get_magic_quotes_gpc()) 
    $_GET['tag'] = stripslashes($_GET['tag']);

  $query = 'SELECT * FROM bookmark WHERE bookmark.bid IN' . 
           ' (SELECT bid FROM tag WHERE name=' .    // 使用子查詢 
           $mdb2->quote($_GET['tag'], 'text') . 
           ') ORDER BY click DESC';
  $msg= htmlspecialchars($_GET['tag']) . ' 類的書籤';  
} 
elseif($_GET['top']==true) {  // 查點閱次數前 100 名的書籤
  $query = 'SELECT * FROM bookmark ORDER BY click DESC LIMIT 0,100';
  $msg= '最熱門的100個書籤';
} 
else {
  $query = 'SELECT * FROM bookmark';
  $msg= '全部書籤';
}

$res =& $mdb2->query($query); // 執行查詢
if (PEAR::isError($res)) 
  die('查詢發生錯誤：' . $res->getMessage());

$rows = $res->fetchAll();
if (PEAR::isError($rows)) 
  die('存取資料失敗：' . $rows->getMessage());

$params = array(                             // 分頁參數
    'mode'       => 'Jumping',
    'perPage'    => 10,
    'itemData'   => $rows);
$pager = & Pager::factory($params);          // 建立分頁
$links = $pager->getLinks();                 // 取得分頁連結標籤字串
$data  = $pager->getPageData($_GET[pageID]); // 取得目前頁面資料

// 為目前分頁中的書籤加上 tag 資料
foreach($data as & $bookmark) {
  $tagQuery = 'SELECT name FROM tag WHERE bid=' . $bookmark['bid'];
  $tagRes =& $mdb2->query($tagQuery); // 執行查詢
  if (PEAR::isError($tagRes)) 
    die('查詢發生錯誤：' . $tagRes->getMessage());
  
  // 將標籤陣列附於書籤資料後
  $bookmark['tags'] = $tagRes->fetchCol('name');
  if (PEAR::isError($bookmark['tags'])) 
    die('存取資料失敗：' . $rows->getMessage());      
}

$smarty = new Ch13Smarty();
$smarty->assign('msg',$msg);   // 設定目前瀏覽項目的訊息
$smarty->assign('top5',$top5);   // 設定前5名的資料
$smarty->assign('data',$data);   // 設定目前頁面資料
$smarty->assign('link',$links['all']);  // 設定分頁連結標籤字串
$smarty->display('Ch13-08.tpl');
?>
