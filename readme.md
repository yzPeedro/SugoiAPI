# PPHOENIX API

Olá, nós da equipe Pphoenix desenvolvemos uma REST API para facilitar o acesso a alguns links públicos de animes legendados.

# GET

Nossa REST API é totalmente baseada no protocolo GET, sendo assim, conheça nossa rota base:

    https://pphoenix-api.herokuapp.com/

  

## Parâmetros

| Requisição | HTTP | Descrição | Paramêtros |
| :---: | :---: | :---: | :---: |
| /search_anime | GET | Essa função será responsável por procurar nos links informados determinado anime e retornando VERDADEIRO caso ele exista ou FALSO caso ele não exista, a resposta será baseada na existência do anime nos determinados links, logo, pode exister a ocasião do anime existir, porém não estar disponível em nenhum link | [ anime ] |
| /get_episode | GET | Essa função será responsável por retornar um determinado episódio | [ anime, episódio ] |
| /verify_if_anime_exists | GET | Essa função será responsável por retornar um valor TRUE ou FALSE caso o anime exista ou não. | [ anime ] |
| /verify_if_exists_all_episodes | GET | Essa função será responsável por retornar todos os episódios (caso existam) passados por parâmetro | [ anime, episódios ] |
| /count_episodes | GET | Essa função será responsável por retornar TODOS os episódios encontrados em um determinado link | [ anime ] |

  

## Códigos de requisições (HTTP)

| Código | Status | Resposta |
| :--- | :---: | :--: |
| 200 | Ok | Requisição e resposta enviada com sucesso |
| 404 | Not Found | Anime não encontrado ou Link de requisição não encontrado pela API |
| 400 | Bad Request | Link requisitado pelo cliente está incorreto |
| 500 | Internal Server Error | Erro de programação na API (favor contatar o desenvolvedor quando esse for o caso) |

## Exemplos de uso da API
```php
$url = "https://pphoenix-api.herokuapp.com/pphoenix/one-piece";

$response = json_decode(file_get_contents( $url ));
print_r($response);
```

Ou

```php
$url = "https://pphoenix-api.herokuapp.com/search_anime/one-piece";
 
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = json_decode(curl_exec($ch));
print_r($response);
```