# Wireless Monitor

Aplicativo web para receber e mostrar dados vindos de equipamentos IOT.

Web app to receive and show data that comes from IOT devices.

## Documentation

<https://sanusb-grupo.github.io/wireless-monitor/>

## Getting Started

Install composer from <getcomposer.org>

Install dependencies

~~~bash
php composer.phar install
~~~

Create `.env` file

~~~bash
cp .env.example .env
~~~

Generate key for JWT

~~~bash
php artisan key:generate
~~~

Migrate database (first time only)

~~~bash
php artisan migrate
~~~

Start the local server

~~~bash
php artisan serve
~~~

## License

Copyright (C) 2016 Átila Camurça <camurca.home@gmail.com>

Grupo SanUSB <http://sanusb.org>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
