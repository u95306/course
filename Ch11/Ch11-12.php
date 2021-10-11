<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>用衍生類別MyMailer寄送電子郵件</title>
  <style>
    body{background=url(2hearts.jpg)}
    div{color:navy;width:750px;border:2 dashed}
  </style>
</head>
<body><br /> 
  <?php
  require('MyMailer.php');   // 引入自訂類別

  // 檢查收件人及主旨均非空字串, 才會進行以下處理
  if(!empty($_POST['to']) && !empty($_POST['subject'])) {
  $mail = new MyMailer;    // 建立自訂類別物件
  $mail->setMail($_POST['to'],$_POST['subject'],$_POST['body']);

  // 呼叫 Send(), 並依傳回值判斷成功或失敗
  // 以決定應輸出的訊息
  if(!$mail->Send())
    echo '<p>寄送失敗：' . $mail->ErrorInfo;
  else {
    echo '<p>郵件已成功寄出！<br />';
    echo '<a href="' . $_SERVER['PHP_SELF'] . '">再寄一封</a>';
  }
  echo '</p></body></html>';
  exit();                          // 結束程式, 不輸出下列表單
  } // 收件人或主旨為 NULL 或空字串時, 才會顯示以下的表單內容
  ?>
<form method="post">
  <div>收件人:<input type="text" name="to" size="50"/>
  (可用分號分隔多個信箱)</div><br />
  <div>主　旨:<input type="text" name="subject" size="50"/></div><br />
  <div>信件內容:<br />
    <textarea rows="10" cols="72" name="body"></textarea>
  </div>
  <input type="submit" value="立即寄出"/>
  <input type="reset" value="清除重寫"/>
</form>   
</body>
</html>
