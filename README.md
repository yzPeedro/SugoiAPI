
# SugoiAPI

Olá, este é um projeto open source para compartilhar links de animes de maneira fácil e rápida, sinta-se à vontade para contribuir com o projeto.
Por enquanto o projeto não está hospedado em nenhum servidor, porém você pode clonar o repositório e rodar localmente com o docker:

```bash
docker compose up -d
```

## Parâmetros

| Requisição | Descrição |
|:-|:-|
| /episode/:anime-slug/:temporada/:numero-episodio | retorna uma lista de episódios encontrados em diferentes providers, certifique-se de verificar a regra de cada provider para garantir que você possa fazer a busca corretamente.

## Exemplos de Retornos

### sucesso ✅
```json  
{
  "error": false,
  "message": "Success",
  "status": 200,
  "data": [
    {
      "name": "Anime Fire",
      "slug": "anime-fire",
      "has_ads": false,
      "is_embed": false,
      "episodes": [
        {
          "error": false,
          "searched_endpoint": "https://animefire.plus/video/naruto/1",
          "episode": "https://lightspeedst.net/s3/mp4/naruto/sd/1.mp4"
        }
      ]
    }
  ]
}
```  

### erro ❌
```json
{
  "error": true,
  "message": "Not Found",
  "status": 404
}
```  

## Códigos de requisições (HTTP)

| Código | Status | Resposta |  
| :--- | :--- | :-- |  
| 200 | Ok | Episódio encontrado |  
| 404 | Not Found | Episódio não encontrado |

## Disclaimer
Este projeto não tem o intuito de incentivar a pirataria, o projeto foi criado com o intuito de facilitar o acesso a animes de maneira gratuita, caso você goste do anime, por favor considere apoiar o criador comprando o produto original.
Este projeto não hospeda nenhum conteúdo, apenas redireciona para sites de terceiros, caso você seja o dono de algum dos links e deseja removê-lo, por favor entre em contato comigo através do email: pedrocruzpessoa16@gmail.com

## Sobre
O projeto tem o intuito de fazer com que você possa assistir anime sem ter que obrigatoriamente ver diversos anúncios para isso, caso algum dos links utilizados na API seja de sua propriedade e deseja remove-lô dessa api, por favor entre em contato em: pedrocruzpessoa16@gmail.com com o assunto "SugoiAPI", ou caso você queira utilizar a api em algum projeto, me envie um email também, adoraria poder conhecer seu projeto, use com moderação ;)

## Providers

Providers são em resumo os provedores dos links que você acessa para assistir um anime, 
é a partir dos providers que conseguimos pegar os links e dinponibiliza-los na api, cada provider possui uma maneira diferente de enviar a requisição, 
caso seu serviço/site/api esteja sendo utilizado como um provider e você deseja que ele seja removido, por favor entre em contato comigo através do email: pedrocruzpessoa16@gail.com que farei
a remoção do mesmo de imediato, caso você deseja consumir a api consulte a [documentação de providers](https://github.com/yzPeedro/SugoiAPI/wiki/Providers).

