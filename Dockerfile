FROM php:8.1-fpm
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update --fix-missing -y \
        && apt-get upgrade -y \
        && apt-get install -y nano htop procps

RUN apt-get install -y libcurl4-openssl-dev
RUN docker-php-ext-install curl

########## SSL ##########
RUN apt-get install -y --no-install-recommends openssl

RUN apt update

######### Mysql client ######
RUN apt-get install -y default-mysql-client

RUN apt-get install -y --no-install-recommends libzip-dev unzip \
     && docker-php-ext-install zip


# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chmod -R 777 /var/www/html/

#copy ./run.sh /tmp
#ENTRYPOINT ["/tmp/run.sh"]
