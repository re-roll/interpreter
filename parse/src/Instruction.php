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

        $oneArg = ["DEFVAR", "PUSHS", "WRITE", "EXIT", 
        "DPRINT", "CALL", "POPS", "LABEL", "JUMP"];
        $twoArgs = ["MOVE", "INT2CHAR", "STRLEN", "TYPE", "READ"];
        $threeArgs = ["ADD", "SUB", "MUL", "IDIV", "LT", "GT", "EQ", 
        "AND", "OR", "NOT", "STRI2INT", "CONCAT", "GETCHAR", "SETCHAR", "JUMPIFEQ", "JUMPIFNEQ"];
        $noArgs = ["CREATEFRAME", "PUSHFRAME", "POPFRAME", "RETURN", "BREAK",];

        $allArgs = array_merge($oneArg, $twoArgs, $threeArgs, $noArgs);

        foreach ($allArgs as $arg) {
            if (strtoupper($this->opcode) == $arg)
                if (in_array(strtoupper($this->opcode), $oneArg)) {
                    $this->arg1 = ArgumentFactory::createArgument($tokens[1], 1);
                    if ($numOfArgs > 2)
                        exit(OPERATION_ERR);
                }
                else if (in_array(strtoupper($this->opcode), $twoArgs)) {
                    $this->arg1 = ArgumentFactory::createArgument($tokens[1], 1);
                    $this->arg2 = ArgumentFactory::createArgument($tokens[2], 2);
                    if ($numOfArgs > 3)
                        exit(OPERATION_ERR);
                }
                else if (in_array(strtoupper($this->opcode), $threeArgs)) {
                    $this->arg1 = ArgumentFactory::createArgument($tokens[1], 1);
                    $this->arg2 = ArgumentFactory::createArgument($tokens[2], 2);
                    $this->arg3 = ArgumentFactory::createArgument($tokens[3], 3);
                    if ($numOfArgs > 4)
                        exit(OPERATION_ERR);
                }
                else if (in_array(strtoupper($this->opcode), $noArgs))
                    if ($numOfArgs > 1)
                        exit(OPERATION_ERR);
            else 
                exit(OPERATION_ERR);
        }
    }
}

