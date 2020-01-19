# Delivery App

Versão mais simples possível de um sistema de entregas de mercadorias a
clientes. Ele vai possuir um cadastro de entrega, visualização de entregas cadastradas e
o percurso no mapa.

## Pré-requesitos

Criar um projeto web utilizando ReactJS no front-end, e Node.js ou PHP (Laravel
Framework preferencialmente) na API back-end, se quiser você pode usar alguma
biblioteca para os componentes visuais do front-end como Materialize, Bootstrap ou
SemanticUI.

### Tela 1 - Cadastro de Entregas

Uma tela simples de cadastro de entregas com os campos:

- Nome do cliente
- Data de entrega
- Ponto de partida (ponto ou endereço)
- Ponto de destino (ponto ou endereço)

### Tela 2 - Lista de Entregas

Exibirá uma tabela, contendo em cada linha os dados cadastrados de cada entrega.

### Tela 3 - Mapa

Ao clicar em uma entrega da lista (da Tela 2), exibir um mapa do Google Maps.
Utilize a API do Google Maps para mostrar o seguinte nesse mapa:

- O ponto de partida
- O Ponto de destino
- O melhor trajeto entre eles

---

## Version

```0.0.1```

---

## Rodar o projeto usando Artisan:

```php artisan serve```

---

## Rodar o projeto usando Docker

```docker-compose up -d```

Obs.: Em caso de estar usando Docker e ao acessar a URl do projeto e receber um `502 Bad Gateway` provavelmente é pq o container de banco de dados não esta pronto ainda, ele é requerido para o funcionamento do container do `nginx`, nesse caso espere alguns instantes.
Pode checar também se ocorreu algum erro com o comando `docker logs app`.

---

## URl para rodar o projeto

```http://127.0.0.1:8000/```
