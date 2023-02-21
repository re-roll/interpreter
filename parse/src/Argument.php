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
    public static function createArgument($token, $type): Argument {
        $var_regex = "/(LF|TF|GF)@[a-zA-Z_$&%*!?-][a-zA-Z0-9_$&%*!?-]*/";
        $type_regex = "/string@([^\s\\]|\\\\[0-9]{3})*|bool@(true|false)|int@[-+]?[0-9]+/";
        $label_regex = "/[a-zA-Z_$&%*!?-][a-zA-Z0-9_$&%*!?-]*/";

        if ($token == null)
            exit(LEXICAL_OR_SYNTAX_ERR);
        
        $arg = new Argument($token);
        if ((preg_match($var_regex, $token)) 
            && ($type == "var")) {
            $arg->setType($type);
        }
        else if (( (preg_match($type_regex, $token)) 
                || (preg_match($var_regex, $token))) 
                && ($type == "symb")) {
            $arg->setType($type);
        }
        else if ((preg_match($type_regex, $token)) 
                && ($type == "type")) {
            $arg->setType($type);
        }
        else if ((preg_match($label_regex, $token))
                && ($type == "label")) {
            $arg->setType($type);
        }
        else exit(LEXICAL_OR_SYNTAX_ERR);

        return $arg;
    }
}

?>