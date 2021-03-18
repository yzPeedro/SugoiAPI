<?php

namespace App;

class System
{
    /**
     * Retorna às configurações requeridas
     * 
     * @param string $file      Nome do arquivo com a configuração requerida
     * @param string $directory Local aonde se encontra o arquivo de configuração
     * 
     * @throws Exception
     * 
     * @return array
     */
    public static function getConfig(string $file, string $directory = 'config/'): array
    {
        $file = System::mountAddress($directory . $file . ".php");
 
        if (file_exists($file))
        {
            $data = require $file;

            if (is_array($data))
            {
                return $data;
            }
        }
 
        throw new \Exception("O arquivo de configuração não foi encontrado em '" . $file . "'.");
    }

    /**
     * Monta o endereço do diretorio ou arquivo para o sistema em que o projeto está rodando
     * 
     * @param string $address Endereço do arquivo ou diretorio
     * @param string $index Chave usada como referencia, default '/'
     * 
     * @return string
     */
    public static function mountAddress(string $address, string $index = "/"): string
    {
        $address = str_replace($index, DIRECTORY_SEPARATOR, $address);

        return RAIZ . DIRECTORY_SEPARATOR . $address;
    }
}