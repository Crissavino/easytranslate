## Initialization

- First install all the dependencies running *composer install*. <br>
Using Laravel Sail for docker
- Copy .env.example in .env
- Generate the laravel key with **php artisan key:generate**
- Run **php artisan sail:install**
- Then run <b>docker</b> with *./vendor/bin/sail up*
- In .env in the variable **FIXER_ACCESS_KEY** add the access key for the Fixer.io.
- Access to the docker: run **docker ps** command to get the name of the app container and then **docker exec -it *CONTAINER_NAME* bash**
- Then inside the docker clean config, cache, and routes to be sure with **php artisan config:clear php artisan cache:clear php artisan routes:clear**
- Run migration with **php artisan migrate**


## Testing
- To run the test just run **php artisan test --testsuite=Unit**
