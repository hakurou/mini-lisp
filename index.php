<?php

function __autoload($name)
{
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $name);
    $classPath = dirname(__FILE__).DIRECTORY_SEPARATOR.$classPath.'.class.php';
    
    require_once($classPath);
}

// TESTS

$ml = new \library\ml\MiniLisp();
$ml->parseFile(dirname(__FILE__).'/tests/test2.lsp');

?>