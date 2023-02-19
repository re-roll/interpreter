# Interpreter for custom language IPPcode23

## Final version: March 2023

## First part: `parse.php`

### Description
A filter script (parse.php in PHP 8.1) reads the source code in custom language "IPPcode23" from the standard input, checks the lexical and syntactic correctness of the code and writes XML representation of the program to standard.

### Usage details
This script will work with the following parameters:
+ `--help`

Parser-specific error return codes:
+ 21 - wrong or missing header in the source code written in IPPcode23;
+ 22 - unknown or incorrect operation code in the source code written in IPPcode23;
+ 23 - other lexical or syntactic error of the source code written in IPPcode23.
