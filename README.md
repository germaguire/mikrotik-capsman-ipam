mikrotik-capsman-ipam
=============

## Mikrotik CAPSMAN IPAM Features:
* Add/Edit/Delete IP address
* Add ARP Scan details
* Add NMAP details
* Add Mikrotik Neighbours details
* Add Mikrotik DHCP detils
* Update Mikrotik Wireless Registration details
* Update Mikrotik API Details
-- system identity
-- routerboard model
* NMAP hostscan

## Requirements:
* Tested on ubuntu.
* SQLite DB.
* Enable Mikrotik API service (create read only user for accessing API details).
* NMAP installed using sudo required for OS Scanning, create /etc/sudoers/nmap file ( www-data ALL=(ALL) NOPASSWD: /usr/bin/nmap )
* Fping required for polling devices.

## Thanks to:
https://github.com/BenMenking/routeros-api

