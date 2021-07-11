mikrotik-capsman-ipam
=============

## Mikrotik CAPSMAN IPAM Features:
* Add/Edit/Delete IP address
* Add ARP Scan details (ip, mac)
* Add NMAP details (ip, mac)
* Add Mikrotik Neighbours details (ip, mac, hostname)
* Add Mikrotik DHCP detils (ip, mac, hostname, DHCP Comment)
* Update Mikrotik CAPSMAN Registration details (ap, snr)
* Update Mikrotik Wireless Registration details (snr)
* Update Mikrotik Details
  * system identity
  * routerboard model
* NMAP hostscan
* Fping device polling
* SQLite database.

## Requirements:
* Tested on ubuntu bionic with following packages.
  * apt-get install apache2 php7.2 libapache2-mod-php libapache2-mod-php7.2 php7.2-sqlite3 nmap fping

* Enable Mikrotik API service (create read only user for accessing API details).

* NMAP installed using sudo required for OS Scanning, create /etc/sudoers/nmap file 
  * www-data ALL=(ALL) NOPASSWD: /usr/bin/nmap


## Thanks to:
https://github.com/BenMenking/routeros-api

## Screenshot:
![alt text](https://github.com/germaguire/mikrotik-capsman-ipam/blob/main/devices.png?raw=true)

