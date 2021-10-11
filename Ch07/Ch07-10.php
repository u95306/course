<?php
header("content-type:text/html; charset=utf-8");

//定義存放上傳檔案的目錄
$upload_dir='./upload/';

//使用 foreach 迴圈逐筆讀取 $_FILES['UpFile']['error'][0]、
//$_FILES['UpFile']['error'][1]、$_FILES['UpFile']['error'][2] 內的值,
//將索引儲存在 $key 變數, 錯誤代碼儲存在 $error 變數
foreach($_FILES['UpFile']['error'] as $key => $error) {

  //如果上傳成功
  if ($error == UPLOAD_ERR_OK) {

    //將暫存檔搬移到上傳目錄下, 並且改回原始檔名
    move_uploaded_file($_FILES["UpFile"]["tmp_name"][$key],
                       $upload_dir . $_FILES['UpFile']['name'][$key]);
    
    echo $_FILES['UpFile']['name'][$key] . '上傳成功<br />';
  }
  
  //UPLOAD_ERR_NO_FILE 表示沒有上傳檔案, 如果不是這個狀況
  //也不是上傳成功, 便是上傳失敗了
  elseif ( $error != UPLOAD_ERR_NO_FILE) {
    echo $_FILES['UpFile']['name'][$key] . '上傳失敗<br />';
  }
}
?>
