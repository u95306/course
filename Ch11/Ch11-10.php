<?php
  require_once("Circle.php");      // 引入 Circle 類別

  class Cylinder extends Circle {  // 繼承 Circle 類別
    private $h;                    // 記錄圓柱高度的成員度

    function __construct($radius, $height) {
      parent::__construct($radius);// 呼叫父類別建構方法
      $this->h = $height;          // 存取自己獨有的成員 h
    }

    // 將計算圓柱面積的方法改成與父類別 area() 方法同名
    function area() {              // 因此呼叫父類別同名方法時,
      return 2 * parent::area() +  // 需使用 parent:: 語法呼叫之
             2 * $this->r * self::PI * $this->h;
    }
  }

  // 主程式開始
  header("Content-type:text/html;charset=UTF-8");

  // 建立圓類別物件, 並呼叫 area() 方法輸出圓面積
  $obj1 = new Circle(3);
  echo '<em>半徑 3 的圓</em><br />';
  echo '其面積為：' . $obj1->area(). '<br/><br/>';

  // 建立圓柱類別物件, 並呼叫 area() 方法輸出圓柱面積
  $obj2 = new Cylinder(4,5);
  echo '<em>底部半徑 4、高度 5 的圓柱</em><br />';
  echo '其表面積為：' . $obj2->area();
?>
