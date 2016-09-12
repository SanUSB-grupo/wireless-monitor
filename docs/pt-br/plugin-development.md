# Desenvolvimento de Plugins

O Wireless Monitor utiliza a framework [Laravel](https://laravel.com/) (5.2).
Para a criação de um plugin é necessário criar um
[Package](https://laravel.com/docs/5.2/packages) do Laravel.

## Criação de um Package

No terminal, dentro do diretório do projeto, execute o comando:

~~~bash
gulp create-plugin --vendor <vendor> --plugin <plugin>
~~~

Troque `<vendor>` pelo nome do desenvolvedor ou empresa, ex. `sanusb`,
e `<plugin>` pelo nome do plugin, ex. `temperature`.

## Estrutura de diretórios

A estrutura de diretórios ficará da seguinte forma:

~~~
packages/sanusb/temperature/
├── composer.json
├── phpunit.xml
├── src
│   ├── assets
│   │   ├── components
│   │   │   └── temperature.js
│   │   └── templates
│   │       └── temperature
│   │           ├── index.mustache
│   │           └── show.mustache
│   ├── Http
│   │   └── Controllers
│   │       └── TemperatureController.php
│   ├── migrations
│   │   └── insert_temperature_monitor.php
│   ├── Providers
│   │   └── TemperatureServiceProvider.php
│   ├── storage
│   │   └── json-schema
│   │       └── temperature.json
│   └── views
│       └── save.blade.php
└── tests
    ├── controllers
    │   └── TemperatureControllerTest.php
    └── migrations
        └── DatabaseTest.php
~~~

### Arquivos

No arquivo `src/Http/Controllers/TemperatureController.php` é necessário
a implementação dos métodos:

* `create` - configura e chama a página para adicionar novo monitor
* `store` - valida e guarda os dados no banco

No arquivo `src/views/save.blade.php` é preciso indicar os campos
que estarão presentes no Monitor. A alteração impacta diretamente
no método `store` citado anteriormente.

No arquivo `src/migrations/insert_temperature_monitor.php` é necessário
apenas indicar qual o ícone do Monitor. O sistema usa o conjunto de ícones
customizado com a ferramenta [IcoMoon](https://icomoon.io/app). No diretório
`custom-fonts` existe um arquivo `selection.json` que pode ser importado
no IcoMoon para adicionar novas fontes. As fontes são desenvolvidas usando
arquivos SVG. Caso não tenha uma fonte você pode escolher um já disponível
no site.

Após salvar o monitor é necessário editar o arquivo que o apresenta na lista
de Monitores do usuário. O arquivo `src/assets/templates/temperature/index.mustache`
é o template para um item da lista (URL: `/monitor`).

Os detalhes do Monitor são mostrados usando o arquivo
`src/assets/templates/temperature/show.mustache` (URL: `monitor/{id}`).

Mais detalhes sobre a sintaxe do Mustache em:

* <https://github.com/janl/mustache.js>

A indicação do formato dos dados que o usuário deve enviar fica definido em
`src/storage/json-schema/temperature.json`. Mais detalhes sobre a validação
com JSON Schema em:

* <http://json-schema.org/>
* <http://json-guard.thephpleague.com/>

## Habilitar Novo Plugin

**OBS:** esse procedimento no futuro deve ser automatizado, quando os packages
virarem dependências do composer!

Edite o arquivo `composer.json` do diretório raiz do sistema, e adicione a linha
`"Sanusb\\Temperature\\": "packages/sanusb/temperature/src/"` na seção `autoload`:

~~~json
"autoload": {
    "classmap": [
        "database"
    ],
    "psr-4": {
        "App\\": "app/",
        "Sanusb\\Temperature\\": "packages/sanusb/temperature/src/"
    }
},
~~~

Em seguida edite o arquivo `app/Http/routes.php` e adicione a linha:

~~~php
<?php
/* ... */
Route::resource('temperature', '\Sanusb\Temperature\Http\Controllers\TemperatureController');
~~~

abaixo de `Route::auth();`, para que somente usuários logados possam ver.

Além disso é necessário informar o Provider em `config/app.php`, na seção `providers`:

~~~php
'providers' => [
    /* ... */
    Sanusb\Temperature\Providers\TemperatureServiceProvider::class,
]
~~~

Ao final temos recarregar as configurações do composer, executando:

~~~
php composer.phar dump-autoload -o
php artisan vendor:publish --provider="Sanusb\Temperature\Providers\TemperatureServiceProvider"
php artisan migrate
~~~

## Desenvolver o plugin

Inicie o servidor php:

`php artisan serve`

Em outro terminal inicie o `gulp` para verificar e atualizar as alterações
feitas em arquivos `.js`, `.css`, `.mustache`:

`gulp watch`

## Testar o plugin

Os testes são feitos usando a ferramenta [PHPUnit](https://phpunit.de/).
Para executar:

`./vendor/bin/phpunit packages/vendor/plugin/`

Substituindo `vendor` e `plugin` para seus respectivos valores.
