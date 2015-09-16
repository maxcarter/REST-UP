<?php
/**
* 
*/
class Engine 
{
    
    public function __construct() {}

    public function init($routes, $request){

        $r = $routes->__get(routes);

        $req_size = sizeof($request->__get(query));

        // 1 => /a 
        // 2 => /a/b
        // 3 => /a/b/c

        foreach($r as $key => $value) {
            if($value['type'] == "GET"){

                $req = $request->__get(query);

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
                        }
                    }

                    $func = $value['callback'];
                    if(is_callable($func)){
                        call_user_func_array($func, $params);
                    }
                }
            

                
            }
        }
    }


}
?>