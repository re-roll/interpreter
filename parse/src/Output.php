<?php

class Output {
    private $program;
    function __construct(Program $program) {
        $this->program = $program;
    }

    function printArgs($arrOfArgs) {
        $argsNum = count($arrOfArgs);
        
        switch ($argsNum) {
            case 1:
                echo "    <arg1 type=\"".$arrOfArgs[0]->type."\">";
                echo $arrOfArgs[0]->val."</arg1>\n";
                break;
            case 2:
                echo "    <arg1 type=\"".$arrOfArgs[0]->type."\">";
                echo $arrOfArgs[0]->val."</arg1>\n";
                
                echo "    <arg2 type=\"".$arrOfArgs[1]->type."\">";
                echo $arrOfArgs[1]->val."</arg2>\n";
                break;
            case 3:
                echo "    <arg1 type=\"".$arrOfArgs[0]->type."\">";
                echo $arrOfArgs[0]->val."</arg1>\n";
                
                echo "    <arg2 type=\"".$arrOfArgs[1]->type."\">";
                echo $arrOfArgs[1]->val."</arg2>\n";

                echo "    <arg3 type=\"".$arrOfArgs[2]->type."\">";
                echo $arrOfArgs[2]->val."</arg3>\n";
                break;
            default:
                exit(INTER_ERR);
        }
    }

    function printInstructions() {
        $arrOfInstrs = $this->program->getInstructions();
        foreach ($arrOfInstrs as $i => $e) {
            echo "  <instruction order=".$i."\" opcode=\"".$e->opcode."\">\n";
            $this->printArgs($e->getArgs());
            echo "  </instruction>\n";
        }
    }
    function printObj() {
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        echo "<program language=\"IPPcode23\">\n";
        $this->printInstructions();
        echo "</program>\n";
    }
}

?>