<?php

namespace App;

use App\System;

class Response
{
    /**
     * Variável com o cabeçalho da resposta HTTP
     * 
     * @var array $header, default array []
     */
    private $headers = [];

    /**
     * Variável com a resposta no modelo json
     * 
     * @var string|null $json, default null
     */
    private $json = null;
    
    /**
     * Variável com o status code da reposta HTTP
     * 
     * @var int $http_status_code, default 200 = Success
     */
    private $http_status_code = 200;

    /**
     * Dados para o componete view 
     * 
     * @var array $data, default []
     */
    private $data = [];

    /**
     * Arquivo de visualização a ser carregados
     * 
     * @var string|null $view, default null 
     */
    private $view = null;

    /**
     * Variável de verificação de renderização
     * 
     * @var bool $render, default false
     */
    private $render = false;

    /**
     * Função para setar a configuração do header para a resposta
     * 
     * @param array $header, Configuração do header para a resposta
     * 
     * @return App\Response|void
     */
    public function setHeader(array $headers)
    {
        if (!$this->render)
        {
            $this->header = array_merge($this->headers, $headers);

            return $this;
        }
    }

    /**
     * Função para setar o status da resposta
     * 
     * @return App\Response|void
     */
    public function setStatusCode(int $code)
    {
        if (!$this->render)
        {
            $this->http_status_code = $code;

            return $this;
        }
    }

    /**
     * Função para setar o arquivo de visualização a ser renderizado
     * 
     * @param string $file Local e nome do arquivo a ser renderizado
     * @param array  $data Dados que serão compartilhados com o arquivo de visualização
     * 
     * @return App\Response|void
     */
    public function view(string $file, array $data = [])
    {
        if (!$this->render)
        {
            $this->view = System::mountAddress("/view/" .  $file . ".view.php");
            $this->data = $data;
            return $this;
        }
    }

    /**
     * Função para definir os dados no formato JSON que serão enviados como resposta
     * 
     * @param array $data Lista que será convetida para o formato JSON
     * 
     * @return App\Response|null
     */
    public function json(array $data)
    {
        if (!$this->render)
        {
            $this->json = json_encode($data);

            return $this;
        }
    }

    /**
     * Função para renderização de um componente
     * 
     * @param string $file  Local e nome do arquivo a ser renderizado
     * @param array  $data  Dados que serão compartilhados com o componente a ser renderizado
     * 
     * @return string String no formato HTML com os dados já renderizados
     */
    public static function renderComponent(string $file, array $data = [])
    {
        $file = System::mountAddress("/view/" . $file . ".view.php");
        
        ob_start();

        extract($data); 

        require $file;
        $countext = ob_get_contents();
        
        ob_end_clean();

        return $countext;
    }

    /**
     * Função para finalização da resposta
     * 
     * @return void
     */
    public function run()
    {
        if (!$this->render)
        {
            $this->render = true;

            foreach($this->headers as $header)
            {
                header(...$header);
            }

            http_response_code($this->http_status_code);
            
            if ($this->view !== null and file_exists($this->view))
            {
                function run($view, $data, $json, $renderComponent)
                {
                    ob_start();

                    extract($data);

                    require $view;
                        
                    $countext = ob_get_contents();
                    ob_end_clean();

                    echo $countext;
                }
                
                run($this->view, $this->data, $this->json, function(...$data){
                    echo Response::renderComponent(...$data);
                });
            }
            elseif ($this->json != null)
            {
                header('Content-Type: application/json; charset=utf-8');
                
                echo $this->json;
            }
        }
    }

    /**
     * Função para chamar o arquivo de visualização de erros, caso ocorra um erro na resposta
     * 
     * @param int   $http_status_code Status code do erro,
     * @param array $data             Dados que serão compartilhados com o arquivo 
     *                                de visualização de erro a ser renderizado
     * 
     * @return App\Response;
     */
    public function abort(int $http_status_code, array $data = [])
    {
        return $this->view(
            "Erro/erro",
            array_merge(["status" => $http_status_code], $data)
        )->setStatusCode($http_status_code)->run();
    }
}