# SugoiAPI

Olá, meu nome é Pedro, desenvolvi uma REST API para facilitar o acesso a alguns links públicos de animes legendados em PT/BR.

# GET

Esta REST API é totalmente baseada no protocolo GET, sendo assim, conheça nossa rota base:

    https://sugoi-api.herokuapp.com/

  

## Parâmetros

| Requisição | HTTP | Descrição | Paramêtros |
| :---: | :---: | :---: | :---: |
| /count_to | GET | Essa função será responsável por retornar TODOS os episódios encontrados em um determinado link | [ anime ] |
| /anime_exists | GET | Essa função será responsável por retornar um valor TRUE ou FALSE caso o anime exista ou não. | [ anime ] |
| /get_episode | GET | Essa função será responsável por retornar um determinado episódio | [ anime, episódio ] |

  
## Exemplos de uso da API
_usando php_
```php
$url = "https://sugoi-api.herokuapp.com/search_anime/one-piece";

$response = json_decode(file_get_contents( $url ));
print_r($response);
```

Ou

```php
$url = "https://sugoi-api.herokuapp.com/search_anime/one-piece";
 
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = json_decode(curl_exec($ch));
print_r($response);
```

## Códigos de requisições (HTTP)

| Código | Status | Resposta |
| :--- | :---: | :--: |
| 200 | Ok | Requisição e resposta enviada com sucesso |
| 404 | Not Found | Anime não encontrado ou Link de requisição não encontrado pela API |
| 400 | Bad Request | Link requisitado pelo cliente está incorreto |
| 500 | Internal Server Error | Erro de programação na API (favor contatar o desenvolvedor quando esse for o caso) |

## Sobre
Dando uma pesquisada sobre animes acabei encontrando alguns links com padrões que vos levam a episódios legendados do anime que desejarmos!
Então tive a brilhante ideia de criar uma API que faça isso de maneira automática para nós, sinta-se à vontade de contribuir com essa API ou até mesmo utiliza-lá em seu própio site, caso queira utiliza-lá, me conte um pouco da experiência, irei adorar ver ela em funcionamento.
Caso algum dos links utilizados na API seja de sua propriedade e deseja remove-lô dessa api, por favor entre em contato em: pedrocruzpessoa16@gmail.com