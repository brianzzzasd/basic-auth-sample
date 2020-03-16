## Installation
#### Run these commands

- ```composer install```
- ```php artisan migrate```
- ``` php artisan passport:install```


#### Endpoints
- ```/api/register```
    ##### Params
    ```name```                  - required
    
    
    ```email```                 - required
    
    
    ```password```              - required
    
    
    ```password_confirmation``` - required
    
-----
    
- ```/api/login```
    ##### Params 
    ```email```    - required
    
    
    ```password``` - required
    
-----
    
- ```/api/auth-user```
    ##### Details 
    - To Check authenticated user. Authentication Bearer token neeeds to be passed on header.
    

    
