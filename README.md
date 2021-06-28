<h1 align="center"><a href="https://github.com/muhaimenul/import-csv.git" target="_blank">CSV File Importer</a></p>

## About Project

This application provides, import data from CSV file. Form backend PHP, Laravel is a web application framework is used. For frontend, VueJS framweork is used. Laravel provides VueJS ui scaffolding to develop frontend client.

An efficient system where it accepts a CSV file and import (Laravel) all rows into a database table. The file needs is uploaded via an user interface (VueJs) where a user can upload the file. Users are able to also see the status of the uploaded file.

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
