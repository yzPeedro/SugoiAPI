<?php

namespace app\http;

class RouterCore
{        
    private $routes = [];
    private $method;
    private $uri;

    public function __construct()
    {
        $this->prepare();
        require_once("app/http/web.php");
        $this->exec();
    }

    private function prepare()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];        
    }

    private function get( $route, $execute, $params = [] )
    {
        if ( $this->method == 'GET' ) {
            $this->routes[] = [
                "route" => $route,
                "execute" => $execute,
                "params" => $params
            ];
        }     
    }

    private function execGet()
    {
        foreach ( $this->routes as $r ) {
            if ( $r['route'] == $this->uri ) {
                if ( is_callable($r['execute']) ) {
                    $r['execute']();
                    break;
                } else {
                    $params = $r['params'];
                    $r = explode("@", $r['execute']);
                    $controller = $r[0];
                    $method = $r[1];                    
                    if ( file_exists("app/http/controller/$controller.php") ) {
                        require_once("app/http/controller/$controller.php");
                        if ( method_exists($controller, $method) ) {
                            if( isset( $params ) && !empty($params) ) {
                                $app = new $controller();
                                $app->$method( $params );
                                break;
                            } else {
                                $app = new $controller();
                                $app->$method();
                                break;
                            }
                        } else {
                            echo "not found";
                            http_response_code(404);
                            break;
                        }
                    } else {
                         echo "not found";
                            http_response_code(404);
                            break;
                    }
                }
            }elseif( $r == end($this->routes) ) {
                echo "not found";
                http_response_code(404);
                die;
            }
        }
    }

    private function exec()
    {
        switch( $this->method ) {
            case 'GET':
                $this->execGet();
                break;

            case 'POST':
                $this->execPost();
                break;
        }
    }
}