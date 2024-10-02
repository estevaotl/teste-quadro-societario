# Projeto visando o teste técnico da Vox Tecnologia

## Quadro de Societários

### Descrição do Projeto

- Nesse projeto, criei um CRUD de empresas e sócios, no qual, ao criar a empresa, pode-se vincular sócios a essa devida empresa.
- Esse projeto foi feito nas seguintes configurações:
  - Back-end:
    - PHP na versão 8.1
    - Simfony Framework na versão latest
    - Rotas utilizando o padrão RESTful
    - Doctrine ORM
  - Front-end:
    - Twig na versão 3.x
  - Banco de Dados:
    - PostgreSQL
- Para importar os pacotes, utilizei o Composer.

## Requisitos

- Ter o composer instalado
- PHP na versão 8.1 ou maior
- Ter o PostgreSQL instalado, seja o proprio programa ou um servidor a parte, como o Laragon

## Como Utilizar

- Rodar `composer install` tanto na index quanto na pasta `cadastro-empresas`
- No meu local, eu utilizei o PostgreSQL direto no Laragon e para acessar os dados, utilizei o HeidiSQL. Logo, bastava startar o Laragon que o banco de dados já estava funcionando.
  - Caso precise atualizar alguma credencial de acesso ao banco, basta procurar no `.env` na pasta `cadastro-empresas` por `DATABASE_URL` e alterar a URL do banco.
- Subir o servidor php pelo terminal ( utilizei o visual studio code para desenvolvimento )
   - `php -S localhost:8000 -t public`
