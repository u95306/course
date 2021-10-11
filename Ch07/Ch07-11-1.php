<?php
header('content-type:text/html;charset=utf-8');
session_start();

//將網路的根目錄設定為 WORK_ROOT 常數
//程式會限制目錄切換或檔案操作均不得超出網路根目錄
define('WORK_ROOT',$_SERVER['DOCUMENT_ROOT']);

//若目前目錄未設定, 則設定為網站根目錄
if(! isset($_SESSION['cwd']) )
  $_SESSION['cwd']=WORK_ROOT;

//切換到目前目錄
chdir($_SESSION['cwd']);

//----------------------判斷使用者要執行的操作 ----------------------
if( !empty($_GET['op']) ){

  $id=$_GET['id'];
  
  switch($_GET['op']){
  
    //切換目錄
    case 'enter':
      if ($id=='root') {
        //切換到網站根目錄
        chdir(WORK_ROOT);
      }
      elseif ($id=='up'){
        //切換到上一層目錄
        chdir($_SESSION['cwd'].'/..');
      }
      else{
        //切換到 id 參數所指定的目錄
        chdir($_SESSION['cwd'].'/'.$_SESSION['dirs'][$id]);
      }

      //重新讀取目前目錄 (getcwd() 會回傳目前目錄)
      $_SESSION['cwd'] = str_replace('\\','/',getcwd());

      //如果目前目錄不在網站根目錄內, 便強迫回到網站根目錄
      if ( !ereg('^'.WORK_ROOT, $_SESSION['cwd']) ){
        chdir(WORK_ROOT);
        $_SESSION['cwd'] = str_replace('\\','/',getcwd());
      }
      break;

    //刪除檔案
    case 'del':
      //讀取要刪除的目錄或檔案名稱
      if ($_GET['type']=='d')
        $delFilename=$_SESSION['dirs'][$id];
      else
        $delFilename=$_SESSION['files'][$id];
        
      unlink($delFilename);
      //設定相關訊息
      $msg="刪除 $delFilename";
      break;

    //複製檔案
    case 'cpy':
      //使用迴圈產生檔案複製時, 檔名結尾的序號
      for ($i=1; $i<100; $i++){
        $cpyFilename=$_SESSION['files'][$id] . "-copy$i";
        //如果這個序號的檔案已經存在, 便使用下一個序號
        if ( file_exists($cpyFilename) ){
          continue;
        }
        else{
          copy($_SESSION['files'][$id], $cpyFilename);
          break;
        }
      }
      
      //設定相關訊息
      $msg=$_SESSION['files'][$id]. " 複製為 $cpyFilename";
      break;
  }
  
  //切換目錄, 或者檔案操作後, 目錄列表已經改變, 
  //所以刪除紀錄列表的 Session, 讓程式重新讀取
  unset($_SESSION['dirs']);
  unset($_SESSION['files']);
}

// showdir() 函式會顯示目前目錄的列表
function showdir(){

  //取得目前程式的檔案名稱
  $myUri=$_SERVER['PHP_SELF'];

  //取得目前目錄的網址
  $cwdUri=str_replace(WORK_ROOT,'',$_SESSION['cwd']);

  //設定檔案更名與上傳的程式檔名
  $renphp='Ch07-11-2.php';
  $uploadphp='Ch07-11-3.php';

  //如果 Session 中紀錄目錄列表的陣列是空的, 便重新讀取
  if( empty($_SESSION['dirs']) || empty($_SESSION['files']) ) {

    // 用陣列 $arrDirFile 儲存 scandir() 的傳回值
    $arrDirFile=scandir($_SESSION['cwd']);

    //將 . 與 .. 這兩個目錄名稱刪除
    unset($arrDirFile[0]); unset($arrDirFile[1]);

    //刪除 Session 陣列的內容
    unset($_SESSION['dirs']); unset($_SESSION['files']);

    //將 $arrDirFile 的內容依照目錄與檔案的類型分別記錄於不同陣列
    foreach($arrDirFile as $name){
      if ( is_dir($name) ){
        $_SESSION['dirs'][]=$name;
      }
      else {
        $_SESSION['files'][]=$name;
      }
    }

    unset($arrDirFile);
  }
  
  //-------------------- 輸出目錄列表的 HTML 碼 --------------------
  
  $html='<tr><td class="white_silver" colspan="2" rowspan="1">';

  if ( $_SESSION['cwd']!=WORK_ROOT ){
    $html .= <<< END_of_HTML
        <a href="$myUri?id=up&op=enter">到上層目錄</a>
        <a href="$myUri?id=root&op=enter">回網站根目錄</a>
END_of_HTML;
    }

  $html.=<<< END_of_HTML
    <a href="$uploadphp">上傳檔案</a>
    </td></tr>
END_of_HTML;

  //輸出子目錄列表
  if ( !empty($_SESSION['dirs']) ) {

    foreach($_SESSION['dirs'] as $key=>$dir){
      $html .= <<< END_of_HTML
        <tr>
          <td class="white_silver">
            <a href="$myUri?id=$key&op=enter">$dir</a>
          </td>
          <td class="white_silver">
            <a href="$renphp?type=d&id=$key">更名</a>
          </td>
        </tr>
END_of_HTML;
    }
  }

  //輸出檔案列表
  if ( !empty($_SESSION['files']) ) {
    foreach($_SESSION['files'] as $key=>$file){
      $html .= <<< END_of_HTML
        <tr>
          <td>
            <a href="$cwdUri/$file">$file</a>
          </td>
          <td>
            <a href="$myUri?type=f&id=$key&op=del">刪除</a>
            <a href="$myUri?type=f&id=$key&op=cpy">複製</a>
            <a href="$renphp?type=f&id=$key">更名</a>
          </td>
        </tr>
END_of_HTML;
    }
  }
  
  return $html;
}
?>
<html>
<head>
<title>網站伺服器檔案總管</title>
  <style type=text/css>
    *.white_silver{color:white;background:Silver;}
    *.white_header{color:white;background:Silver;font-size=36px;}
  </style>
</head>
<body>
  <p style=text-align:center;>
    <?php
      //顯示相關訊息
      echo $msg;
    ?>
  </p>
  <p style=text-align:center;>
    <table border="3" cellspacing="3" cellpadding="3">
      <tr><td class="white_header" colspan="2" rowspan="1">
          目前目錄：<?php echo $_SESSION['cwd'];?>
          </td>
      </tr>
      <?php
        //顯示目前的目錄列表
        echo showdir();
      ?>
    </table>
  </p>
</body>
</html>
