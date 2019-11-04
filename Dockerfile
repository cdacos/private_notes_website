FROM php:fpm

# Match UID and GID with local user (assuming 1000:1000, but change accordingly)
RUN \
   usermod -u 1000 www-data && \
   groupmod -g 1000 www-data
