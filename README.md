# Тестовое задание Helastel

## Документация по api
https://documenter.getpostman.com/view/1752603/TVYGdJgE#cc2ee0e2-23f2-4365-9697-2d0be871a7a1
https://documenter.getpostman.com/view/1752603/TzCP8oEr
использовал php 7.4

laravel 8.*

### Порядок установки

#### Backend
- composer install
- меняем .env.example на .env
- в файле .env прописываем конфиги
- Генерируем ключ php artisan key:generate
- выполнить миграцию php artisan migrate
- выполнить php artisan passport:install для генерации токена
- дальше использовать frontend приложение и postman для получения всех записей из указанного источника данных.

#### Frontend
- npm install
- изменить в nuxt.config.js base url на нужный сервер (пока не стал делать это через env)
- npm run dev

### Что нужно сделать:
 - Реализовать API на языке PHP для: сохранения записей в указанный источник данных (только для авторизованного пользователя) получения всех записей из указанного источника данных. 
   Допускается использовать любой фреймворк (или без его использования), любую БД, кэш.
 - Реализовать frontend клиент (VueJs или Nuxt) с формой добавления
   пользователя. Способ авторизации на ваше усмотрение
### Возможные действия:
- Реализовать API на языке PHP - 3 часа
- Реализовать frontend клиент (VueJs или Nuxt) - 3 часа

Общее время на выполнение вышло 6 часов
