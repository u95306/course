<?php
header('content-type:text/html;charset=utf-8');
session_start();

//切換到目前目錄
chdir($_SESSION['cwd']);

//取得 GET 傳遞過來的各項參數
$id=$_GET['id'];
$type=$_GET['type'];
$newname=$_GET['newname'];

//使用 id 取得原始的目錄或檔案名稱
if ( $type == 'd' )
  $oldname=$_SESSION['dirs'][$id];
else
  $oldname=$_SESSION['files'][$id];

//執行更改名稱的操作
if ( !empty($newname) && !empty($oldname) ){

  //檢查使用者輸入的名稱中是否包含目錄符號 \ 或 /
  if ( ereg('[\/]',$newname) )
    die("名稱中不允許 \ 或 / 符號");

  rename($oldname, $newname);

  //更名後為了讓程式重新讀取目錄列表
  //故刪除 Session 中的列表紀錄
  unset($_SESSION['files']);
  unset($_SESSION['dirs']);
  
  //轉向回目錄列表
  header("Location: Ch07-11-1.php");
}
?>
<html>
<head>
  <meta http-equiv="Content-Type"
        content="text/html;charset=utf-8"/>
</head>
<body>
  <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">

    將 <?php echo $oldname;?> 改名為 :
    <input type="text" name="newname" />
    
    <input type="hidden" name="id" value="<?php echo $id;?>">
    <input type="hidden" name="type" value="<?php echo $_GET['type'];?>">

    <input type="submit" value="確認" />
  </form>
</body>
</html>
