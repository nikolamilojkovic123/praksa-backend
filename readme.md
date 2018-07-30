## Realtime tic-tac-toe
Laravel application, for training purposes only.

#### Getting Started

These instructions will get you a copy of the project on your local machine for development and testing purposes. Make sure you set up vhost correctly, using AllowOverride All, and route it to /public folder.

##### Prerequisites

    PHP >= 7.1.3
    OpenSSL PHP Extension
    PDO PHP Extension
    Mbstring PHP Extension
    Tokenizer PHP Extension
    XML PHP Extension
    Ctype PHP Extension
    JSON PHP Extension

##### Installing

    1. Clone repository to your local machine
    2. Make sure you have mod_rewrite activated on your server / in your environment
    3. Copy .env.example file and rename it to .env
    4. Create new database, and edit the database credentials in .env
    5. Type following commands in terminal pointing to corresponding folder
        - composer install
        - php artisan key:generate
        - php artisan migrate --seed
    6. Register or login by hitting corresponding endpoints

##### Functionalities

    * Registration and login system
    * TBA