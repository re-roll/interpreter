<?php

class Line {
    public $content;

    public function __construct() {
        $this->content = trim(fgets(STDIN));
    }
}

?>