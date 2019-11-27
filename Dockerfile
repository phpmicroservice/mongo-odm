#
# php-phalcon 7.2 Dockerfile
#

FROM php:7.2-apache

MAINTAINER Dongasai 1514582970@qq.com

#更新apt-get源 使用163的源 buster/updates
RUN echo "deb http://mirrors.163.com/debian/ buster main non-free contrib" > /etc/apt/sources.list && \
    echo "deb http://mirrors.163.com/debian/ buster-updates main non-free contrib " >> /etc/apt/sources.list  && \
    echo "deb http://mirrors.163.com/debian/ buster-backports main non-free contrib " >> /etc/apt/sources.list && \
    echo "deb-src http://mirrors.163.com/debian/ buster main non-free contrib " >> /etc/apt/sources.list && \
    echo "deb-src http://mirrors.163.com/debian/ buster-updates main non-free contrib " >> /etc/apt/sources.list && \
    echo "deb-src http://mirrors.163.com/debian/ buster-backports main non-free contrib " >> /etc/apt/sources.list  && \
    echo "deb http://mirrors.163.com/debian-security/ buster/updates main non-free contrib  " >> /etc/apt/sources.list  && \
    echo "deb-src http://mirrors.163.com/debian-security/ buster/updates main non-free contrib " >> /etc/apt/sources.list

# 开启伪静态
RUN a2enmod rewrite;
RUN apt-get update;apt-get install -y git vim wget zip zlib1g-dev libcurl4-openssl-dev pkg-config libssl-dev; 
# 安装常用扩展
RUN docker-php-ext-install pdo pdo_mysql bcmath zip mbstring;docker-php-ext-enable pdo pdo_mysql bcmath zip mbstring;
RUN apt-get install -y \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
	&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install gd
	
RUN pecl install redis && docker-php-ext-enable redis 
RUN apt-get install -y libmemcached-dev zlib1g-dev 
RUN pecl install memcached && docker-php-ext-enable memcached
# pecl install inotify
RUN pecl install inotify \
    && docker-php-ext-enable inotify
# pecl install mongodb
RUN pecl install mongodb && docker-php-ext-enable mongodb

# 安装 composer
RUN wget https://mirrors.aliyun.com/composer/composer.phar;chmod +x composer.phar; mv composer.phar /usr/local/bin/composer;
RUN composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/

# 下载phpunit
RUN wget https://phar.phpunit.de/phpunit-7.phar;chmod +x phpunit-7.phar;mv phpunit-7.phar /usr/local/bin/phpunit

#重置工作目录
WORKDIR /var/www/html