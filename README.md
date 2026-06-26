
# Delivery API

Sistema de delivery desenvolvido em Laravel (PHP) para gerenciamento de restaurantes, categorias, produtos e pedidos.

## Descrição

API RESTful que oferece funcionalidades completas para gerenciamento de um sistema de delivery, incluindo:

- **Restaurantes**: criação, edição, visualização, listagem e remoção de restaurantes.
- **Categorias**: cadastro, listagem por restaurante, edição, visualização e remoção de categorias.
- **Produtos**: cadastro, listagem por categoria, edição, visualização e remoção de produtos.
- **Pedidos**: criação de pedidos, listagem por restaurante, visualização e atualização de status.

## Tecnologias

- PHP 8.2
- Laravel 12
- PostgreSQL
- SQLite (utilizado nos testes automatizados)
- Docker + Docker Compose + Apache
- Pest
- Swagger UI

## Arquitetura

O projeto adota uma arquitetura em camadas (Layered Architecture), promovendo separação de responsabilidades entre apresentação, regras de negócio e acesso aos dados. A utilização de DTOs, Services e Repositories contribui para um código mais desacoplado, testável e de fácil manutenção. Além disso, as dependências são resolvidas por meio do container de serviços do Laravel, utilizando interfaces e injeção de dependência para reduzir o acoplamento entre as camadas da aplicação.

### Repository Pattern

A camada de **Repositories** é responsável por abstrair o acesso aos dados, evitando que regras de negócio fiquem acopladas diretamente ao Eloquent.

Isso permite:
- Isolar a lógica de persistência
- Facilitar testes
- Permitir alterações na camada de persistência sem impactar as regras de negócio

Exemplo de estrutura:

```text
app/
├── Repositories/
│   ├── Restaurant/
│   │   ├── RestaurantRepositoryInterface.php
│   │   ├── RestaurantRepository.php
│   ├── Product/
│   │   ├── ProductRepositoryInterface.php
│   │   ├── ProductRepository.php
│   ├── Category/
│   │   ├── CategoryRepositoryInterface.php
│   │   ├── CategoryRepository.php
│   ├── Order/
│       ├── OrderRepositoryInterface.php
│       ├── OrderRepository.php
```

---

### DTOs (Data Transfer Objects)

Os **DTOs** são utilizados para transportar dados entre camadas da aplicação de forma tipada e previsível.

Eles ajudam a:
- Evitar uso direto de Requests/Models nas regras de negócio
- Melhorar legibilidade
- Garantir consistência dos dados

Exemplo de estrutura:

```text
app/
├── DTOs/
│   ├── Category/
│   │   ├── CreateCategoryDTO.php
│   │   ├── UpdateCategoryDTO.php
│   ├── Order/
│   │   ├── CreateOrderDTO.php
│   │   ├── CreateOrderItemDTO.php
│   │   ├── UpdateOrderStatusDTO.php
│   ├── Product/
│   │   ├── CreateProductDTO.php
│   │   ├── UpdateProductDTO.php
│   ├── Restaurant/
│       ├── CreateRestaurantDTO.php
│       ├── UpdateRestaurantDTO.php
```

---

### Services Layer

A camada de **Services** concentra as regras de negócio da aplicação, mantendo os Controllers mais limpos e responsáveis apenas por orquestração das requisições.

Responsabilidades:
- Aplicar regras de negócio
- Coordenar chamadas entre Repositories
- Manipular DTOs

---

### Controllers

Os Controllers possuem responsabilidade reduzida, atuando apenas como entrada da API.

Eles:
- Recebem a requisição
- Validam via Form Requests
- Chamam Services
- Retornam respostas formatadas

---

### Form Requests

Utilizados para validação das requisições HTTP, mantendo os Controllers mais limpos.

Exemplo de estrutura:

