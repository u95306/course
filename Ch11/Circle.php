<?php
  class Circle { // 圓類別
    const PI = "3.1415926535 8979323846"; // 圓周率
    protected $r;  // 受保護成員, 子類別可存取   

    function __construct($radius) { $this->r = $radius; }
  
    function getRadius() {  // 傳回半徑
      return $this->r;
    }

    function area() { // 計算圓面積的方法
      return $this->r * $this->r * self::PI;
    }
  }
?>
