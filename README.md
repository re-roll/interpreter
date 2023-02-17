# PHP parser

## Final version: March 2023

### Description
A filter script (parse.php in PHP 8.1) reads the source code in custom language "IPPcode23" from the standard input, checks the lexical and syntactic correctness of the code and writes XML representation of the program to standard.

### Usage details
This script will work with the following parameters:
+ `--help`

Parser-specific error return codes:
+ 21 - wrong or missing header in the source code written in IPPcode23;
+ 22 - unknown or incorrect operation code in the source code written in IPPcode23;
+ 23 - other lexical or syntactic error of the source code written in IPPcode23.

### Description of the output XML format
The mandatory XML header is followed by the root element `program` (with the mandatory text attribute language "IPPcode23"), which contains instruction elements `instructions`. Each element `instruction` contains a mandatory attribute `order`. When generating elements, the sequence is numbered from 1. Furthermore, the element contains the mandatory `opcode` attribute (the value of the operation code is always in capital letters in the output XML) and elements for the corresponding number of operands/arguments: `arg1`, `arg2`, `arg3`. The element for the argument has a mandatory attribute `type` with possible values `int`, `bool`, `string`, `nil`, `label`, `type`, `var` depending on whether there is a literal, label, type, or variable, and contains a text element.

This text element then carries either the value of a literal (no longer specifying the type and without the @ character), label name, type, or variable identifier (including frame and @ designations). Variables marking the frame are always written in capital letters, as it should already be on the input. The size of the letters of var names are unchanged. The format of integers is decimal, octal or hexadecimal according to PHP conventions, however, output of these numbers is exactly in the format in which it was loaded from the source code (e.g. positive number signs or leading excess zeros will remain). For `string` literals, do not convert the original escape sequence when writing to XML, but only for problematic characters in XML (eg `<`, `>`, `&`) use the corresponding XML entities (eg `&lt;`, `&gt;`, `&amp;`). Similarly, convert problematic characters occurring in variable identifiers. Always write `bool` literals in lowercase like `false` or `true`.
