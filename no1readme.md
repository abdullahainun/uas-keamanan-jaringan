# skenario portsentry

Jika ada yang melakukan scanning terhadap komputer target, maka target akan melakukan
  - pengeblokan (30%)
  - email ke admin (70%)
  - memerintahkan komputer lainnya untuk juga melakukan blokir terhadap ip penyerang (100%)

# point 1 (pengeblokan dan memerintahkan komputer lainnya untuk memblokir terhadap ip lainnya)
1. install aplikasi

```
    sudo apt-get install portsentry nmap
```

2. kofigurasi

```
    nano /etc/default/portsentry
```

ganti isi konfigurasi berikut ini
```
    TCP_MODE="tcp"
    UDP_MODE="udp"
```
menjadi seperti ini
```
    TCP_MODE="atcp" 
    UDP_MODE="audp"
```
setelah itu edit `nano /etc/portsentry/portsentry.conf` dan ubah seperti ini

```
    BLOCK_UDP="2"
    BLOCK_TCP="2"

    KILL_RUN_CMD_FIRST = "0"
    KILL_RUN_CMD="/sbin/route add -host $TARGET$ reject; /etc/portsentry/kill_cmd.sh $TARGET$
    $PORT$ $MODE$"
```
3. buat file baru /etc/portsentry/kill_cmd.sh
```
    #!/bin/bash
    # send email
    sendmail abdullahainun97@gmail.com << END
    Subject: Port Scan Detected
    From: Ainun Abdullah
    Someone @$1 scanned on host $HOSTNAME on port $2
    Cheers,
        Portsentry
    END
    # command other server to block
    # ubah alamat server pembantu
    ssh root@10.252.108.103 /sbin/route add -host $1 reject
```

Ubah file permission
```
    chmod +x /etc/portsentry/kill_cmd.sh
```

cek tabel route dengan perintah __route -n__ jikaseperti ini maka portsentry sudah bekerja
```
root@training:~# route -n
Kernel IP routing table
Destination     Gateway         Genmask         Flags Metric Ref    Use Iface
0.0.0.0         10.148.0.1      0.0.0.0         UG    0      0        0 eth0
5.188.206.22    -               255.255.255.255 !H    0      -        0 -
10.148.0.1      0.0.0.0         255.255.255.255 UH    0      0        0 eth0
24.5.66.158     -               255.255.255.255 !H    0      -        0 -

```


4 melakukan email notifikasi

Installing ssmtp
```
    apt-get install ssmtp
```
Ubah file /etc/ssmtp/ssmtp.conf
```
    # -- smtp.gmail.com--
    UseSTARTTLS=YES
    root=abdullahainun97@gmail.com
    mailhub=smtp.gmail.com:587
    AuthUser=abdullahainun97@gmail.com
    AuthPass="kodeappanda"
    FromLineoverride=YES
```

Ubah file /etc/ssmtp/revaliases tambahkan di akhir baris
```
    root: abdullahainun97@gmail.com:smtp.gmail.com:587
```


oke, untuk memastikan bahwa email anda sudah terkirim silahkan cek dengan 
`tailf /var/log/mail.log` 
dan melihat tabel routing dengan perintah `route -n` dan bila anda ingin melepaskan blok dapat menggunakan `route del -host ipadd reject`


*) catatan*
Sebelum melakukan konfigurasi
1. aktifkan 2 factor authentication pada email Anda
[https://myaccount.google.com/u/1/security](https://myaccount.google.com/u/1/security){:target="_blank"}
2. jika sudah generate app password
[https://security.google.com/settings/security/apppasswords](https://security.google.com/settings/security/apppasswords){:target="_blank"}
