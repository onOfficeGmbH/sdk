# Development image for running the SDK test suite.
#
# Debian-based on purpose: faketime works by LD_PRELOAD-ing libfaketime, which
# needs glibc.
ARG PHP_VERSION=7.4
FROM php:${PHP_VERSION}-cli

# git, zip, unzip -> Composer needs them to install from source / dist
# ncat     -> the fake API server the integration test asserts against.
# faketime -> /usr/bin/faketime, pins the clock so the HMAC is reproducible
RUN sed -i \
        -e 's|deb.debian.org/debian-security|archive.debian.org/debian-security|' \
        -e 's|deb.debian.org/debian|archive.debian.org/debian|' \
        -e '/bullseye-updates/d' \
        /etc/apt/sources.list \
 && apt-get update \
 && apt-get install -y --no-install-recommends \
        git \
        unzip \
        zip \
        ncat \
        faketime \
 && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
