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
                echo "\t\t<arg1 type=\"".$arrOfArgs[0]->type."\">\n";
                echo "\t\t\t".$arrOfArgs[0]->val."\n\t\t</arg1>\n";
                break;
            case 2:
                echo "\t\t<arg1 type=\"".$arrOfArgs[0]->type."\">\n";
                echo "\t\t\t".$arrOfArgs[0]->val."\n\t\t</arg1>\n";
                
                echo "\t\t<arg2 type=\"".$arrOfArgs[1]->type."\">\n";
                echo "\t\t\t".$arrOfArgs[1]->val."\n\t\t</arg2>\n";
                break;
            case 3:
                echo "\t\t<arg1 type=\"".$arrOfArgs[0]->type."\">\n";
                echo "\t\t\t".$arrOfArgs[0]->val."\n\t\t</arg1>\n";
                
                echo "\t\t<arg2 type=\"".$arrOfArgs[1]->type."\">\n";
                echo "\t\t\t".$arrOfArgs[1]->val."\n\t\t</arg2>\n";

                echo "\t\t<arg3 type=\"".$arrOfArgs[2]->type."\">\n";
                echo "\t\t\t".$arrOfArgs[2]->val."\n\t\t</arg3>\n";
                break;
            default:
                exit(INTER_ERR);
        }
    }

    function printInstructions() {
        $arrOfInstrs = $this->program->getInstructions();
        foreach ($arrOfInstrs as $i => $e) {
            echo "\t<instruction order=".$i."\" opcode=\"".$e->opcode."\">\n";
            $this->printArgs($e->getArgs());
            echo "\t</instruction>\n";
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