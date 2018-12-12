# skenario

+ jika ada yang melakukan scanning terhadap komputer target, maka target akan melakukan
  - pengeblokan (30%)
  - email ke admin (70%)
  - memerintahkan komputer lainnya untuk juga melakukan blokir terhadap ip penyerang (100%)

# point 1
install aplikasi

`sudo apt-get install portsentry nmap`

# kofigurasi

`nano /etc/default/portsentry`
```
    TCP_MODE="tcp"
    UDP_MODE="udp"
```
ke
`TCP_MODE="atcp" UDP_MODE="audp"`
`nano /etc/portsentry/portsentry.conf block_udp = "2" block_tcp = "2"`

```
    KILL_RUN_CMD_FIRST = "0"
    KILL_RUN_CMD="/sbin/route add -host $TARGET$ reject; /etc/portsentry/kill_cmd.sh $TARGET$
    $PORT$ $MODE$"
```

```
#!/bin/bash
# send email
sendmail arviantiyulia16@gmail.com << END
Subject: Port Scan Detected
From: Misbahul Ardani
Someone @$1 scanned on host $HOSTNAME on port $2
Cheers,
Portsentry
END
# command other server to block
# ubah alamat server pembantu
ssh root@10.252.108.103 /sbin/route add -host $1 reject
```
lakukan nmap ke ip firewall
`route del -host ip-attacker reject`

# cara melakukan email notifikasi

## set proxy

export http_proxy='http://proxyServerSddress:proxyPort'  
export https_proxy='https://proxyServerSddress:proxyPort'

# Installing msmtp

apt-get install msmtp
vim ~/.msmtprc
account pens
tls on
auth on
host mail.student.pens.ac.id
port 587
user abdullahainun@it.student.pens.ac.id
from abdullahainun@it.student.pens.ac.id
password

# smtp google configuration

SMTP server (i.e., outgoing mail): smtp.gmail.com
SMTP username: Your full Gmail or Google Apps email address (e.g. example@gmail.com or example@yourdomain.com)
SMTP password: Your Gmail or Google Apps email password
SMTP port: 465
SMTP TLS/SSL required: yes

http://nixnote.blogspot.com/2013/10/configuring-logcheck-on-ubuntu.html
aptitude install logcheck
nano /etc/logcheck/logcheck.logfiles

https://websistent.com/how-to-use-msmtp-with-gmail-yahoo-and-php-mail/

https://linuxaria.com/pills/logcheck-scan-your-logs-and-warns-you

apt-get purge -y portsentry nmap msmtp mutt
