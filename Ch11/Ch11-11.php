<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>用PHPMailer寄送電子郵件</title>
  <style>
    body{background=url(2hearts.jpg)}
    div{color:navy;width:750px;border:2 dashed}
  </style>
</head>
<body><br />
  <?php
  require("class.phpmailer.php");

  // 檢查收件人及主旨均非空字串, 才會進行以下處理
  if(!empty($_POST['to']) && !empty($_POST['subject'])) {
    $mail = new PHPMailer;           // 引入類別檔

    // 所使用的郵件伺服器設定
    $mail->IsSmtp();                 // 使用 SMTP 伺服器寄信
    $mail->Host     = "192.168.0.5"; // SMTP伺服器網址
    $mail->SMTPAuth = true;          // SMTP伺服器是否要求驗證
    $mail->Username = "foo";         // SMTP 帳號
    $mail->Password = "123456";      // SMTP 密碼

    // 寄件人與發送格式設定
    $mail->From     = 'service@flag.com.tw';
    $mail->FromName = '旗標出版股份有限公司';
    $mail->WordWrap = 72;            // 超過 72 個字元就換行
    $mail->CharSet  = 'utf-8';       // 使用 UTF-8 編碼
    $mail->Subject  =  $_POST['subject']; // 使用者輸入的主旨
    $mail->Body     =  $_POST['body'];    // 使用者輸入的信件內容

    // 將收件人欄位依分號 ';' 分割後存成陣列
    // 再用 foreach 迴圈將收件人逐一加入清單
    $maillist = explode(';',$_POST['to']);
    foreach ($maillist as $recipient)
      $mail->AddAddress($recipient);

    // 呼叫 Send(), 並依傳回值判斷成功或失敗
    // 以決定應顯示的訊息
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
<form method="post" actioon="<?php echo $_SERVER['PHP_SELF']; ?>">
  <div>收件人:<input type="text" name="to" size="50"/>
  (可用分號分隔多個信箱)</div><br />
  <div>主　旨:<input type="text" name="subject" size="50"/></div>
  <br />
  <div>信件內容:<br />
    <textarea rows="10" cols="72" name="body"></textarea>
  </div>
  <input type="submit" value="立即寄出"/>
  <input type="reset" value="清除重寫"/>
</form>
</body>
</html>
