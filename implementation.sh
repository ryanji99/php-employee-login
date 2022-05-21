#!/bin/bash

#fail2ban
sudo cp /etc/fail2ban/jail.{conf,local}

#Modify configs
sed -i 's/^bantime.*= .*/bantime  = 12h/g' /etc/fail2ban/jail.local
sed -i 's/^maxretry.*= .*/maxretry = 3/g' /etc/fail2ban/jail.local
sed -i 's/^findtime  = .*/findtime = 1h/g' /etc/fail2ban/jail.local
sed -i 's/^#ignoreip = 127.0.0.1/8 ::1/ignoreip = 127.0.0.1/8 ::1/g' /etc/fail2ban/jail.local
sed -i '/^\[apache-auth\]$/ a enabled = true' /etc/fail2ban/jail.local
sed -i '/^\[apache-badbots\]$/ a enabled = true' /etc/fail2ban/jail.local
sed -i '/^\[apache-noscript\]$/ a enabled = true' /etc/fail2ban/jail.local
sed -i '/^\[apache-overflows\]$/ a enabled = true' /etc/fail2ban/jail.local
#Add custom rule for our login path
printf '[Definition]\nfailregex = ^<HOST> -.* "POST /php/login.php HTTP/1.1" 200 .*\nignoreregex =' | sudo tee -a  /etc/fail2ban/filter.d/site-login.conf
printf '\n[site-login]\nenabled = true\nlogpath = /var/log/apache2/access.log\nbantime = 10m\nfindtime = 10m\nmaxretry = 3' | sudo tee -a /etc/fail2ban/jail.local
sudo service fail2ban restart
echo "fail2ban is now running. Type 'sudo fail2ban-client status' for more information"
printf '\n'
echo "Log files can be located at /var/log/fail2ban.log"

#ufw
echo -e "\n\nMaking sure UFW is updated"
sudo apt-get install ufw
echo -e "\n\nResetting UFW"
sudo ufw --force reset
echo -e "\n\nDisabling UFW while settings update"
sudo ufw disable
echo -e "\n\nDeny incoming connections"
sudo ufw default deny incoming
echo -e "\n\nAllow outgoing connections"
sudo ufw default allow outgoing
echo -e "\n\nAllow SSH"
sudo ufw allow 22
echo -e "\n\nAllow http web traffic"
sudo ufw allow 80
echo -e "\n\nAllow https web traffic"
sudo ufw allow 443
echo -e "\n\nAllow ftp web traffic"
sudo ufw allow 21
echo -e "\n\nUFW Setup Complete, enabling UFW"
sudo ufw --force enable

#Snort
sudo ln -s /usr/local/bin/snort /usr/sbin/snort
sudo groupadd snort
sudo useradd snort -r -s /sbin/nologin -c SNORT_IDS -g snort
sudo chmod -R 5775 /etc/snort
sudo chmod -R 5775 /var/log/snort
sudo chown -R snort:snort /etc/snort
sudo chown -R snort:snort /var/log/snort

# Edit Configs
sed -i "s|^ipvar HOME_NET .*|ipvar HOME_NET $(hostname -i)\/32|g" /etc/snort/snort.conf

#Make service
printf "[Unit]\nDescription=Snort NIDS Daemon\nAfter=syslog.target network.target\n\n[Service]\nType=simple\nExecStart=/usr/local/bin/snort -q -u snort -g snort -c /etc/snort/snort.conf -i eth0\n\n[Install]\nWantedBy=multi-user.target" > /lib/systemd/system/snort.service
sudo systemctl daemon-reload
sudo systemctl start snort