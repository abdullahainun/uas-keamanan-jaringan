apt-get install fail2ban
/etc/init.d/fail2ban restart
apt-get install apache2  php php-pear php-fpm php-dev php-zip php-curl php-xmlrpc php-gd php-mysql php-mbstring php-xml libapache2-mod-php
service apache2 restart
cp validate.php index.php /var/www/html
cp -R PHPOTP /var/www/html
rm /var/www/html/index.html