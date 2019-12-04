FROM ubuntu:latest

ARG DEBIAN_FRONTEND=noninteractive

RUN apt update && \
    apt install -y \
           build-essential \
           libprotobuf-dev \
           libboost-dev \
           openssl \
           protobuf-compiler \
           php7.2-cli php7.2-dev php7.2-mysql php7.2-pdo php7.2-xml composer php-mbstring \
           unzip

RUN pecl install mysql_xdevapi && \
    echo "extension=mysql_xdevapi.so" > /etc/php/7.2/mods-available/mysql_xdevapi.ini && \
    echo "extension=mysql_xdevapi.so" > /etc/php/7.2/cli/conf.d/mysql_xdevapi.ini

RUN mkdir -p /var/www/html

COPY assets/run.sh / 
RUN chmod a+x /run.sh

ENTRYPOINT ["./run.sh"]