<?php

require_once("Line.php");
require_once("Argument.php");

class Instruction{
    private $opcode;
    private $arg1 = null;
    private $arg2 = null;
    private $arg3 = null;

    public function __construct(Line $line) {
        $tokens = explode(" ", $line->content);

        $this->setOpcode($tokens);
        $this->setArgs($tokens);
    }

    public function setOpcode($tokens) {
        $this->opcode = $tokens[0];
    }

    public function getOpcode() {
        return $this->opcode;
    }

    public function setArgs($tokens) {
        $numOfArgs = count($tokens);

        $var_ = ["DEFVAR", "POPS"];
        $symb_ = ["PUSHS", "WRITE", "EXIT", "DPRINT"];
        $label_ = ["CALL", "LABEL", "JUMP"];
        $var_type_ = ["READ"];
        $var_symb_ = ["MOVE", "INT2CHAR", "STRLEN", "TYPE"];
        $var_symb_symb = ["ADD", "SUB", "MUL", "IDIV","LT", "GT", "EQ", 
        "AND", "OR", "NOT", "STRI2INT", "CONCAT", "GETCHAR", "SETCHAR"];
        $label_symb_symb = ["JUMPIFEQ", "JUMPIFNEQ"];
        $noArgs = ["CREATEFRAME", "PUSHFRAME", "POPFRAME", "RETURN", "BREAK"];

        $allArgs = array_merge($var_, $symb_, $label_, 
        $var_type_, $var_symb_, $var_symb_symb, $label_symb_symb, $noArgs);

        foreach ($allArgs as $arg) {
            if (strtoupper($this->opcode) == $arg)
                if (in_array(strtoupper($this->opcode), $var_)) {
                    $this->arg1 = ArgumentFactory::createArgument($tokens[1], "var");
                    if ($numOfArgs > 2)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                }
                else if (in_array(strtoupper($this->opcode), $symb_)) {
                    $this->arg1 = ArgumentFactory::createArgument($tokens[1], "symb");
                    if ($numOfArgs > 2)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                }
                else if (in_array(strtoupper($this->opcode), $label_)) {
                    $this->arg1 = ArgumentFactory::createArgument($tokens[1], "label");
                    if ($numOfArgs > 2)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                }
                else if (in_array(strtoupper($this->opcode), $var_type_)) {
                    $this->arg1 = ArgumentFactory::createArgument($tokens[1], "var");
                    $this->arg2 = ArgumentFactory::createArgument($tokens[2], "type");
                    if ($numOfArgs > 3)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                }
                else if (in_array(strtoupper($this->opcode), $var_symb_)) {
                    $this->arg1 = ArgumentFactory::createArgument($tokens[1], "var");
                    $this->arg2 = ArgumentFactory::createArgument($tokens[2], "symb");
                    if ($numOfArgs > 3)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                }
                else if (in_array(strtoupper($this->opcode), $var_symb_symb)) {
                    $this->arg1 = ArgumentFactory::createArgument($tokens[1], "var");
                    $this->arg2 = ArgumentFactory::createArgument($tokens[2], "symb");
                    $this->arg3 = ArgumentFactory::createArgument($tokens[3], "symb");
                    if ($numOfArgs > 4)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                }
                else if (in_array(strtoupper($this->opcode), $label_symb_symb)) {
                    $this->arg1 = ArgumentFactory::createArgument($tokens[1], "label");
                    $this->arg2 = ArgumentFactory::createArgument($tokens[2], "symb");
                    $this->arg3 = ArgumentFactory::createArgument($tokens[3], "symb");
                    if ($numOfArgs > 4)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                }
                else if (in_array(strtoupper($this->opcode), $noArgs))
                    if ($numOfArgs > 1)
                        exit(LEXICAL_OR_SYNTAX_ERR);
            else 
                exit(OPERATION_ERR);
        }
    }
}

