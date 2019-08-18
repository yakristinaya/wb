# Requirements
* PHP  v7.1.9
* docker

# Installation
* `php ./composer.phar install --prefer-dist --optimize-autoloader`

# Run
* `docker run -p 4444:4444 selenium/standalone-chrome-debug:3.8`
* `php ./vendor/bin/codecept run --steps`
