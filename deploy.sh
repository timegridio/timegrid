#!/bin/bash

function deploy() {
    # make sure we pull master branch for production environment
    BRANCH=$([ $1 == "production" ] && echo "master" || echo "development")

    echo "Starting deployment on <$1> environment"

    echo "Pulling $BRANCH branch..."
    php artisan down
    git pull origin ${BRANCH}
    APP_VERSION=`git describe --always`
    sed -i -r "s/APP_VERSION=.*/APP_VERSION=${APP_VERSION}/" .env
    composer install
    php artisan migrate --env=$1
    php artisan up
}

function help() {
    echo ""
    echo "   Please specify on what environment you want to deploy: "
    echo "   ./deployment.sh env"
    echo ""
}
## If no argument supplied
if [ -z "$1" ]; then
    echo "No arguments supplied"
fi

## If wrong number of argument has been supplied
if [ ! $# == 1 ]; then
    help $#
else
    # We can deploy only on staging and production
    if [ $1 == 'development' ] || [ $1 == 'production' ]; then
        deploy $1
    fi
fi