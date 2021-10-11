<?php
class MessageBoard { // 模擬留言版
  private $count;
  private $entries;

  public function __construct() { $this->count = 0; }

  public function addMessage($name, $date, $msg) {
    $this->entries[$this->count++] = array ($name, $date, $msg);
  }

  public function getEntry($index) { // 取得留言
    if ($index<$this->count)
      return $this->entries[$index];
    else
      return NULL;
  }

  public function howMany() {
    return $this->count;
  }
}
?>
