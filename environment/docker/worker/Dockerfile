FROM webdevops/php:8.2-alpine

LABEL maintainer="marcos.marcelo43@gmail.com"

RUN docker-service-enable cron

COPY config/horizon.conf /opt/docker/etc/supervisor.d/horizon-worker.conf

RUN echo "* * * * * /usr/local/bin/php /app/artisan schedule:run >> /dev/null 2>&1" >> /etc/crontabs/root

WORKDIR /app