```text
app/
├── Http/
│   └── Requests/
│       ├── Auth/
│       │   ├── LoginRequest.php
│       │   └── StoreUserRequest.php
│       ├── Category/
│       │   ├── StoreCategoryRequest.php
│       │   └── UpdateCategoryRequest.php
│       ├── Order/
│       │   ├── StoreOrderRequest.php
│       │   └── UpdateOrderStatusRequest.php
│       ├── Product/
│       │   ├── StoreProductRequest.php
│       │   └── UpdateProductRequest.php
│       ├── Restaurant/
│       │   ├── StoreRestaurantRequest.php
│       │   └── UpdateRestaurantRequest.php
```

---

### Estrutura geral de fluxo

```text
 HTTP Request
      │
      ▼
 Form Request
      │
      ▼
  Controller
      │
      ▼
     DTO
      │
      ▼
   Service
      │
      ▼
  Repository
      │
      ▼
   Database
      │
      ▼
   Resource
      │
      ▼
HTTP Response
```

## Como executar

#### Pré-requisitos

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/)

### Instalação

Clone o repositório e execute o comando abaixo para subir os containers da aplicação e do banco de dados:

```bash
docker-compose up --build -d
```

### Documentação da API

Após a inicialização da aplicação, a documentação interativa estará disponível em:

``http://localhost:8080/api/documentation``

### Executando os Testes

O projeto utiliza o Pest para testes automatizados.

Para executá-los:

```bash
docker compose exec app php artisan test
```

### Utilizando a Collection do Postman

A pasta ```postman/``` contém:

- Uma Collection com todos os endpoints da API.
- Um Environment com as variáveis necessárias para execução das requisições.

#### Importando a Collection
1. Abra o Postman.
2. Clique em Import.
3. Selecione o arquivo da Collection localizado na pasta postman/.
4. Aguarde a importação.

#### Importando o Environment
1. Clique em Import novamente.
2. Selecione o arquivo de Environment localizado na pasta postman/.
3. Após a importação, selecione o ambiente no canto superior direito do Postman.

#### Executando as Requisições

Certifique-se de que:

- A aplicação esteja em execução.
- O Environment importado esteja selecionado.
- A variável base_url esteja configurada corretamente.

Valor padrão:

http://localhost:8080/api

### Alimentando o Banco de Dados

O projeto disponibiliza **seeders** para popular o banco de dados com dados de exemplo, facilitando a exploração da API por meio da documentação do Swagger UI e da Collection do Postman.

Os exemplos presentes no Swagger UI e na Collection do Postman foram construídos com base nesses dados. Para reproduzir o ambiente exatamente como documentado, recomenda-se iniciar com um banco de dados limpo e executar os seeders.

Para recriar o banco de dados e populá-lo com os dados iniciais, execute:

```bash
docker compose exec app php artisan migrate:fresh --seed
```

## Estrutura do Projeto

```text
delivery/
├── app/
│   ├── Docs/           # Classes e definições relacionadas à documentação da API
│   ├── DTOs/           # Data Transfer Objects
│   ├── Enums/          # Enumerações utilizadas
│   ├── Exceptions/     # Exceções customizadas
│   ├── Http/           # Controllers, Requests e Resources
│   ├── Models/         # Models do Eloquent
│   ├── Providers/      # Service Providers do Laravel
│   ├── Repositories/   # Camada de acesso aos dados
│   └── Services/       # Regras de negócio da aplicação
├── bootstrap/          # Arquivos de inicialização do Laravel
├── config/             # Configurações da aplicação
├── database/           # Migrations, factories e seeders
├── docker/             # Configurações do ambiente Docker
├── postman/            # Collection e Environment para testes da API
├── public/             # Arquivos públicos e ponto de entrada da aplicação
├── resources/          # Views e outros recursos
├── routes/             # Definição das rotas da API
├── storage/            # Logs, cache e arquivos gerados pela aplicação
├── tests/              # Testes automatizados (Pest)
├── .dockerignore       # Arquivos ignorados durante o build da imagem Docker
├── .env.example        # Exemplo de configuração do ambiente de desenvolvimento
├── composer.json       # Dependências PHP e scripts do Composer
├── docker-compose.yml  # Definição dos serviços Docker da aplicação
├── phpunit.xml         # Configuração da suíte de testes
└── README.md           # Documentação do projeto
```
