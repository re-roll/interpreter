<?php

class Line {
    public $content;

    public function __construct() {
        if (!STDIN)
            exit(INPUT_ERR);
        $this->content = trim(fgets(STDIN));
    }

    public function deleteComments() {
        $chars = str_split($this->content);

        foreach ($chars as $i => $char) {
            if ($char == "#")
                $this->content = trim(substr($this->content, 0, $i));
        }
    }
    
}

?>