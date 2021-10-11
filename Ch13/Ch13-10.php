<?php
header('Content-type:text/html;charset=UTF-8');
require_once('Ch13db.inc.php');

// 新增標籤至 tag 資料表的函式
function insert_tag($bid, $tags, &$mdb2) { 
  $alltag = explode(' ', $tags); // 分解輸入的標籤字串
  $alltag = array_unique($alltag);          // 去除可能重複輸入的標籤 
  
  foreach($alltag as $tagname) {           // 將每個標籤新增至資料表
    $exec = sprintf('INSERT INTO tag (bid,name) VALUES (%d, %s)',
            $mdb2->quote($bid, 'integer'), 
            $mdb2->quote($tagname,'text'));
    $res = $mdb2->exec($exec);
    
    if (PEAR::isError($res))  // 執行失敗傳回 false 
      return false;
  }

  return true;
}
?>
<html>
<head><title>書籤編修結果</title></head>
<body style="background:url('2hearts.jpg')">
<p>
<?php
if (empty($_POST['tags']) ||  // 若必要的標籤, 書籤名稱, 書籤網址 
    empty($_POST['title']) || // 都沒有資料, 就不進行處理 
    empty($_POST['url'])) {
  echo '資料不完整, <a href="javascript:history.back()">回前頁</a>'; 
}
else {
  if(get_magic_quotes_gpc()) { // 去除 PHP 可能加上的反斜線
    $_POST['tag']         = stripslashes($_POST['tag']);
    $_POST['title']       = stripslashes($_POST['title']);
    $_POST['url']         = stripslashes($_POST['url']);
    $_POST['description'] = stripslashes($_POST['description']);
  }
  
  $res = $mdb2->beginTransaction(); // 開始新交易
  if (PEAR::isError($res)) 
    die('無法開始交易：' . $res->getMessage());
  
  if(!empty($_POST['bid'])) { // 表單有送來 bid 表示是編輯模式
    $update = sprintf('UPDATE bookmark SET url=%s, title= %s, 
                       description=%s, last=now() WHERE bid =%d',
            $mdb2->quote($_POST['url'], 'text'),
            $mdb2->quote($_POST['title'], 'text'),
            $mdb2->quote($_POST['description'], 'text'),
            $mdb2->quote($_POST['bid'], 'integer')); 
    $res = $mdb2->exec($update);         // 先更新 bookmark 資料表
    if (PEAR::isError($res)) {
      $mdb2->rollback();                 // 復原先前的操作
      die('無法更新書籤資料, 交易失敗：' . $res->getMessage());
    }
    
    // 更新標籤前, 先將舊標籤全部刪除, 再新增全部新標籤
    $delete = 'DELETE FROM tag WHERE bid=' . 
              $mdb2->quote($_POST['bid'], 'integer');
    $res = $mdb2->exec($delete);   
    if (PEAR::isError($res)) {
      $mdb2->rollback();                  // 復原先前的操作
      die('無法刪除舊標籤, 交易失敗：' . $res->getMessage());
    }
    
    // 呼叫自訂函式將標籤寫入資料庫
    if(!insert_tag($_POST['bid'],
                   trim($_POST['tags']),  // 去除標籤字串前後空白
                   $mdb2)) {
      $mdb2->rollback();    // 復原先前的操作
      die('無法新增標籤, 交易失敗：' . $res->getMessage());
    } 
    
    $mdb2->commit();        // 完成交易
    echo '書籤《'. htmlspecialchars($_POST['title']) .'》的資料已更新';
  }
  else {  // 無 bid 則為新增模式
    $insert = sprintf('INSERT INTO bookmark (url,title,description) VALUES (%s, %s, %s)', 
            $mdb2->quote($_POST['url'],'text'),
            $mdb2->quote($_POST['title'],'text'),
            $mdb2->quote($_POST['description'],'text'));
    $res = $mdb2->exec($insert);  // 先新增至 Bookmark 資料表
    if (PEAR::isError($res)) {
      $mdb2->rollback();    // 復原先前的操作
      die('無法新增書籤, 交易失敗：' . $res->getMessage());
    }  
    
    // 呼叫自訂函式將標籤寫入資料庫
    if(!insert_tag($mdb2->lastInsertID(), // 取得新書籤的 bid
                   trim($_POST['tags']),  // 去除標籤字串前後空白
                   $mdb2)) {
      $mdb2->rollback();        // 復原先前的操作
      die('無法新增標籤, 交易失敗：' . $res->getMessage());
    } 
    $mdb2->commit();        // 完成交易  
    echo '已新增書籤《'. htmlspecialchars($_POST['title']) .'》';
  }
}  
?>
</p>
<p><a href="Ch13-08.php">回書籤首頁</a></p>
</body>
</html>
