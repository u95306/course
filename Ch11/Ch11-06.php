<?php
  class Circle {
    private $r;                 // 半徑
    static private $count = 0;  // 物件計數器, 預設值為 0 

    function __construct($radius) {
      $this->r = $radius;
      Circle::$count++;         // 每建立一個物件, 計數器就加 1
    }

    function __destruct() {
      Circle::$count--;         // 每釋放一個物件, 計數器就減 1
    }

    // 傳回現有物件數量的方法
    function count() { return Circle::$count; }
  }

  // 主程式開始, 先建立 4 個物件
  $obj1 = new Circle(3);
  $obj2 = new Circle(4);
  $obj3 = new Circle(5);
  $obj4 = new Circle(6);

  // 將 $obj3 設為 NULL, 使它所參考的物件被解構
  $obj3 = NULL;
  header('Content-type:text/html;charset=UTF-8');
  echo '現在有 ' . $obj1->count() .  // 輸出現有物件數量
       ' 個Circle物件';
?>
