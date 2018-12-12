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