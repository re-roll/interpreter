<?php

require_once("Line.php");
require_once("Argument.php");

class Instruction{
    
    public $opcode;
    public $args = [];

    public function setOpcode($tokens) {
        $this->opcode = $tokens[0];
    }

    public function getOpcode() {
        return $this->opcode;
    }

    public function setArgs($token) {
        array_push($this->args, $token);
    }

    public function getArgs() {
        return $this->args;
    }

}

abstract class InstructionFactory {

    public static function createInstruction(Line $line): Instruction {
        $instruction = new Instruction();

        $tokens = explode(" ", $line->content);
        $numOfArgs = count($tokens);

        $instruction->setOpcode($tokens);

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
            if (strtoupper($instruction->opcode) == $arg) {
                if (in_array(strtoupper($instruction->opcode), $var_)) {
                    if ($numOfArgs != 2)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                    $instruction->setArgs(ArgumentFactory::createArgument($tokens[1], "var"));
                }
                else if (in_array(strtoupper($instruction->opcode), $symb_)) {
                    if ($numOfArgs != 2)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                    $instruction->setArgs(ArgumentFactory::createArgument($tokens[1], "symb"));
                }
                else if (in_array(strtoupper($instruction->opcode), $label_)) {
                    if ($numOfArgs != 2)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                    $instruction->setArgs(ArgumentFactory::createArgument($tokens[1], "label"));
                }
                else if (in_array(strtoupper($instruction->opcode), $var_type_)) {
                    if ($numOfArgs != 3)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                    $instruction->setArgs(ArgumentFactory::createArgument($tokens[1], "var"));
                    $instruction->setArgs(ArgumentFactory::createArgument($tokens[2], "type"));
                }
                else if (in_array(strtoupper($instruction->opcode), $var_symb_)) {
                    if ($numOfArgs != 3)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                    $instruction->setArgs(ArgumentFactory::createArgument($tokens[1], "var"));
                    $instruction->setArgs(ArgumentFactory::createArgument($tokens[2], "symb"));
                }
                else if (in_array(strtoupper($instruction->opcode), $var_symb_symb)) {
                    if ($numOfArgs != 4)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                    $instruction->setArgs(ArgumentFactory::createArgument($tokens[1], "var"));
                    $instruction->setArgs(ArgumentFactory::createArgument($tokens[2], "symb"));
                    $instruction->setArgs(ArgumentFactory::createArgument($tokens[3], "symb"));
                }
                else if (in_array(strtoupper($instruction->opcode), $label_symb_symb)) {
                    if ($numOfArgs != 4)
                        exit(LEXICAL_OR_SYNTAX_ERR);
                    $instruction->setArgs(ArgumentFactory::createArgument($tokens[1], "label"));
                    $instruction->setArgs(ArgumentFactory::createArgument($tokens[2], "symb"));
                    $instruction->setArgs(ArgumentFactory::createArgument($tokens[3], "symb"));
                }
                else if (in_array(strtoupper($instruction->opcode), $noArgs))
                    if ($numOfArgs != 1)
                        exit(LEXICAL_OR_SYNTAX_ERR);
            else 
                exit(OPERATION_ERR);
            }
        }

        return $instruction;
    }

}