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

                // temp becomes array of the route
                $temp = explode("/", rtrim(trim($value['route'], '/'), '/'));

                // pops off head of array
                $head = array_shift($req);

                if(preg_match("#^$temp[0]$#", $head)){
                    $func = $value['callback'];
                    if(is_callable($func)){
                        call_user_func_array($func, $req);
                    }
                }
            

                
            }
        }
    }


}
?>