<?php
/**
* 
*/
class Router 
{
    var $routes, $request;

    public function __construct($routes, $request) {
        $this -> routes = $routes;
        $this -> request = $request;
        $this -> init();
    }

    private function requestGET($key, $value){
        $req = $this -> request->__get(query);

        // route becomes array of the route components
        $route = explode("/", rtrim(trim($value['route'], '/'), '/'));

        $params = array();

        // Removes head of array
        $reqHead = array_shift($req);
        $routeHead = array_shift($route);

        if( sizeof($req) == sizeof($route) && preg_match("#^$routeHead$#", $reqHead)){
            for ($i=0; $i < sizeof($route); $i++) { 
                if($route[$i][0] == ':'){
                    $params[] = $req[$i];
                } else if($route[$i] != $req[$i]){
                    break;
                }
            }

            $func = $value['callback'];
            if(is_callable($func)){
                call_user_func_array($func, $params);
            }
        }
    }

    public function init(){
        $r = $this -> routes ->__get(routes);
        foreach($r as $key => $value) {
            switch($value['type']){
                case "GET":
                    $this -> requestGET($key, $value); 
                    break;
                case "POST":
                    break;
                case "PUT":
                    break;
                case "DELETE":
                    break;
                default:
                    break;
            }
        }
    }
}
?>