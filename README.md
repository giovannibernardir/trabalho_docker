# BrawlDex - CRUD de Produtos com Docker Compose

## 1. Descrição do projeto

Aplicação web simples de CRUD (Create, Read, Update, Delete) desenvolvida em PHP, com
persistência em banco de dados MySQL. A entidade escolhida foi **Produto**, contendo os
campos:

- `id` (chave primária, auto incremento)
- `nome` (varchar)
- `descricao` (texto)
- `preco` (decimal)
- `quantidade` (inteiro)

A aplicação permite listar, cadastrar, editar e excluir produtos, com todo o ambiente
(aplicação + banco de dados) orquestrado via Docker Compose.

## 2. Pré-requisitos

- [Docker](https://www.docker.com/) instalado
- [Docker Compose](https://docs.docker.com/compose/) instalado (já incluso nas versões
  recentes do Docker Desktop)

Não é necessário ter PHP ou MySQL instalados na máquina — tudo roda dentro dos containers.

## 3. Como executar o projeto

1. Clone o repositório:
   ```bash
   git clone https://github.com/giovannibernardir/trabalho_docker.git
   cd trabalho_docker
   ```

2. Suba os containers:
   ```bash
   docker-compose up -d
   ```

3. Criação da tabela no banco de dados:

   [TODO: descrever aqui como a tabela `produtos` é criada. Duas opções possíveis —
   apagar a que não se aplica:]
   - **Opção A (automática):** a classe `Class/Database.php` verifica se a tabela existe
     ao conectar e a cria automaticamente com `CREATE TABLE IF NOT EXISTS`, então nenhum
     passo manual é necessário.
   - **Opção B (manual):** é necessário executar um script SQL manualmente. Exemplo:
     ```bash
     docker exec -i app_db mysql -uroot -proot brawldex < caminho/para/script.sql
     ```

4. Acesse a aplicação no navegador:
   ```
   http://localhost:8080
   ```

## 4. Explicação do docker-compose.yml

O arquivo `docker-compose.yml` define dois serviços, um volume e uma rede:

- **Serviço `web`**: constrói a imagem a partir do `Dockerfile` local (`php:8.2-apache`
  com as extensões `pdo` e `pdo_mysql`), expõe a porta `8080` do host para a porta `80`
  do container (onde o Apache serve a aplicação), e monta o código-fonte do projeto como
  volume dentro do container. Recebe quatro variáveis de ambiente usadas pelo PHP para
  se conectar ao banco: `DB_HOST` (nome do serviço do banco, resolvido pela rede
  interna), `DB_USER`, `DB_PASSWORD` e `DB_NAME`.
- **Serviço `db`**: usa a imagem oficial `mysql:8.0`. Recebe as variáveis
  `MYSQL_ROOT_PASSWORD` e `MYSQL_DATABASE`, que fazem o próprio MySQL criar o banco
  `brawldex` já na primeira inicialização. Expõe a porta `3307` do host para a porta
  `3306` do container, permitindo conexão externa por um cliente de banco de dados.
- **Volume `db_data`**: associado ao caminho `/var/lib/mysql` dentro do container `db`,
  garante que os dados do banco persistam mesmo se o container for removido e recriado.
- **Rede `app-network`**: rede do tipo *bridge* criada especificamente para este
  projeto, permitindo que os containers `web` e `db` se comuniquem entre si usando o
  nome do serviço (`db`) como endereço, sem precisar expor a porta do banco para isso.

## 5. Pontos interessantes observados pela dupla

- Utilizamos variáveis de ambiente diretamente no `docker-compose.yml`, o que facilita
  trocar usuário, senha ou nome do banco sem alterar uma linha do código PHP.
- Configuramos um volume nomeado (`db_data`) para o banco de dados, garantindo que os
  produtos cadastrados não sejam perdidos ao reiniciar ou recriar os containers.
- Criamos uma rede *bridge* isolada (`app-network`) só para os containers deste projeto,
  em vez de depender da rede padrão do Docker, o que deixa explícita a comunicação
  pretendida entre os serviços.
- [TODO: adicionar pelo menos mais um aprendizado/decisão técnica da dupla, se quiserem
  ir além dos três exigidos.]

## 6. Autores

- [Giovanni Bernardi Rodrigues RA:250394]
- [James Soares Silva RA:250380]