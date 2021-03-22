# SugoiAPI

Olá, meu nome é Pedro, desenvolvi uma REST API para facilitar o acesso a alguns links públicos de animes legendados em PT/BR.

# GET

Esta API foi feita para ser um REST API, sendo assim, conheça nossa rota base:

```
https://sugoi-api.herokuapp.com
```

## Parâmetros

| Requisição | HTTP | Descrição | Paramêtro(s) |
| :---: | :---: | :---: | :---: |
| /episode | GET / POST | Esse endpoint retorna uma lista de CDN que contem o episodio requerido | [ número-do-episódio / anime ] |

  
## Exemplos de uso da API
_usando php_
```php
$url = "https://sugoi-api.herokuapp.com/episode/01/naruto-classico";

$response = json_decode(file_get_contents( $url ));
print_r($response);
```

Ou

```php
$url = "https://sugoi-api.herokuapp.com/episode/01/naruto-classico";
 
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = json_decode(curl_exec($ch));

curl_close($ch);

print_r($response);
```

## Retorno

```json
{
  "status": 200,
  "info": {
    "name": "Naruto classico",
    "slug": "naruto-classico",
    "fc": "N",
    "epi": "01"
  },
  "cdn": [
    {
      "name": "Ns545982",
      "url": "https:\/\/ns545982.ip-66-70-177.net",
      "links": [
        "https:\/\/ns545982.ip-66-70-177.net\/N\/naruto-classico-legendado\/01.mp4"
      ]
    },
    {
      "name": "Superanimes",
      "url": "https:\/\/cdn.superanimes.tv",
      "links": [
        "https:\/\/cdn.superanimes.tv\/010\/animes\/n\/naruto-classico-dublado\/01.mp4",
        "https:\/\/cdn.superanimes.tv\/010\/animes\/n\/naruto-classico-legendado\/01.mp4"
      ]
    },
    {
      "name": "Serverotaku",
      "url": "https:\/\/cdn.serverotaku01.co",
      "links": [
        "https:\/\/cdn.serverotaku01.co\/010\/animes\/n\/naruto-classico-dublado\/01.mp4",
        "https:\/\/cdn.serverotaku01.co\/010\/animes\/n\/naruto-classico-legendado\/01.mp4"
      ]
    },
    {
      "name": "Servertv",
      "url": "https:\/\/servertv001.com",
      "links": [
        "https:\/\/servertv001.com\/animes\/n\/naruto-classico-dublado\/01.mp4",
        "https:\/\/servertv001.com\/animes\/n\/naruto-classico-legendado\/01.mp4"
      ]
    }
  ]
}
```

## Códigos de requisições (HTTP)

| Código | Status | Resposta |
| :--- | :---: | :--: |
| 200 | Ok | Requisição e resposta enviada com sucesso |
| 400 | Bad Request | Link requisitado pelo cliente está incorreto |
| 500 | Internal Server Error | Erro de programação na API |

## Sobre
Dando uma pesquisada sobre animes acabei encontrando alguns links com padrões que vos levam a episódios legendados do anime que desejarmos!
Então tive a brilhante ideia de criar uma API que faça isso de maneira automática para nós, sinta-se à vontade de contribuir com essa API ou até mesmo utiliza-lá em seu própio site, caso queira utiliza-lá, me conte um pouco da experiência, irei adorar ver ela em funcionamento.
Caso algum dos links utilizados na API seja de sua propriedade e deseja remove-lô dessa api, por favor entre em contato em: pedrocruzpessoa16@gmail.com
