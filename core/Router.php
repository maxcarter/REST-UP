<?php

/**
 * The Router class matches the http request with
 * the user defined routes and invokes the 
 * corresponding callback function.
 */
class Router {

    /**
     * @var object $routes Defined routes
     * @var object $request HTTP request object
     */
    var $routes, $request;


    /**
     * Constructor
     *
     * @param object $routes Routes class
     * @param object $request Request class
     */
    public function __construct($routes, $request) {
        $this -> routes  = $routes;
        $this -> request = $request;
        $this -> init();
    }

    /**
     * This method matches the http request with
     * the user defined routes and invokes the 
     * corresponding callback function.
     */
    public function init() {

        // Get routes array from object
        $r = $this -> routes ->__get(routes);

        // loop through each defined route
        foreach($r as $key => $value) {
            $req    = $this -> request -> __get(query);
            $method = $this -> request -> __get(method);

            // route becomes array of the route components
            $route = explode("/", rtrim(trim($value['route'], '/'), '/'));

            $params = array();

            // Removes head of array
            $reqHead   = array_shift($req);
            $routeHead = array_shift($route);

            if (    sizeof($req) == sizeof($route) && 
                    preg_match("#^$routeHead$#", $reqHead) && 
                    $method == $value['type']
                ) 
            {

                for ($i=0; $i < sizeof($route); $i++) { 
                    if ($route[$i][0] == ':') {
                        $params[] = $req[$i];
                    } else if ($route[$i] != $req[$i]){
                        break;
                    }
                }

                // Invoke the callback
                $func = $value['callback'];
                if (is_callable($func)) {
                    call_user_func_array($func, $params);
                }
            }
        }
    }
}
?>