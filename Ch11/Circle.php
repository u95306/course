<?php
  class Circle { // �����O
    const PI = "3.1415926535 8979323846"; // ��P�v
    protected $r;  // ���O�@����, �l���O�i�s��   

    function __construct($radius) { $this->r = $radius; }
  
    function getRadius() {  // �Ǧ^�b�|
      return $this->r;
    }

    function area() { // �p��ꭱ�n����k
      return $this->r * $this->r * self::PI;
    }
  }
?>
