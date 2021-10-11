<?php
header('content-type:text/html;charset=utf-8');

//---------------------- 常數的定義 ---------------------------------
define(WWW_ROOT,$_SERVER[DOCUMENT_ROOT]);
// 定義上傳目錄
define(MY_UPLOAD_DIR,WWW_ROOT.'/Ch07/upload/');
// 定義文件描述檔案的儲存目錄
define(MEANING_DIR,MY_UPLOAD_DIR.'meaning/');
// 建立上傳目錄
my_mkdir(MY_UPLOAD_DIR);
// 建立文件描述檔專用目錄
my_mkdir(MEANING_DIR);


//---------------------- 以下開始處理上傳檔案 ---------------------
if($length=count($_FILES[upFile][name])){

  // 利用 for 迴圈儲存上傳檔案與相關資料
  for($k=0; $k<$length; $k=$k+1){
    $_FILES[upFile][name][$k]=trim($_FILES[upFile][name][$k]);

    // 檔案名稱不是空字串才要處理
    if($_FILES[upFile][name][$k]){
      $error=$_FILES[upFile][error][$k]; // 取得上傳檔案錯誤代碼

      if($error==UPLOAD_ERR_OK){         // 傳送成功, 處理檔案
        // 取得檔案流水號
        $sn=my_sn();
        // 製作上傳目錄中的檔案名稱
        $dfname=MY_UPLOAD_DIR.$sn.$_FILES[upFile][name][$k];
        $sfname=$_FILES[upFile][tmp_name][$k];
        // 製作上傳檔案的文件內容描述檔案名稱
        $meaningFile=MEANING_DIR.$sn.
                     $_FILES[upFile][name][$k].'.txt';
        if(move_uploaded_file($sfname,$dfname)){  // 若複製成功

          if($_POST[upText][$k]) // 若有文件內容描述, 就存入檔案
            file_put_contents($meaningFile,
                              $_POST[upText][$k]);
          else
            file_put_contents($meaningFile,'上傳者未提供！');

          // 製作上傳紀錄
          $str='在伺服器的檔案名稱：'.basename($dfname).'<br/>';
          $str.='檔案類型：'
               ." {$_FILES[upFile][type][$k]}<br/>";
          $str.='檔案大小：'
               ." {$_FILES[upFile][size][$k]}<br/>";
          if(file_exists($meaningFile)){
            $meaning=file_get_contents($meaningFile);
            $str.='檔案的內容描述： '.$meaning.'<br/>';
          }
          $link=dirname($_SERVER[HTTP_REFERER]).'/'
               .basename(MY_UPLOAD_DIR).'/'
               .basename($dfname);
          $str.='請利用以下連結下載檔案：<br/>'
            ."<a href=\"$link\"".' target="_blank">'."$link</a>";
        }
        else{     // 複製失敗
          $str='無法複製 '.$_FILES[upFile][name][$k]
              .' 檔案到上傳目錄下';
        }
      }
      else{
        $str="檔案上傳失敗...";
      }
      // 將一筆上傳記錄轉變成網頁的表格的一筆記錄
      $record[]='<tr><td>'.$_FILES[upFile][name][$k].'</td>'
               .'<td>'.$str.'</td></tr>';
    }
  }
  $upResult=implode('',$record);
}


//---------------------- 設定為第 n 次(非第 1 次) ----------------
function setN($fn){
  $fh=fopen($fn,'r+');
  do{
    // 嘗試鎖定檔案
    if(flock($fh,LOCK_EX|LOCK_NB)){
      // 鎖定成功, 存取計數器內容
      $Counter=fgets($fh); // 讀取內容後, 檔案指位器已到檔尾
      $Counter=$Counter + 1;
      rewind($fh);         // 檔案指位器回到檔頭
      ftruncate($fh,0);    // 檔案內容清空
      fputs($fh,$Counter); // 寫入計數器內容
      // 解除鎖定
      flock($fh,LOCK_UN);
      // 設定完成, 跳出迴圈
      break;
    }
    else{
      // 鎖定失敗的作業處理
      usleep(1000); // 千分之一秒後再嘗試鎖定檔案
    }
  }while(true);
  fclose($fh);
}


//---------------------- 嘗試設定為第 1 次 ----------------------
function setFirst($fn){
  // 開啟檔案
  $fh=fopen($fn,'w');
  // 嘗試鎖定檔案
  if(flock($fh,LOCK_EX|LOCK_NB)){
    // 鎖定成功, 設定為第 1 次
    fputs($fh,'1');
    // 解除鎖定
    flock($fh,LOCK_UN);
    // 關閉檔案
    fclose($fh);
  }
  else{
    // 鎖定失敗, 設定為非第 1 次
    setN($fn);
  }
}


//---------------------- 流水號程式 ----------------------
function my_sn(){
  $fn='Counter.txt';

  if(file_exists($fn)){
    setN($fn);
  }
  else{
    setFirst($fn);
  }
  
  // 傳回計數器內容
  return file_get_contents($fn);
}


//----------------------  建立目錄 ----------------------
function my_mkdir($dir=''){
  if(empty($dir)){
    echo '請設定目錄...';
  }
  else{
    if(!file_exists($dir)){
      mkdir($dir);
    }
  }
  return;
}
?>
<html>
<head>
<title>檔案分享目錄</title>
  <style type=text/css>
    @import Ch07-12.css;
  </style>
</head>
<body>
  <p class="center_text">
  <form action="<?php echo $_SERVER[PHP_SELF]?>" method="post">
    <table border="3" cellspacing="3" cellpadding="3">
      <tr class="white_purple">
        <td colspan="3">檔案上傳結果</td>
      </tr>
      <tr class="white_blue">
        <td class="center_text">上傳檔案名稱</td>
        <td class="center_text" colspan="2">上傳結果摘要</td>
      </tr>
      <?php echo $upResult;?>
    </table>
  </form>
  </p>
</body>
</html>
