<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>使用Mail_MIME傳送HTML格式郵件</title>
  <style>
    body{background=url(little_bear.jpg)}
    div{color:navy;width:750px;border:2 dashed}
  </style>
</head>
<body>
<?php
  require_once('Mail.php');   // 引用 PEAR::Mail
  require_once('MyMime.php'); // 引用自定的 MyMime 類別

  // 檢查收件人及主旨均非空字串, 才會進行以下處理
  if(!empty($_POST['to']) && !empty($_POST['subject'])) {
    $recipients = trim($_POST['to']);      // 去除換行 
    $subject    = trim($_POST['subject']); // 去除換行
    $background = '2hearts.jpg';           // 設定背景圖檔
    
  // 使用 heredoc 語法建立 HTML 郵件本體字串
  // 其中會加入使用者輸入的郵件主旨、內容、及程式設定的背景圖檔
  $html = <<<HTMLBODY
    <html>
    <head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>{$_POST['subject']}</title>
        <style>body{background=url($background)}</style>
      </head>
      <body>
        {$_POST['body']}
        <hr>
        Send by <a href="http://pear.php.net/package/Mail">Pear::Mail</a>
      </body>
      </html>
HTMLBODY;

    $mime = new MyMime("\n");   // 建立 MyMime 物件  
    $mime->setHTMLBody(stripslashes($html)); // 去除反斜線再加入本體
    $mime->addHTMLImage($background, 'image/jpeg'); // 加入圖片

    $mimeParams = array ('head_encoding' => 'base64', // 設定 MIME
                         'text_encoding' => '8bit',   // 編碼相關參數
                         'head_charset'=> 'UTF-8', 
                         'text_charset'=> 'UTF-8', 
                         'html_charset'=> 'UTF-8');
    $headers = array(                             // 設定檔頭資訊
      'From'          => '旗標出版股份有限公司 <service@flag.com.tw>',
      'To'            => $recipients,
      'Subject'       => $subject);
    $body = $mime->get($mimeParams);  // 取得 MIME 郵件內容
    $hdrs = $mime->headers($headers); // 取得 MIME 郵件表頭

    // 以下開始建立 Mail 物件並寄出郵件 
    $mailParams = array('host' => '192.168.0.5',
                        'auth' => true,
                        'username' => 'foo',       // SMTP 帳號
                        'password' => '123456');   // SMTP 密碼
    $mailer = &Mail::factory('smtp',$mailParams);  // 建立物件
    $result = $mailer->send($recipients, $hdrs, $body);
    if(PEAR::isError($result)) 
      echo '<p>寄送失敗：' . $result->getMessage() . '</p>';
    else
      echo '<p>郵件已成功寄出！</p>';
    
    echo '</body></html>';
    exit();   // 結束程式
  }
?>
<form method="post">
  <div>收件人:<input type="text" name="to" size="50"/></div><br />
  <div>主旨:<input type="text" name="subject" size="50"/></div><br />
  <div>信件內容:(可輸入HTML標籤，郵件將以HTML格式寄出)<br />
    <textarea rows="10" cols="72" name="body"></textarea>
  </div>
  <input type="submit" value="立即寄出"/>
  <input type="reset" value="清除重寫"/>
</form>   
</body>
</html>
