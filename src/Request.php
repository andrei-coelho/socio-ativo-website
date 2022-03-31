<?php 

namespace src;

class Request {

    public $vars;
    private static $raw;

    public function __construct(array $elements){
        
        $request = isset($_GET['request']) ? $_GET['request'] : 'home';
        $request = explode('/', trim($request));

        foreach ($elements as $k => $el) {
            $this->vars[$el] = isset($request[$k]) && trim($request[$k]) != "" ? $request[$k] : false;
        }

    }

    public static function raw(){
        if(!self::$raw) {
            self::$raw = json_decode(file_get_contents('php://input'), true);
            if(!self::$raw) self::$raw = [];
        }
        return self::$raw;
    }


}