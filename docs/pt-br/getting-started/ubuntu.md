# Instalação Manual no Ubuntu 14.04

## PHP

Comece instalando o PHP e suas dependências:

```bash
sudo apt-get install -y php-5 php5-pgsql php5-mcrypt
```

## NodeJS

Em seguida instale o NodeJS:

```bash
curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -
sudo apt-get install -y nodejs
sudo apt-get install -y build-essential
```

## PostgreSQL

Por fim a instalação do PostgreSQL:

```bash
sudo apt-get install -y postgresql
```

A versão padrão é a 9.3, mas é possível instalar versões mais recentes. Para isso
basta baixar o instalador do site
<http://www.enterprisedb.com/products-services-training/pgdownload#linux>.

Baixe o instalador de acordo com sua arquitetura, ou seja, 32 ou 64 bits.
Após baixar a instalação é feita da seguinte forma (supondo que a versão
tenha sido a 9.5.4-1 para Ubuntu 64 bits):

```bash
chmod u+x postgresql-9.5.4-1-linux-x64.run
sudo ./postgresql-9.5.4-1-linux-x64.run
```

Siga as instruções de instalação que a ferramenta irá indicar.

## Wireless Monitor

Baixe uma versão da página <https://github.com/SanUSB-grupo/wireless-monitor/releases>.

Os comandos abaixo servem para a instalação da versão 1.0.0 (para outras versões
modifique apenas a numeração):

```bash
curl -LkO "https://github.com/SanUSB-grupo/wireless-monitor/archive/1.0.0.tar.gz"
tar xzf 1.0.0.tar.gz
cd wireless-monitor-1.0.0/
curl -O "https://getcomposer.org/composer.phar"
php composer.phar install
cp .env.example .env
```

Edite o arquivo `.env` informando os dados de sua conexão com o PostgreSQL.

```bash
php artisan key:generate
php artisan jwt:generate
npm install
npm run tests:travis-bower
npm run tests:travis-gulp
php artisan migrate
```

Para executar o servidor:

```bash
php artisan serve
```

Por padrão um servidor HTTP será iniciado na porta 8000. Para visualizar
abra um navegador na URL <http://localhost:8000>.
