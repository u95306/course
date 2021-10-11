<?php
  class Test {                                                    
    function __construct($name='NoName') {                                                  
      $this->name = $name;                              
      echo "...正在執行 $this->name 的建構方法<br/>";     
    }
  
    function __destruct() {                                                  
      echo "...正在執行 $this->name 的解構方法<br/>";     
    }                                                  
  }                                                    

  header('Content-type:text/html;charset=UTF-8');                                                     
  $obj1 = new Test('obj1');  // 未指定建構方法參數  
  $obj2 = new Test;          // 未指定建構方法參數                                        
?>
