#!/bin/bash

main() {
    if [ "$IS_WORKER" = "true" ]; then
        exec "$@"
    else
        prepare_file_permissions
        prepare_storage
        wait_for_db
        run_migrations
        optimize_app
        run_server "$@"
    fi
}

prepare_file_permissions() {
    chmod a+x ./artisan
}


prepare_storage() {
#    mkdir -p /usr/share/nginx/html/storage/framework/cache/data
#    mkdir -p /usr/share/nginx/html/storage/framework/sessions
#    mkdir -p /usr/share/nginx/html/storage/framework/views

#    chown -R www-data:www-data /usr/share/nginx/html/storage
#    chmod -R 775 /usr/share/nginx/html/storage
    echo "Checking if storage link exists"
    if [ ! -L /var/www/app/public/storage ]; then
        echo "Symlink not found, creating storage link"
        cd /var/www
        php artisan storage:link
    else
        echo "Storage symlink already exists"
    fi
    }

wait_for_db() {
    echo "Waiting for DB to be ready"
    until ./artisan migrate:status 2>&1 | grep -q -E "(Migration table not found|Migration name)"; do
        sleep 1
    done
}

run_migrations() {
    ./artisan migrate --no-interaction --force
}

optimize_app() {
    ./artisan optimize:clear
    ./artisan optimize
    ./artisan route:clear
    ./artisan cache:clear
}

run_server() {
    exec /usr/local/bin/docker-php-entrypoint "$@"
}

main "$@"
