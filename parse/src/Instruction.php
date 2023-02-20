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
        $var_regex = "/(LF|TF|GF)@[a-zA-Z_$&%*!?-][a-zA-Z0-9_$&%*!?-]*/";
        $symb_regex = "/string@([^\s\\]|\\\\[0-9]{3})*|bool@(true|false)|int@[-+]?[0-9]+/";
        $label_regex = "/[a-zA-Z_$&%*!?-][a-zA-Z0-9_$&%*!?-]*/";

        switch (strtoupper($this->opcode)) {
            case "DEFVAR":
                if (preg_match($var_regex, $tokens[1])) {
                    $this->arg1 = new Argument($tokens[1]);
                    $this->arg1->setType("var");
                }
                break;
            case "PUSHS":
            case "WRITE":
            case "EXIT":
            case "DPRINT":
                if ((preg_match($symb_regex, $tokens[1])) || (preg_match($var_regex, $tokens[1]))) {
                    $this->arg1 = new Argument($tokens[1]);
                    $this->arg1->setType("symb");
                }
                else exit(LEXICAL_OR_SYNTAX_ERR);
                break;
            case "CALL":
            case "POPS":
            case "LABEL":
            case "JUMP":
                if (preg_match($label_regex, $tokens[1])) {
                    $this->arg1 = new Argument($tokens[1]);
                    $this->arg1->setType("label");
                }
                else exit(LEXICAL_OR_SYNTAX_ERR);
                break;
            case "MOVE":
            case "INT2CHAR":
            case "STRLEN":
            case "TYPE":
                if (preg_match($var_regex, $tokens[1])) {
                    $this->arg1 = new Argument($tokens[1]);
                    $this->arg1->setType("var");
                }
                else exit(LEXICAL_OR_SYNTAX_ERR);
                if ((preg_match($symb_regex, $tokens[2])) || (preg_match($var_regex, $tokens[2]))) {
                    $this->arg2 = new Argument($tokens[2]);
                    $this->arg2->setType("symb");
                }
                else exit(LEXICAL_OR_SYNTAX_ERR);
                break;
            case "READ":
                if (preg_match($var_regex, $tokens[1])) {
                    $this->arg1 = new Argument($tokens[1]);
                    $this->arg1->setType("var");
                }
                else exit(LEXICAL_OR_SYNTAX_ERR);
                # Check only symb_regex because only TYPE needed here
                if (preg_match($symb_regex, $tokens[2])) {
                    $this->arg2 = new Argument($tokens[2]);
                    $this->arg2->setType("type");
                }
                else exit(LEXICAL_OR_SYNTAX_ERR);
                break;
            case "ADD":
            case "SUB":
            case "MUL":
            case "IDIV":
            case "LT":
            case "GT":
            case "EQ":
            case "AND":
            case "OR":
            case "NOT":
            case "STRI2INT":
            case "CONCAT":
            case "GETCHAR":
            case "SETCHAR":
                if (preg_match($var_regex, $tokens[1])) {
                    $this->arg1 = new Argument($tokens[1]);
                    $this->arg1->setType("var");
                }
                else exit(LEXICAL_OR_SYNTAX_ERR);
                if ((preg_match($symb_regex, $tokens[2])) || (preg_match($var_regex, $tokens[2]))) {
                    $this->arg2 = new Argument($tokens[2]);
                    $this->arg2->setType("symb");
                }
                else exit(LEXICAL_OR_SYNTAX_ERR);
                if ((preg_match($symb_regex, $tokens[3])) || (preg_match($var_regex, $tokens[3]))) {
                    $this->arg3 = new Argument($tokens[3]);
                    $this->arg3->setType("symb");
                }
                else exit(LEXICAL_OR_SYNTAX_ERR);
                break;
            case "JUMPIFEQ":
            case "JUMPIFNEQ":
                if (preg_match($label_regex, $tokens[1])) {
                    $this->arg1 = new Argument($tokens[1]);
                    $this->arg1->setType("label");
                }
                else exit(LEXICAL_OR_SYNTAX_ERR);
                if ((preg_match($symb_regex, $tokens[2])) || (preg_match($var_regex, $tokens[2]))) {
                    $this->arg2 = new Argument($tokens[2]);
                    $this->arg2->setType("symb");
                }
                else exit(LEXICAL_OR_SYNTAX_ERR);
                if ((preg_match($symb_regex, $tokens[3])) || (preg_match($var_regex, $tokens[3]))) {
                    $this->arg3 = new Argument($tokens[3]);
                    $this->arg3->setType("symb");
                }
                else exit(LEXICAL_OR_SYNTAX_ERR);
                break;
            case "CREATEFRAME":
            case "PUSHFRAME":
            case "POPFRAME":
            case "RETURN":
            case "BREAK":
                break;
            default:
                exit(OPERATION_ERR);
        }
    }
}

