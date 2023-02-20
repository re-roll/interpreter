<?php

require_once("Instruction.php");

class Program{
    private $header;
    private $instructions;

    public function __construct() {
        $this->header = false;
        $this->instructions = [];

        while (!feof(STDIN)) {
            $line = new Line();
            $line->deleteComments();
    
            if (!empty($line->content)) {
                if ($line->content == ".IPPcode23")
                    $this->setHeader();
                else {
                    $instruction = new Instruction($line);
                    $this->setInstruction($instruction);
                }
    
                if (!$this->getHeader())
                    exit(HEADER_ERR);
            }
        }
    }

    public function setHeader() {
        $this->header = true;
    }

    public function getHeader() {
        return $this->header;
    }

    public function setInstruction(Instruction $instruction) {
        $this->instructions[] = $instruction;
    }

    public function getInstructions() {
        return $this->instructions;
    }
}

?>
