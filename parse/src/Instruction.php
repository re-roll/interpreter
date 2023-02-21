<?php

require_once("Line.php");
require_once("Argument.php");

class Instruction{
    public$opcode;
    public $args = [];

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

        $oneArg = ["DEFVAR", "POPS", "PUSHS", "WRITE", "EXIT", "DPRINT", "CALL", "LABEL", "JUMP"];
        $twoArgs = ["READ", "MOVE", "INT2CHAR", "STRLEN", "TYPE"];
        $threeArgs = ["ADD", "SUB", "MUL", "IDIV","LT", "GT", "EQ", 
        "AND", "OR", "NOT", "STRI2INT", "CONCAT", "GETCHAR", "SETCHAR", "JUMPIFEQ", "JUMPIFNEQ"];
        $noArgs = ["CREATEFRAME", "PUSHFRAME", "POPFRAME", "RETURN", "BREAK"];

        $allArgs = array_merge($oneArg, $twoArgs, $threeArgs, $noArgs);

        foreach ($allArgs as $arg) {
            if (strtoupper($this->opcode) == $arg)
                if (in_array(strtoupper($this->opcode), $oneArg)) {
                    if ($numOfArgs != 2)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                    array_push($this->args, ArgumentFactory::createArgument($tokens[1]));
                }
                else if (in_array(strtoupper($this->opcode), $twoArgs)) {
                    if ($numOfArgs != 3)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                    array_push($this->args, ArgumentFactory::createArgument($tokens[1]));
                    array_push($this->args, ArgumentFactory::createArgument($tokens[2]));
                }
                else if (in_array(strtoupper($this->opcode), $threeArgs)) {
                    if ($numOfArgs != 4)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                    array_push($this->args, ArgumentFactory::createArgument($tokens[1]));
                    array_push($this->args, ArgumentFactory::createArgument($tokens[2]));
                    array_push($this->args, ArgumentFactory::createArgument($tokens[3]));
                }
                else if (in_array(strtoupper($this->opcode), $noArgs))
                    if ($numOfArgs != 1)
                        exit(LEXICAL_OR_SYNTAX_ERR);
            else 
                exit(OPERATION_ERR);
        }
    }

    public function getArgs() {
        return $this->args;
    }
}

