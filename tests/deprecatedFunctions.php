<?php

$i = 1;
import_request_variables("gp", "rvar_");

echo "I am here";

session_register('test');

if (session_is_registered ('test')) {

    $j = "2";
    $j1 = (int) $j;    
}

$elements = explode(",", array("a,b,c"));
session_unregister('test');