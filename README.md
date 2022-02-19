## Intricare Demo Test
This is made up on Laravel and it is test application given as part of interview selection.
This project contains CRUD operations using AJAX.


## Installation steps
After taking latest pull, you will require to install composer components for this:

    composer install
Once it is done, generate `.env` file from `.env.example` file
    
    cp .env.example .env
    
Now, you need to generate application key
    
    php artisan key:generate
    
Next step is for database configurations. Once you configure your database, run migrations
    
    php artisan migrate
    
It is all set to test app now. You can use it and check using 
    
    php artisan serve
