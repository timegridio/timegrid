#!/usr/bin/env sh

#######################################################
#  This script is intended to be run by TravisCI only #
#######################################################

echo "Submitting Test Coverage Report to CodeClimate..."

BRANCH=$(git branch | sed -n -e 's/^\* \(.*\)/\1/p')

# Only publish coverage to CodeClimate if the current branch is Master branch

if [ "$BRANCH" == "master" ]
then

    php vendor/bin/test-reporter --stdout > codeclimate.json

    curl -X POST -d @codeclimate.json -H 'Content-Type: application/json' -H 'User-Agent: Code Climate (PHP Test Reporter v0.1.1)' https://codeclimate.com/test_reports

    echo Finish with status $?

else
    echo "Not in Master branch. Will not publish coverage.\n\n"
fi
