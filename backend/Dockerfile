#FROM yiisoftware/yii2-php:7.4-apache
FROM yiisoftware/yii2-php:7.4-fpm

# Change document root for Apache
#RUN sed -i -e 's|/app/web|/app/backend/web|g' /etc/apache2/sites-available/000-default.conf

# Добавляем наш конфиг
ADD /docker/default.conf /etc/nginx/sites-available/default.conf
ADD /docker/ /etc/nginx/sites-enabled/
# Включаем его
RUN ln -s -f /etc/nginx/sites-available/default.conf /etc/nginx/sites-enabled/default.conf

EXPOSE 80