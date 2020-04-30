# MY DIARY LAB

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

**Запустите локальный сервер**
```shell script
php -S localhost:8000 -t public
```
или
```shell script
php artisan serve
```
или просто настраиваем *APACHE* или *NGINX*
