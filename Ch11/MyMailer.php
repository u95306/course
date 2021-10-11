<?php
  require("class.phpmailer.php");

  class MyMailer extends PHPMailer {

    function __construct() {      // 在建構方法設好郵件伺服器
      $this->IsSmtp();                  // 呼叫繼承來的 IsSmtp() 方法
      $this->Host     = "192.168.0.5";  // SMTP 伺服器網址
      $this->SMTPAuth = true;           // SMTP 伺服器是否要求驗證
      $this->Username = "foo";          // SMTP 帳號
      $this->Password = "123456";       // SMTP 密碼

      // 寄件人與發送格式設定
      $this->From     = "service@flag.com.tw";
      $this->FromName = "旗標出版股份有限公司";
      $this->WordWrap = 72;             // 超過 72 個字元就換行
      $this->CharSet  = "utf-8";        // 使用 UTF-8 編碼
    }

    // 設定『收件人, 主旨, 內容』的方法
    function setMail($mailto, $subject, $body) {
      $this->Subject =  $subject;       // 設定主旨
      $this->Body    =  $body;          // 設定內容

      $maillist = explode(";",$mailto); // 將收件人字串存成陣列
      foreach ($maillist as $recipient) // 將陣列元素逐一加入
        $this->AddAddress($recipient);  // 收件人名單
    }
  }
?>
