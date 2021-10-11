<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>使用PEAR::Mail發送電子郵件</title>
  <style>
    body{background=url(little_bear.jpg)}
    div{color:navy; width:750px; border:2 dashed}
  </style>
</head>
<body>
<?php
  require_once("Mail.php");   // 引用 PEAR::Mail

  // 檢查收件人及主旨均非空字串, 才會進行以下處理
  if(!empty($_POST['to']) && !empty($_POST['subject'])){  
    $params = array('host' => '192.168.0.5',
                    'auth' => true,
                    'username' => 'foo',       // SMTP 帳號
                    'password' => '123456');   // SMTP 密碼
    $mailer = &Mail::factory('smtp',$params);  // 建立使用SMTP的物件                            
  
    mb_internal_encoding('utf-8');    // 指定編碼格式
    $headers = array( // 設定檔頭資訊
      // 用 mb_encode_mimeheader() 將寄件人中的字串 
      // 轉成符合 SMTP 通訊協定要求的格式
      'From'         => mb_encode_mimeheader('旗標出版股份有限公司') . 
                         ' <service@flag.com.tw>',
      'To'           => $_POST['to'],
      // 用 mb_encode_mimeheader() 將郵件標題 
      // 轉成符合 SMTP 通訊協定要求的格式
      'Subject'      => mb_encode_mimeheader($_POST['subject']),  
      'Content-Type' => 'text/plain; charset="UTF-8"',
      'Content-Transfer-Encoding' => '8bit');
  
    // 呼叫 send() 方法寄出郵件, 並取得其傳回值
    $result=$mailer->send($recipients, $headers, $_POST['body']);
  
    // 由 send() 傳回值判斷結果並顯示對應訊息
    // 如果寄件失敗, $result 將會是 PEAR_:Error 的物件 
    // 如果寄件成功, 則傳回值為 true
    if(PEAR::isError($result)) 
      // 呼叫 PEAR_Error 的 getMessage() 方法取得錯誤訊息字串
      echo '<p>寄送失敗：' . $result->getMessage() . '</p>';
    else 
      echo '<p>郵件已成功寄出！</p>';

    echo '</body></html>';
    exit();
  }
?>
<form method="post">
  <div>收件人:<input type="text" name="to" size="50"/></div>
  <br />
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
