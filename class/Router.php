<?php

/**
 * @author http://upshots.org/php/php-seriously-simple-router
 */
class Router {
    
    private static $routes = array();
    
    private function __construct() {}
    private function __clone() {}
    
    public static function route($pattern, $callback) {
        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
        self::$routes[$pattern] = $callback;
    }
    
    public static function execute($url) {
        //$url = $_SERVER['REQUEST_URI'];
        //$url = $req;

        $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if (strpos($url, $base) === 0) {
            $url = substr($url, strlen($base));
        }
        foreach (self::$routes as $pattern => $callback) {
            if (preg_match($pattern, $url, $params)) {
                array_shift($params);

                //return call_user_func_array($callback, array_values($params));
                $result = call_user_func_array($callback, array_values($params));
                if (Helper::isJson($result) || is_array($result)) 
                    printf('%s', Response::json($result));
            }
        }
    }
}