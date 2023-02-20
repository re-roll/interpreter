<?php

class Argument {

    private $type;
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

abstract class ArgumentFactory {
    public static function createArgument($token, $pos): Argument {
        $var_regex = "/(LF|TF|GF)@[a-zA-Z_$&%*!?-][a-zA-Z0-9_$&%*!?-]*/";
        $symb_regex = "/string@([^\s\\]|\\\\[0-9]{3})*|bool@(true|false)|int@[-+]?[0-9]+/";
        $label_regex = "/[a-zA-Z_$&%*!?-][a-zA-Z0-9_$&%*!?-]*/";

        # WRITE, EXIT, DPRINT, PUSHS ARE NOT GOOD! var instead symb

        if ($token == null)
            exit(LEXICAL_OR_SYNTAX_ERR);
        
        $arg = new Argument($token);
        if ((preg_match($var_regex, $token)) && ($pos == 1)) {
            $arg->setType("var");
        }
        else if ((preg_match($symb_regex, $token)) || (preg_match($var_regex, $token))) {
            $arg->setType("symb");
        }
        else if (preg_match($symb_regex, $token)) {
            $arg->setType("type");
        }
        else if ((preg_match($label_regex, $token)) && ($pos == 1)) {
            $arg->setType("label");
        }
        else exit(LEXICAL_OR_SYNTAX_ERR);

        return $arg;
    }
}

?>