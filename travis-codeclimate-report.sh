#!/usr/bin/env sh

#######################################################
#  This script is intended to be run by TravisCI only #
#######################################################

php vendor/bin/test-reporter --stdout > codeclimate.json

curl -X POST -d @codeclimate.json -H 'Content-Type: application/json' -H 'User-Agent: Code Climate (PHP Test Reporter v0.1.1)' https://codeclimate.com/test_reports
