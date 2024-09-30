# Vue3 + Laravel8
 
 Перед продожлением запуска приложения необходимо установить следующее ПО:
 Composer,
 Node.js,
 Mysql (or you)


# Развертывание:
    cd backend
    composer i

    Создать файл env. с параметрами:
       APP_KEY=
       APP_ENV=local
       DB_CONNECTION=mysql // or you
       DB_HOST=127.0.0.1 // or you
       DB_PORT=3306 // or you
       DB_DATABASE=laravel // or you
       DB_USERNAME=root // or you
       DB_PASSWORD= // or you

    php artisan key:generate
    php artisan migrate --seed

    cd ..
    cd frontend
    npm i


# Запуск:
 Бэк:
    php artisan serve
 
 Фронт:
    npm run dev