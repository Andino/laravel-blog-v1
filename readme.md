
<p  align="center"><img  src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

  

<p  align="center">

<a  href="https://travis-ci.org/laravel/framework"><img  src="https://travis-ci.org/laravel/framework.svg"  alt="Build Status"></a>

<a  href="https://packagist.org/packages/laravel/framework"><img  src="https://poser.pugx.org/laravel/framework/d/total.svg"  alt="Total Downloads"></a>

<a  href="https://packagist.org/packages/laravel/framework"><img  src="https://poser.pugx.org/laravel/framework/v/stable.svg"  alt="Latest Stable Version"></a>

<a  href="https://packagist.org/packages/laravel/framework"><img  src="https://poser.pugx.org/laravel/framework/license.svg"  alt="License"></a>

</p>

  

## Laravel Blog V1 - Installation

- Create a database locally and put the name on the .env file

- Download composer https://getcomposer.org/download/

- Pull this project in your favorite git provider (GithubDesktop, bash, kraken).

- Rename .env.example file to .envinside your project root and fill the database information. (windows wont let you do it, so you have to open your console cd your project root directory and run mv .env.example .env )

- Open the console and cd your project root directory

- Run `composer install` or `php composer.phar install`

- Run `php artisan key:generate`

- Run `php artisan migrate --seed`

- Run `php artisan serve`

  

##### You can now access your project at `localhost:8000` :)

  

If for some reason your project stop working do these:

    composer install

    php artisan migrate

## Points Not Covered

The following requirements doenst have covered on this project `due to time constraints`:

- Filters and Pagination of datatables, we can use the paginate() method in the controller but, we was needing to add the functionality on front, se i've decided to avoid using that method for the moment

- User assignation to the supervisors