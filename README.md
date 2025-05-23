<h1 align="center">AdsControl</h1>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySql-4479A1.svg?style=for-the-badge&logo=mysql&logoColor=white"/>
  <img src="https://img.shields.io/badge/Xampp-FF8800?style=for-the-badge&logo=xampp&logoColor=white"/>
  
</p>

## Sobre o App
AdsControl é um sistema desenvolvido para a A3 das aulas do Professor Felipak da UniCuritiba. Ele tem o intuito de ser um gerenciador de anuncios.

## Sobre a Arquitetura do App
Desenvolvido usando:
- PHP
- XAMPP
- MySQL


### Orientações
1. Antes de rodar o sistema, verifique se o MySql e o XAMPP estão rodando corretamente
2. Ao iniciar o MySQL rode o script de inicialização da estrutura do banco que esta em `db/init.sql`
3. Coloque os arquivos do projeto dentro de `htdocs` no `XAMPP`

#### Sobre as telas:
- Todas as telas estão dentro da pasta `app`
- Telas de login e cadastro estão dentro da pasta `app/auth`

#### Em caso de problemas de conexão com o banco de dados:
1. Verifique as credenciais de acesso ao banco de dados da sua maquina, no projeto utilizamos o padrão do XAMPP:
 - User: root
 - Senha: Senha vazia

2. Caso suas credenciais de acesso sejam diferentes, mudar nos campos do arquivo para o valor do banco da sua máquina local: `persistence/database.php`
```php
  private static $host = 'localhost';
  private static $db = 'avaliacao';
  private static $user = 'root';
  private static $pass = '';
```



