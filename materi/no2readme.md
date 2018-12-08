skenario
password management
- pada saat melakukan kesalahaan pada login yang terdiri dari username password dan utp, maka saat terjadi kesalahan 3 kali
    + blokir ip address pengguna selama 5 menit (40%)
    + selama ip terblokir pengguna atau penyerang mendapat informasi bahwa ip terblokir, misal di infokan dengan maaf akses kami terblokir "silahkan tunggu 5 menit lagi" (60 - 100%)

apt-get install fail2ban
/etc/init.d/fail2ban restart 
apt install apache2  php-pear php-fpm php-dev php-zip php-curl php-xmlrpc php-gd php-mysql php-mbstring php-xml libapache2-mod-php

service apache2 restart


mkdir /var/www/html/log
chown www-data:www-data /var/www/html/log
edit /etc/fail2ban/jail.conf

[www]
