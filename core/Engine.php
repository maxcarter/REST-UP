<?php
/**
* 
*/
class Engine 
{
    
    public function __construct() {}

    public function init($routes, $request){

        $r = $routes->__get(routes);

        //print_r($r);

        $req_size = sizeof($request->__get(query));

        // 1 => /a 
        // 2 => /a/b
        // 3 => /a/b/c

        foreach($r as $key => $value) {
            if($value['type'] == "GET"){

                $req = $request->__get(query);

                if($req_size == 1){
                    $temp = trim($value['route'], '/');
                    if(preg_match("#^$temp$#", $req[0])){
                        $func = $value['callback'];
                        if(is_callable($func)){
                            echo 'callable';
                            call_user_func($func);
                        }
                    }
                }

                
            }
        }
    }


}
?>