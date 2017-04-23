FROM php:7.1
RUN apt-get update
RUN apt-get install -y git unzip fontconfig bzip2 zlib1g-dev libxml2-dev
RUN docker-php-ext-install pdo_mysql mbstring zip xml
RUN curl https://getcomposer.org/composer.phar -o /bin/composer && chmod +x /bin/composer


# Setup dependencies for browser tests
RUN curl -L -o phantomjs.tar.bz2 'https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-linux-x86_64.tar.bz2' && \
    tar xjpf phantomjs.tar.bz2 && \
    cp phantomjs-2.1.1-linux-x86_64/bin/phantomjs /bin/ && \
    rm -Rf phantomjs-2.1.1-linux-x86_64

# Add a non-root user to prevent files being created with root permissions on host machine.
ARG PUID=1000
ARG PGID=1000
RUN groupadd -g $PGID laravel && \
    useradd -u $PUID -g laravel -m laravel

# Copy the code and install dependencies for faster rebuilds
COPY . /code
WORKDIR /code
RUN chown -R laravel:laravel .
USER laravel
RUN composer install
