# rest_service
test_task

INSTALL

git clone https://github.com/melfis55/rest_service.git

composer install

rename .env.example to .env

set database connection in .env

php artisan key:generate

php artisan migrate

php artisan serve

request: 127.0.0.1:8000/userinfo/add

body: {"firstname":"Vasea", "lastname": "Pupkin", "country": "Ukraine", "city": "Odessa", "street": "kanatna"}

query: 127.0.0.1:8000/userinfo/get/{firstname}/{lastname}

response: {"status": 200, "firstname":"Vasea", "lastname": "Pupkin", "country": "Ukraine", "city": "Odessa", "street": "kanatna"}

