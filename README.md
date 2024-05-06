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
create fixture: TODO can`t add assosiation so users added without foreign keys
```sh
#php bin/console doctrine:fixture:load
```
3. client container entry:
 ```sh
docker exec -it php_microservices_client bash
  ```
 ```sh
composer install
  ```
4. commands cli magic:
     1) create a group without validation
        ```sh
          php api-cli group/new Group4
        ```
        update a group: "group/update" "numberOfGroupBeUdated" "newName"  without validation
        ```sh
          php api-cli group/update 1  Group4
        ```
     2) create a user with validation: "user/new" "UserName" "GroupName"
      ```sh
          php api-cli user/new John john@ffff.com Group1
        ```

![изображение](https://github.com/vadimlvov71/two_symfony7_commands_api_dockerized/assets/57807117/979ecb7a-41b5-456e-b1a0-d02b82e61fc8)

5. validation for example: that user with this email has been existed yet
![изображение](https://github.com/vadimlvov71/two_symfony7_commands_api_dockerized/assets/57807117/fee0e29c-b065-45eb-83c6-87d84a882056)
6. List of users grouped by groups:
  ```sh
      php api-cli user/list
  ```
![изображение](https://github.com/vadimlvov71/two_symfony7_commands_api_dockerized/assets/57807117/129cf179-47ac-4804-ac13-db60646a65e5)

   

