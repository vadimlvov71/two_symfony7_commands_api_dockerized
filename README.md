####  Symfony7 with microservice commands cli and website with crud
##### About The Project 

Create two applications using Symfony5 (or 6/7) framework:
1. server with API entries
2. client
1. Server stores users and groups in MySQL database.
user table: id, name, email
group table: id, name
2. Client accessing the server through the API using CLI:
  2.1. should be able to add, edit, delete users and groups on the server (well, CRUD)
  2.2 should be able to get report with the list of users of each group.
The ready-made project should be able to start using Docker. 
##### Built With
*  docker
*  services: two php 8.2, mysql, nginx
*  both php have: symfony 7
##### Installation
1. Clone the repo
2. server container entry:
 ```sh
docker exec -it php_microservices_server bash
  ```
project install:
 ```sh
composer install
  ```
 #create database
  ```sh
 php bin/console doctrine:database:create
 ```
  create migration:
```sh
php bin/console doctrine:migrations:migrate
```
create fixture:
```sh
php bin/console doctrine:fixture:load
```
3. client container entry:
 ```sh
docker exec -it php_microservices_client bash
  ```
 ```sh
composer install
  ```
4. commands cli magic:
    ```sh
composer install
  ```
