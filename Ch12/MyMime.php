<?php
require_once('Mail/mime.php'); // 引用 PEAR::Mail_Mime

class MyMime extends Mail_Mime {

  function headers($headers) {
    $from = $headers['From'];          // 先保留原始的內容
    $hdrs = parent::headers($headers); // 呼叫父類別的方法
    
    // 呼叫自訂的 encode_email() 方法將寄件者欄位重新編碼
    $hdrs['From'] = MyMime::encode_email($from);  
    return $hdrs;                      // 傳回編碼過的表頭 
  }
  
  // 自訂的表頭編碼靜態方法
  static function encode_email($str) {
    // 先用規則運算式找出『雙位元組字串 <郵箱地址>』格式中
    // 位於 <> 括號前的子字串, 並將之存於 $match[1] 中 
    if (ereg("^([\x80-\xFF]+)[ ]?<[^>]+>$", $str, $match)) {
      // 重新用 mb_encode_mimeheader() 函式對該子字串進行編碼
      mb_internal_encoding('utf-8');      // 指定編碼格式
      $replacement = mb_encode_mimeheader($match[1]); 
      
      // 將新的編碼字串代換到郵件表頭中的寄件者欄位
      $new_str = str_replace($match[1], $replacement, $str);
    }
    return $new_str;
  }
}
?>
