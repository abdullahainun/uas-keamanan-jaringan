# point 1, blok scanning from attacker
apt-get install -y portsentry nmap
printf 'TCP_MODE="atcp"\nUDP_MODE="audp"\n' > /etc/default/portsentry
sed -i 's/BLOCK_UDP="0"/BLOCK_UDP="1"/g' /etc/portsentry/portsentry.conf && sed -i 's/BLOCK_TCP="0"/BLOCK_TCP="1"/g' /etc/portsentry/portsentry.conf
service portsentry restart
# point 2, mengirim alert ke email
apt-get -y install msmtp ca-certificates mutt logcheck
cat msmtprc > /etc/msmtprc && touch ~/.muttrc && cat muttrc > ~/.muttrc
cat logcheck.conf > /etc/logcheck/logcheck.conf