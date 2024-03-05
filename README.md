**Для запуска проекта должен быть установлен docker и docker-compose**

**Клонируем проект**

`git clone https://github.com/NikitaPilez/text-magic`

**Переходим в директорию**

`cd text-magic`

**Билд докера**

`docker-compose build`

**Поднимаем сервисы**

`docker-compose up -d` (либо можно использовать без флага -d, тогда в консоли можно будет увидеть логи, а последующие команды выполнять в отдельной консоли)

**Устанавливаем зависимости**

`docker exec -it php composer i`

**Накатываем миграции**

`docker exec -it php php bin/console doctrine:migrations:migrate`

**Накатываем sql скрипт для наполнения первоначальными данными в проект**
`docker exec -it pg psql -U admin -d test_db -f ./docker-entrypoint-initdb.d/init.sql`

**Открываем в браузере** [проект](http://localhost:8080/quiz)

**Для того чтоб остановить работу с контейнерами следует выполнить**

`docker-compose down`