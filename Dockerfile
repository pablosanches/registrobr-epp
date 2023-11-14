FROM php:8.2-cli-alpine
WORKDIR /app

RUN apk update && apk upgrade --no-cache && apk add --no-cache  \
    bash \
    vim \
    git  \
    unzip  \
    zlib-dev

# Instalando o composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer