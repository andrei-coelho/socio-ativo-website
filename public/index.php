<?php 

include "../src/Request.php";

$request = new src\Request(['req', 'route', 'func', 'session', 'secret']);

# remover em produção
if($request->vars['req'] == 'test') include "../test.php";

if($request->vars['req'] != 'api') {
    $req = $request->vars['req'] ? $request->vars['req'] : "home";
    $file = "sources/".$request->vars['req']."_source.html";
    if(file_exists($file)) include $file;
    else include "sources/error_404_source.html";
    exit;
}

include "../src/api.php";