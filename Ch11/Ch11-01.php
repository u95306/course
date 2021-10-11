<?php 
class SimplePage {
  // 儲存網頁標題的成員
  var $title;

  // 顯示網頁的方法
  function show()   {
    echo <<<PageContent
               <html>
               <head>
               <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
               <title>$this->title</title>
               </head>
               <body><p>
               This is a Page Object.
               </p></body>
               </html>
PageContent;
  }
}

$pobj = new SimplePage;
$pobj->title ="測試類別與物件"; 
$pobj->show();
?>
