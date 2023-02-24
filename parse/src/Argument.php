<?php

class Argument {

    public $type;
    public $val;

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

abstract class ArgumentFactory {

    public static function createArgument($token): Argument {
        $var_regex = "/(LF|TF|GF)@[a-zA-Z_$&%*!?-][a-zA-Z0-9_$&%*!?-]*/";
        $symb_regex = "/string@([^\s\\]|\\\\[0-9]{3})*|bool@(true|false)|int@[-+]?[0-9]+/";
        $label_regex = "/[a-zA-Z_$&%*!?-][a-zA-Z0-9_$&%*!?-]*/";

        if ($token == null)
            exit(LEXICAL_OR_SYNTAX_ERR);
        
        $arg = new Argument($token);
        if (preg_match("/@/", $token)) {
            if (preg_match($symb_regex, $token)) {
                $pos = strpos($token, "@");
                $arg->setType(substr($token, 0, $pos));
                $arg->setVal(substr($token, $pos + 1));
            }
            else if (preg_match($var_regex, $token))
                $arg->setType("var");
            else exit(LEXICAL_OR_SYNTAX_ERR);
        }
        else if (preg_match($label_regex, $token)) {
            $arg->setType("label");
        }
        else exit(LEXICAL_OR_SYNTAX_ERR);

        return $arg;
    }
    
}

?>