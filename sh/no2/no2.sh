apt-get install fail2ban
/etc/init.d/fail2ban restart
apt-get install apache2  php php-pear php-fpm php-dev php-zip php-curl php-xmlrpc php-gd php-mysql php-mbstring php-xml libapache2-mod-php
service apache2 restart
cp validate.php index.php /var/www/html
cp -R PHPOTP /var/www/html
rm /var/www/html/index.html
mkdir /var/www/html/log
chown www-data:www-data /var/www/html/log
cat jail.conf >> /etc/fail2ban/jail.conf
cp wwwku.conf /etc/fail2ban/filter.d

# if error
# sudo a2dismod mpm_event && sudo a2enmod mpm_prefork && sudo a2enmod php7.0