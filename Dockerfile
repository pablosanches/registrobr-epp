FROM php:8.2-cli-alpine
WORKDIR /app

RUN apk update && apk upgrade --no-cache && apk add --no-cache  \
    git  \
    unzip  \
    zlib-dev

