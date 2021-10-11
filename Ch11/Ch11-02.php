<?php                                 
  class Test {                                     
    function __construct() {                                   
      echo '...正在執行建構方法<br/>';     
    }                                   
                                      
    function __destruct() {                                   
      echo '...正在執行解構方法<br/>';     
    }                                   
  }                                     

  header("Content-type:text/html;charset=UTF-8");                                      
  $obj = new Test;        // 建立物件   
  echo '程式結束<br/>';                      
?>                                    
