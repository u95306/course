<?php
  // 定義模擬留言版的類別 MessageBoard
  class MessageBoard {
    private $count;     // 記錄留言總筆數的成員
    private $entries;   // 以陣列記錄所有留言的成員

    // 建構方法
    public function __construct() { $this->count = 0; }

    // 新增留言的方法
    // 參數 $name 為留言者, $date 為留言日期, $msg 為留言內容
    public function addMessage($name, $date, $msg) {
      $this->entries[$this->count++] = // 將每一筆留言的
         array ('name' => $name,       // 留言者、日期、留言內容
                'date' => $date,       // 以陣列型式儲存
                'message' => $msg);
    }

    // 取得留言的方法
    // 參數 $index 表留言在 $entries 陣列中的索引值
    public function getEntry($index) {
      // 檢查索引值是否超出範圍
      if ($index >=0 && $index < $this->count)  
        return $this->entries[$index];
      else                             // 若索引值超出範圍
        return NULL;                   // 則傳回 NULL
    }

    // 傳回目前留言筆數的方法
    public function howMany() {
      return $this->count;
    }
  }

  // 主程式開始
  // 建立一個留言板物件
  $obj = new MessageBoard;

  // 呼叫 addMessage() 方法模擬新增兩筆留言
  $obj->addMessage('Hunter', date('Y年m月d日H:i:s',time()), 
                   '什麼時候去看電影?');
  $obj->addMessage('Emily', date('Y年m月d日H:i:s',time()+1200), 
                   '我要借PHP的書');
?>
<html>
  <head>
     <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
     <title>模擬留言版</title>
     <style>
       body{background=url(little_bear.jpg)}
       div{color:navy;width:640;align:center;border:green solid}
     </style>
  </head>
  <body>
    <p> 
      <?php 
      $total = $obj->howMany();     // 取得總留言筆數
      echo "目前有 $total 筆留言";  // $total 稍後也會用於迴圈
      ?> 
    </p>
    <div>
      <?php
      // 利用迴圈逐筆輸出所有留言
      for ($i=0; $i<$total; $i++) {   
        $entry = $obj->getEntry($i);  // 取得第 $i 筆留言
        echo "<p><strong>留言人：{$entry['name']}</strong>
             <em>&nbsp;留言時間：{$entry['date']} </em> <br/>
             訊息內容：{$entry['message']}</p>";
      }
      ?>
    </div>
  </body>
</html>
