# descontonamaquininha
website that compares card machine prices and offers discounts

Este projeto oferece uma plataforma para lojistas que estão procurando maquininhas de cartão com descontos especiais. Através deste site, os usuários podem ver detalhes sobre as maquininhas e acessar links para comprá-las com desconto.

## Funcionalidades

- **Exibição de maquininhas de cartão**: O site apresenta informações sobre as maquininhas disponíveis para compra.
- **Botão de detalhes**: Oferece mais informações sobre cada maquininha ao ser clicado.
- **Links de compra**: Cada maquininha tem um link direto para a página de compra com desconto.
- **Filtro e Busca**: Para pesquisar ou filtrar modelos e operadoras.

## Rodando projeto localmente:
1. Clonar o repositório

bash
```
git clone https://github.com/Nicduso/descontonamaquininha.git
```
2. Mover o projeto para o XAMPP
Copie a pasta clonada para o diretório do XAMPP:

bash
```
C:\xampp\htdocs\
```
Exemplo:

bash
```
C:\xampp\htdocs\descontonamaquininha\
```
3. Instalar o Composer, se ainda não tiver o Composer instalado:

Baixe em: https://getcomposer.org/download

Após instalar, abra o terminal e verifique com:

bash
```
composer --version
```
4. Instalar dependências do projeto
Dentro da pasta do projeto, execute:

bash
```
composer install
```
Isso vai instalar todas as bibliotecas necessárias, incluindo o carregador de variáveis de ambiente.

5. Criar o arquivo .env

Na raiz do projeto, crie um arquivo chamado .env com os dados de conexão do banco:

Código
```
DB_HOST=localhost
DB_USER=root
DB_PASS=senha123
DB_NAME=meubanco
```
Altere os valores conforme sua configuração local.

6. Verificar o Apache e MySQL
Abra o XAMPP Control Panel e certifique-se de que:

✅ Apache está rodando
✅ MySQL está rodando

🌐 7. Acessar o projeto no navegador

Abra o navegador e acesse:

```
http://localhost/descontonamaquininha/
```
Se tudo estiver configurado corretamente, o projeto estará funcionando com conexão ao banco via .env.

## Estrutura do Banco de Dados:
Para rodar o projeto localmente, crie o banco e as tabelas com o seguinte script SQL:
```
-- Criar banco de dados
CREATE DATABASE desconto_na_maquininha;

USE desconto_na_maquininha;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brand VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,
    discount DECIMAL(5,2) NOT NULL,
    link_promo TEXT NOT NULL,
    more_info TEXT NOT NULL,
    photo TEXT NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    user_password VARCHAR(255) NOT NULL
);
```

## Tecnologias Usadas

- HTML
- CSS
- PHP e JavaScript (para interação dinâmica)
- MySQL
- Material Icons (para ícones)
- Hospedagem AWS

## Ideias para atualizações futuras:
- Comparativo de maquinhas/produtos
- Outros produtos (como carteiras e contas digitais)
- Filtro para tipo de produto
- Outros tipos de filtro (preço, data, relevância, etc)
--------------------------------------------------------------------------------------------------------------

This project provides a platform for merchants looking for card machines with special discounts. Through this website, users can view details about the card machines and access links to purchase them at a discounted price.

## Features

- **Display of Card Machines**: The website showcases information about available card machines for purchase.
- **Details Button**: Offers more information about each card machine when clicked.
- **Purchase Links**: Each card machine has a direct link to the discounted purchase page.
- **Filter and Search**: To search or filter models and operators.

## Technologies Used

- HTML
- CSS
- PHP (for dynamic interaction)
- MySQL
- Material Icons (for icons)
- AWS Cloud


## License
This project is licensed under the Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
