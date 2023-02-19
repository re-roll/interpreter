<?php

require_once("Line.php");

class Instruction{
    private $name;
    private $arg1 = null;
    private $arg2 = null;
    private $arg3 = null;

    public function __construct(Line $line) {
        $tokens = explode(" ", $line->content);

        $this->name = $tokens[0];

        if (isset($tokens[1]))
            $this->arg1 = $tokens[1];
        if (isset($tokens[2]))
            $this->arg2 = $tokens[2];
        if (isset($tokens[3]))
            $this->arg3 = $tokens[3];
    }

    public function getName() {
        return $this->name;
    }

    public function getArg($num) {
        switch ($num) {
            case 1:
                return $this->arg1;
            case 2:
                return $this->arg2;
            case 3:
                return $this->arg3;
            default:
                break;
        }
    }
}

