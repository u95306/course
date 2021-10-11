<html>
<head>
<title>上傳檔案</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style type=text/css>
    @import Ch07-12.css;
  </style>
</head>
<body>
<p class="center_text">
<table class="center_text">
  <form action="Ch07-12-2.php" method="post"
        enctype="multipart/form-data">
    <tr class="white_purple">
      <td>實戰演練：檔案分享網站</td>
    </tr>
    <?php
      // 使用者可以輸入幾個檔案由變數 $i 決定
      for($i=0;$i<=2;$i++){
        $upload.='<tr>';
        $upload.='<td class="top_line">要上傳的文件：';
        
        //用 upFile[$i] 記錄上傳檔案名稱
        $upload.="<input name=upFile[$i] type='file'></td></tr>";
        $upload.='<tr class="white_lblue"><td class="bottom_line">
                 請輸入文件描述：';

        //用 upText[$i] 記錄該檔的文件描述內容
        $upload.="<input name=upText[$i] type=text'>";
        $upload.='</td></tr>';
      }
      echo $upload;
    ?>
    <tr class="white_purple">
      <td><input type="reset" value="重新設定">
      <input type="submit" value="上傳檔案"></td>
    </tr>
  </form>
</table>
</p>
</body>
</html>
