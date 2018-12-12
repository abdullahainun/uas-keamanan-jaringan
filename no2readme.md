Skenario
password management

+ pada saat melakukan kesalahaan pada login yang terdiri dari username password dan otp, maka saat terjadi kesalahan 3 kali
  - blokir ip address pengguna selama 5 menit (40%)
  - selama ip terblokir pengguna atau penyerang mendapat informasi bahwa ip terblokir, misal di infokan dengan maaf akses kami terblokir "silahkan tunggu 5 menit lagi" (60 - 100%)

Tutorial 
Berdasarkan soal di atas, maka kita dapat menyelesaikannya dengan beberapa aplikasi seperti fail2ban sebagai firewall, apache2 dan php sebagai web server, library php otp sebagai authentikasi dan ssmtp untuk mengirim email. untuk itu silahkan ikuti step by step berikut. 

# point 1
1. install aplikasi pendukung
``bash
    apt-get install fail2ban apache2 php-pear php-fpm php-dev php-zip php-curl php-xmlrpc php-gd php-mysql php-mbstring php-xml libapache2-mod-php
``
2. restart service yang sudah terinstall
`/etc/init.d/fail2ban restart && service apache2 restart`

3. Membuat halaman login php otp sederhana 
`rm /var/www/html/index.html`
`cp -R PHPOTP /var/www/html`
salin file untu login ke /var/www/html dengan perintah berikut 
`cp index.php validate.php /var/www/html`
`chown www-data:www-data /var/www/html/validate.php`
`chmod 777 /var/www/html/validate.php`
edit username dan password 
`nano index.php`
membuat file log yang digunakan untuk pengecekan ip yang gagal login
`mkdir /var/www/html/log`
`touch /var/www/html/log/report`
`chown www-data:www-data /var/www/html/log`
`chmod 777 /var/www/html/log/report`

4. mengatur filtering fail2ban 
`cat jail.conf >> /etc/fail2ban/jail.conf`
`cp wwwku.conf /etc/fail2ban/filter.d`
`systemctl restart fail2ban`

5. cek login phpotp anda dengan cara kunjungi `http://ip-address/index.php`
pada tahap ini pastikan anda sudah menginstall google authenticator dan 
silahkan masukkan username dan password yang sudah di set pada halam login, pada percobaan 1 akan terjadi pengecekan yang salah. kemudian baca qrcode dengan google authenticator dan anda akan mendapatkan kode otp yang berganti secara dinamis.  kunjungi web login anda sekali lagi. gunakan username, password dan kodeotp dari google authenticator. bila benar akan mucul valid code. 
sekarang lakukan percobaan selama `3 kali` login gagal. bila percobaan ke 4 gagal maka akan muncul halaman `connection refused` selama 5 menit

# point 2
6. alert informasi dengan dengan redirect

# konfigurasi virtual host

tambah port pada file /etc/apache2/ports.conf
tambahkan `Listen 8080`
buat folder untuk virtualhost baru
```bash   
    mkdir /var/www/html/firewall
    touch /var/www/html/firewall/index.php
    chown -R www-data:www-data /var/www/html/firewall/
    chmod -R 755 /var/www/html
    cd /etc/apache2/sites-available/
    cp 000-default.conf firewall.conf
    sudo a2ensite firewall.conf
    sudo service apache2 reload
```
edit halaman halaman warning 
```bash
    nano /var/www/html/firewall/index.php
```
kemudian isikan sesuai keinginan anda

```php
    <?php echo "Maaf akses anda di blokir selama 5 menit"; ?>
```

# setup portforwarding dengan iptables

3. # vim /etc/fail2ban/jail.conf





