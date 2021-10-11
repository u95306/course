<?php
require_once('Smarty.class.php');

class Ch13Smarty extends Smarty {

  public function __construct() {
    parent::__construct(); 
    $this->template_dir = "C:\\wamp\\www\\Ch13\\templates\\";
    $this->compile_dir  = "C:\\wamp\\www\\Ch13\\templates_c\\";
    $this->config_dir   = "C:\\wamp\\www\\Ch13\\configs\\";
  }
}
?>
