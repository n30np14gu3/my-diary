# MY DIARY LAB
## Легенда
> Мы нашли сайт, на котором один известный хакер вел свой дневник. Как думаете, возвожно ли прочитать его секреты?
## Требования
**Laravel**
* PHP >= 7.2.5
* BCMath PHP Extension
* Ctype PHP Extension
* Fileinfo PHP extension
* JSON PHP Extension
* Mbstring PHP Extension
* OpenSSL PHP Extension
* PDO PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Curl PHP Extension

**Доп ПО**
* Composer
* MySql >= 5.5

## Установка и настройка

**Скачайте репозиторий и установите зависимости**
```shell script
$ git clone https://github.com/n30np14gu3/my-diary.git
$ cd my-diary
$ composer install
```
**Настройе .env файл**
```shell script
touch .env
```
```dotenv
APP_NAME=diary
APP_ENV=production
APP_KEY=base64:NX+GBNrf/crsg3zvmURKpGx2Lc9Uk+yF54vA60bc29w=
APP_DEBUG=false
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=diary #change on your db name
DB_USERNAME=root #change on your username
DB_PASSWORD="password" #change on your password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

SEC_GENERATOR_SALT="myPaGgtrOiE0g19NXKZIb1Qkk9Tc9Yvq"
SEC_DEBUG=true #disable on prod!!! (не менять)

```
**Создайте JSON файл для инициализации**
```shell script
$ touch storage/init.json
```
```json
{
    "username": "zer0_hacker",
    "password": "'VwE<)5.]tn)4{{P",
    "note": {
        "title": "My Secret Note",
        "body": "sb{99edc5de3efe96537bf67ab391d1936fa45fa1b0264a7596f6a0bc8a9317c65c}"
    }
}
```
**Инициализируйте приложение**
```shell script
$ php artisan init
```
*Создание лишних заметок*
Для создания дополнительных заметок, передайте опцию ```--trash=true``` 
>  ```php artisan init --trash=true```
>
Для создания дополнительных заметок требуется подключение к сайту [fish-text.ru]

**Запустите локальный сервер**
```shell script
php -S localhost:8000 -t public
```
или
```shell script
php artisan serve
```
или просто настраиваем *APACHE* или *NGINX*

*Конфигурационный файл NGINX*
```
server {
    listen 80;
    server_name example.com;
    root /var/www/html/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

*Конфигурационный файл APACHE (поместить в корень сайта )*
```apacheconfig
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```
[fish-text.ru]: <https://fish-text.ru>
