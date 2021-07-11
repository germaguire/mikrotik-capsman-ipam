<?php
// Database name
$database_name = "ipam_sqlite.db";

// Database Connection
$db = new SQLite3($database_name);

// Create Table "devices" into Database if not exists 
$query = "CREATE TABLE IF NOT EXISTS devices (id string, ping STRING, iptype STRING, ip STRING PRIMARY KEY NOT NULL, name STRING, hostname STRING, dhcp STRING, model STRING, mac STRING, ap STRING, snr STRING)";
$db->exec($query);


?>