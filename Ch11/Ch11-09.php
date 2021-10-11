<?php
  require_once("Circle.php");      // 引入 Circle 類別

  class Cylinder extends Circle {  // 繼承 Circle 類別
    private $h;                    // 記錄圓柱高度的成員

    function __construct($radius, $height) {
      $this->r = $radius;          // 存取繼承來的成員 r
      $this->h = $height;          // 存取自己獨有的成員 h
    }

    function surfaceArea() {       // 計算圓柱面積的方法
      return 2 * $this->area() +   // 呼叫繼承來的 area() 方法
             2 * $this->r * self::PI * $this->h;
    }                              // 存取繼承來的類別常數 PI
  }

  // 主程式開始
  header('Content-type:text/html;charset=UTF-8');
  $obj = new Cylinder(3, 5);   // 建立半徑 3、高度 5 的圓柱物件
  echo '圓周率：' . Cylinder::PI . '<br/>';
  echo '<em>底部半徑 3、高度 5 的圓柱</em><br />';
  echo '其底面積為：' . $obj->area() . '<br/>';
  echo '其表面積為：' . $obj->surfaceArea();
?>
