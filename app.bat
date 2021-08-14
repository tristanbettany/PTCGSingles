@ECHO OFF

FOR /f "delims== tokens=1,2" %%G IN (.env) DO SET %%G=%%H

CALL :CASE_%1
IF ERRORLEVEL 1 CALL :DEFAULT_CASE

ECHO Done!
EXIT /B

:CASE_remove
    ECHO Removing...
    docker-compose down -v
    GOTO END_CASE

:CASE_rebuild
    ECHO Removing...
    docker-compose down -v
    ECHO Building...
    docker-compose up -d --build
    GOTO END_CASE

:CASE_build
    ECHO Building...
    docker-compose up -d --build
    GOTO END_CASE

:CASE_restart
    ECHO Stopping...
    docker-compose down
    ECHO Starting...
    docker-compose up -d
    GOTO END_CASE

:CASE_stop
    ECHO Stopping...
    docker-compose down
    GOTO END_CASE

:CASE_start
    ECHO Starting...
    docker-compose up -d
    GOTO END_CASE

:CASE_install
    ECHO Removing temporary application files...
    @RD /S /Q "vendor"
    @RD /S /Q "node_modules"
    ECHO Installing composer dependencies...
    docker container exec -w /www php composer install
    ECHO Installing npm dependencies...
    docker container exec -w /www node npm install
    GOTO END_CASE

:CASE_update
    ECHO Updating composer dependencies...
    docker container exec -w /www php composer update
    GOTO END_CASE

:CASE_dump
    ECHO Dumping autoload...
    docker container exec -w/www php composer dump-autoload
    GOTO END_CASE

:CASE_laravel-key
    ECHO Generating Key...
    docker container exec -w /www php php artisan key:generate
    GOTO END_CASE

:CASE_web-stop
    ECHO Stopping Nginx...
    docker-compose stop nginx
    GOTO END_CASE

:CASE_web-start
    ECHO Starting Nginx...
    docker-compose start nginx
    GOTO END_CASE

:CASE_web-restart
    ECHO Re-starting Nginx...
    docker-compose stop nginx
    docker-compose start nginx
    GOTO END_CASE

:CASE_bash
    docker container exec -it -w /www php bash
    GOTO END_CASE

:CASE_bash-node
    docker container exec -it -w /www node bash
    GOTO END_CASE

:CASE_migrate-up
    ECHO Migrating Up...
    docker container exec -w /www php php artisan migrate
    GOTO END_CASE

:CASE_migrate-down
    ECHO Migrating Down...
    docker container exec -w /www php php artisan migrate:rollback
    GOTO END_CASE

:CASE_seed
    ECHO Seeding...
    docker container exec -w /www php php artisan db:seed
    GOTO END_CASE

:CASE_reset-db
    ECHO Reseting database...
    docker container exec -w /www php php artisan migrate:fresh
    GOTO END_CASE

:DEFAULT_CASE
    ECHO Unknown function %1
    GOTO END_CASE
:END_CASE
    GOTO :EOF
