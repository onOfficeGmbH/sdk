# Development image for running the SDK test suite.
#
# Debian-based on purpose: faketime works by LD_PRELOAD-ing libfaketime, which
# needs glibc.
ARG PHP_VERSION=7.4
FROM php:${PHP_VERSION}-cli

# git, zip, unzip -> Composer needs them to install from source / dist
# ncat     -> the fake API server the integration test asserts against.
# faketime -> /usr/bin/faketime, pins the clock so the HMAC is reproducible
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
        git \
        unzip \
        zip \
        ncat \
        faketime \
 && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
