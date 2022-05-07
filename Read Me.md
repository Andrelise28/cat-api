

O Desafio
Você deverá construir uma API que consulte as raças de gatos, utilizando para isso a
https://thecatapi.com/. O único endpoint que você deverá implementar é o “/breeds”, a
chave para consulta você poderá adquirir através do site da API.


 O desafio foi codificado com auxílio do projeto desenvolvido por Raulino Neto.

```
Ferramentas:

 PHP ,Composer,Slim Framework, MySQL, Phinx 
<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>



OBS: Para a aplicação rodar em localhost deve se ter instalado o composer 

Passos:

Clone o projeto do projeto

Instalar as dependências com o composer  e as classes psr-4  para se fazer o autoload:

 
$ composer install
$ composer dump-autoload



Para o desenvolvimento da Api foi usado o  micro framework Slim. O Slim pode ser instalado via Composer ou fazendo o download do código fonte


$ php composer.phar create-project slim/slim-skeleton [api]

$ cd [api]; php -S localhost:8080 -t public public/index.php



Instalação do phinx pelo composer 


```curl -s https://getcomposer.org/installer | php
php composer.phar require robmorgan/phinx


Para executar o Phinx

vendor/bin/phinx init
vendor/bin/phinx create NewMigration

Um arquivo .yml será criado no diretório raiz da projeto e é nele que você deverá definir o diretório onde serão geradas as migrações, bem como as credenciais de acesso ao banco de dados.

Na linha 2 do arquivo phinx.yml defina o diretório das migrations:

migrations: '%%PHINX_CONFIG_DIR%%/db/migrations'

Copie ``.env.example`` to ``.env``  e configure as credenciais do banco de dados para migrar as tabelas:
 
 
 
