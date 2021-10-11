<?php
  class Circle { // 圓類別
    const PI = "3.1415926535 8979323846"; // 圓周率
    private $r;  // 圓半徑   

    function __construct($radius) { $this->r = $radius; }
  
    function getRadius() {  // 傳回半徑
      return $this->r;
    }

    static function area($radius) { // 計算圓面積的靜態方法
      return $radius * $radius *    // 傳回半徑平方乘上圓周率
             self::PI;              // 類別內可使用 self:: 語法
    }
  }

  header("Content-type:text/html;charset=UTF-8");
                            // 類別外僅可使用『類別名稱::』語法  
  echo "圓周率到小數點後 20 位數：" . Circle::PI . "<br />";
  echo "半徑 5 的圓, 其面積為 " . Circle::area(5) . "<br />";
  $obj = new Circle(3);
  echo "半徑 3 的圓, 其面積為 " . $obj->area($obj->getRadius());
?>
