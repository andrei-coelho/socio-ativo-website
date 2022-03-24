<?php 

include "../src/Request.php";
include "../api/autoload.php";
include "../api/helpers/config.php";
include "../api/helpers/response.php";
include "../api/helpers/sqli.php";
include "../api/helpers/user.php";
include "../api/helpers/session.php";

$request = new src\Request(['req', 'route', 'func', 'session', 'secret']);

if(!_is_in_production() && $request->vars['req'] == 'test') include "../src/test.php";

if($request->vars['req'] != 'api') {
    $req = $request->vars['req'] ? $request->vars['req'] : "home";
    $file = "sources/".$request->vars['req']."_source.html";
    if(file_exists($file)) include $file;
    else include "sources/error_404_source.html";
    exit;
}

include "../src/api.php";