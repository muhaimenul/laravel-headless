<h1 align="center"><a href="https://github.com/muhaimenul/import-csv.git" target="_blank">Laravel Demo</a></p>

## About Project

This is a demo laravel project. Providing various features implementation.

## Dependency and Requirements

Below environmental dependency is required for the project:

```
php: "^7.3|^8.0"
laravel: "^8", file: "composer.json"
node: "~> 16.3.0", file: "package.json"
npm: "~> 7.15.1"
composer
vuejs 3
```

###Note: To upload large size file, `upload_max_filesize` and `post_max_size` limit in the php.ini file need to be changed according to the preferred file size.


## Installation

Steps to install and run the project:

```php 

git clone https://github.com/muhaimenul/import-csv.git
cd import-csv
composer install

```

To setup environment, `cp env.example .env` then provide database name and credentials.

then, 

```php 

npm install && npm run dev
php artisan config:cache
php artisan migrate
php artisan serve
php artisan queue:listen
npm run watch

```


Then visit `http://localhost:8000/` to use the system.

### Author

-   [Muhaimenul Islam](https://github.com/muhaimenul)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
