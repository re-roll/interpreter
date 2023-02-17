<?php

/*
 *Kód k 1. úloze do IPP 2022/2023
 *Jméno a příjmení: Dmitrii Ivanushkin
 *Login: xivanu00
 */

require_once "src/lexical_analysis.php";
require_once "src/syntax_analysis.php";

function printHelp() {
    echo "Usage: parse.php [--help]\n\n";

    echo "Skript typu filtr nacte ze standardniho vstupu zdrojovy kod v IPP-code23,\n";
    echo "zkontroluje lexikalni a syntaktickou spravnost kodu\n";
    echo "a vypise na standardni vystup XML reprezentaci programu\n\n";

    echo "Chybove navratove kody specificke pro analyzator:\n";
    echo "21 - chybna nebo chybejici hlavicka ve zdrojovem kodu zapsanem v IPPcode23\n";
    echo "22 - neznamy nebo chybny operacni kod ve zdrojovem kodu zapsanem v IPPcode23\n";
    echo "23 - jina lexikalni nebo syntakticka chyba zdrojoveho kodu zapsaneho v IPPcode23\n";
}
function hasHelp() {
    global $argc, $argv;

    if (isset($argc)) {
        for ($i = 0; $i < $argc; $i++) {
            if ($argv[$i] == "--help") {
                printHelp();
                exit(0);
            }
        }
    }
}

function main() {
    hasHelp();
}

main();

?>