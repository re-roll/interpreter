<?php

class Argument {

    private $type; # int, bool, string, nil, label, type, var
    private $val;

    public function __construct($arg) {    
        $this->val = $arg;
    }

    public function setType($str) {
        $this->type = $str;
    }

    public function getType() {
        return $this->type;
    }

    public function setVal($val) {
        $this->val = $val;
    }

    public function getVal() {
        return $this->type;
    }

}

?>