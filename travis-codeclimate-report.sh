#!/usr/bin/env sh

#######################################################
#  This script is intended to be run by TravisCI only #
#######################################################

if [ "$TRAVIS_BRANCH" = "master" ]
then

## Coverage reports should only be sent on master branch

echo "Submitting Test Coverage Report to CodeClimate..."

## Method I

php vendor/bin/test-reporter

## Method II

# php vendor/bin/test-reporter --stdout > codeclimate.json

# curl -X POST -d @codeclimate.json -H 'Content-Type: application/json' -H 'User-Agent: Code Climate (PHP Test Reporter v0.1.1)' https://codeclimate.com/test_reports

else

    echo "Not in Master branch. Will not publish coverage.\n\n"

fi

## Finish

echo Finish with status $?
