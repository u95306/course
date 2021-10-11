<?php
  class Test {                                                                                               
    function __construct($name) {                                                  
      $this->name = $name;                              
      echo "...正在執行 $this->name 物件的建構方法<br/>";     
    }
  
    function __destruct() {                                                  
      echo "...正在執行 $this->name 物件的解構方法<br/>";     
    }                                                  
  }                                                    

  header("Content-type:text/html;charset=UTF-8");                                                     
  $obj1 = new Test("obj1");  // 建立物件               
  $obj2 = new Test("obj2");                              
  $obj3 = new Test("obj3");                            
  echo '<em>已建立了 3 個物件...</em><br/><br/>';                    

  echo '<em>接著要執行 $obj3 = $obj1;</em><br/>';                                                     
  $obj3 = $obj1;
  echo '<em>接著要執行 $obj2 = NULL;</em><br/>';
  $obj2 = NULL;
  echo '<em>接著要執行 $obj1 = NULL;</em><br/>';
  $obj1 = NULL;
  var_dump($obj3);
  echo '<em>程式結束</em><br/>';                                         
?>
