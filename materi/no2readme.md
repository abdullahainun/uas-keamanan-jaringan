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
edit username dan password 
`nano index.php`
salin file untu login ke /var/www/html dengan perintah berikut 
`cp index.php validate.php /var/www/html`
membuat file log yang digunakan untuk pengecekan ip yang gagal login
`mkdir /var/www/html/log`
`touch /var/www/html/log/report`
`chown www-data:www-data /var/www/html/log`

4. mengatur filtering fail2ban 
`cat jail.conf >> /etc/fail2ban/jail.conf`
`cp wwwku.conf /etc/fail2ban/filter.d`

5. cek login phpotp anda dengan cara kunjungi `http://ip-address/index.php`
pada tahap ini pastikan anda sudah menginstall google authenticator dan 
silahkan masukkan username dan password yang sudah di set pada halam login, pada percobaan 1 akan terjadi pengecekan yang salah. kemudian baca qrcode dengan google authenticator dan anda akan mendapatkan kode otp yang berganti secara dinamis.  kunjungi web login anda sekali lagi. gunakan username, password dan kodeotp dari google authenticator. bila benar akan mucul valid code. 
sekarang lakukan percobaan selama `3 kali` login gagal. bila percobaan ke 4 gagal maka akan muncul halaman `connection refused` selama 5 menit

# point 2
6. alert informasi dengan email


# konfigurasi virtual host

https://www.maketecheasier.com/ip-port-based-virtualhost-apache/
ubah port pada file /etc/apache2/ports.conf
tambahkan `Listen 8080`
buat folder untuk virtualhost baru
`mkdir /var/www/html/firewall`
`touch /var/www/html/firewall/index.html`
`chown -R www-data:www-data /var/www/html/firewall/`
`chmod -R 755 /var/www/html`
`sudo a2dissite 000-default.conf`
cd /etc/apache2/sites-available/

# setup portforwarding dengan iptables
down vote
accepted
In case someone else is looking for a way that actually works. Though @HorsePunchKid is right in his suggestion, I've found this walkthrough that fills in the missing steps:

http://www.debuntu.org/how-to-redirecting-network-traffic-to-a-new-ip-using-iptables/

In essence:

Enable IP Forwarding:

sysctl net.ipv4.ip_forward=1
Add your forwarding rule (use n.n.n.n:port):

iptables -t nat -A PREROUTING -p tcp -d 10.0.0.132 --dport 29418 -j DNAT --to-destination 10.0.0.133:29418
Ask IPtables to Masquerade:

iptables -t nat -A POSTROUTING -j MASQUERADE
And that's it! It worked for me in any case :)

#show nat iptables
iptables -L -n -t nat



# referensi

https://darrynvt.wordpress.com/tag/custom-fail2ban-actions/
https://www.the-art-of-web.com/system/fail2ban-filters/