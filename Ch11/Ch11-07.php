<?php
class Circle { // 圓類別
  private $r;  // 圓半徑   

  function __construct($radius) { 
    $this->r = $radius; 
  }
  
  function getRadius() {  
    return $this->r;    // 傳回半徑
  }

  // 計算圓面積的靜態方法
  static function area($radius) { 
    return $radius * $radius * 3.14159;
  }
}

header('Content-type:text/html;charset=UTF-8');
echo '半徑 3 的圓, 其面積為 ' . Circle::area(3) . '<br />';
$obj = new Circle(5);
echo '半徑 5 的圓, 其面積為 ' . $obj->area($obj->getRadius());
?>
