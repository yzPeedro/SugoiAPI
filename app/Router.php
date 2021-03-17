<?php

namespace App;

use App\Response;

class Router
{
    /**
     * Variável para verificar se alguma requisição foi bem sucedida
     * 
     * @var bool $status, default false
     */
    private static $status = false;

    private static $agrs = [];

    /**
     * Função para criar uma requisição(Endpoint) dá aplicação
     * 
     * @param array          $methods  Lista de Métodos aceitos pela requisição,
     *                                 Methodos validos, "POST" OU "GET"
     * @param string         $url      Url que vai ser comparada com a url requerida.
     * @param array|function $callback Lista com classes e métodos ou função a serem chamados
     *                                 caso a requisição seja valida. Ex..:
     *                                 [App\Controllers\Controller::class => "{Metodo}"] ou function(){}
     * 
     * @return void
     */
    public static function request(array $methods, string $url, $callback)
    {
        if (self::validationRequest($methods, $url))
        {
            self::$status = true;
            
            if(is_array($callback))
            {
                foreach($callback as $class => $action)
                {
                    $ch = new $class;
                    
                    if ($ch->{$action}(new Response, self::$agrs) === false)
                    {
                        break;
                    }
                }
            }
            elseif (is_callable($callback))
            {
                $callback(new Response, self::$agrs);
            }
        }
    }

    /**
     * Função de validação da requisição
     * 
     * @param array  $methods Lista de Métodos aceitos pela requisição,
     *                        Methodos validos, "POST" OU "GET"
     * @param string $url     Url que vai ser comparada com a url requerida.
     * 
     * @return bool
     */
    private static function validationRequest(array $methods, string $url): bool
    {
        if (self::validationMethods($methods) and self::validationURL($url))
        {
            return true;
        }

        return false;
    }

    /**
     * Função de validação de methodo requerido
     * 
     * @param array $methods Lista de Métodos aceitos pela requisição,
     *                       Methodos validos, "POST" OU "GET"
     * 
     * @return bool 
     */
    private static function validationMethods(array $methods): bool
    {
        $method = strtoupper($_SERVER["REQUEST_METHOD"]);

        foreach($methods as $method_e)
        {
            if (strtoupper($method_e) === $method)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Função de validação de url
     * 
     * @param string $url Url que vai ser comparada com a url requerida.
     * 
     * @return bool
     */
    private static function validationURL(string $url): bool
    {
        $url_i = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $paramens = self::getParametersURL($url);

        if ($paramens == null or count($paramens) == 0)
        {
            if ($url_i === $url)
            {
                return true;
            }   
        }
        else
        {
            $values = null;
            
            if (preg_match(self::mountPattern($url), $url_i, $values))
            {
                self::mountArgs($paramens, $values);

                return true;
            }
        }

        return false;
    }

    /**
     * Montar array com os valores e do enviados pela URL
     * 
     * @param array $paramens Parametros separados
     * @param array $url URL já tratada
     * 
     * @return void
     */
    private static function mountArgs(array $paramens, array $url)
    {
        $num = count($url);

        if ($num > 1 and count($paramens) == ($num - 1))
        {
            self::$agrs = [];

            for ($index = 1; $index < $num; $index++)
            {
                self::$agrs[$paramens[$index - 1]] = $url[$index];
                
            }
        }
    }

    /**
     * Montagem do pattern para validação de URL
     * 
     * @param string $url URL do sistema
     * 
     * @return string|null
     */
    private static function mountPattern(string $url): string
    {
        $pattern = $url;
        $pattern = preg_replace("/\//", "\/", $pattern);
        $pattern = preg_replace("/(\{\w+\})/", "([\w\-]+)", $pattern);
        $pattern = "/^" . $pattern . "$/";
        
        return $pattern;
    }

    /**
     * Remove os parâmentros esperados pela URL
     * 
     * @param string $url URL do sistema
     * 
     * @return array
     */
    private static function getParametersURL(string $url): array
    {
        $values = null;
        $data = [];

        preg_match_all("/(?<=\{)\w+(?=\})/", $url, $values);
        
        if (count($values[0]) > 0)
        {
            $data = $values[0];
        }

        return $data;
    }

    /**
     * Função de resposta para casos de página não encontrada.
     * 
     * @return void
     */
    public static function erro404($callback)
    {
        if (self::$status === false)
        {   
            $callback(new Response);
        }
    }

}
