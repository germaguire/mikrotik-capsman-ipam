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

## Requirements:
* Tested on ubuntu.
* SQLite DB.
* Enable Mikrotik API service (create read only user for accessing API details).
* NMAP installed using sudo required for OS Scanning, create /etc/sudoers/nmap file 
  * www-data ALL=(ALL) NOPASSWD: /usr/bin/nmap
* Fping required for polling devices.

## Thanks to:
https://github.com/BenMenking/routeros-api

## Screenshot:
![alt text](https://github.com/germaguire/mikrotik-capsman-ipam/blob/main/devices.png?raw=true)

