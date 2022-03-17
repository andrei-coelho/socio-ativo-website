<?php 

include "../src/Request.php";

$request = new src\Request(['req', 'file', 'func', 'key']);

if($request->vars['req'] != 'api') {
    $file = "sources/".$request->vars['req']."_source.html";
    if(file_exists($file)) include $file;
    else include "sources/error_404_source.html";
    exit;
}

include "../src/api.php";