<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="icon" type="image/png" href="favicon.png" />		
	<title>ARP Scan</title>	
</head>

<body>
<div class="container">
<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
<a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
<svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
<span class="fs-4">Mikrotik IPAM</span>
</a>

<ul class="nav nav-pills">
<li class="nav-item"><a href="index.php" class="nav-link">Devices</a></li>
<li class="nav-item"><a href="insert.php" class="nav-link">Add Device</a></li>
<li class="nav-item"><a href="arp.php" class="nav-link active" aria-current="page">ARP Scan</a></li>
<li class="nav-item"><a href="nmap.php" class="nav-link">NMAP Scan</a></li>
<li class="nav-item"><a href="api.php" class="nav-link">Mikrotik API</a></li>
<li class="nav-item"><a href="poll.php" class="nav-link">Poll Devices</a></li>
</ul>
</header>

	<div style="width: 500px; margin: 20px auto;">
	
	<?php

	echo "<H3>ARP Scan</H3>";
	
	include "config.php";
	include "db_connect.php";
	
	exec("arp -n |grep :", $output, $status);

	$added = "0";
	$updated = "0";
	$count = "0";
	
	$arrlength = count($output);
	
	for($x = 0; $x < $arrlength; $x++) {

		$row = $output[$x];	
		
		$stripped = trim(preg_replace('/\s+/', ' ', $row));
		
		$a = explode(" ",$stripped);

		$ip = $a[0];
		$mac = $a[2];
		$mac = strtoupper($mac);

		$arr = explode(".",$ip);
		$id = $arr[3];

		// Update MAC Addresses
		$queryu = "UPDATE devices set mac='$mac' WHERE ip='$ip'";
		if( $db->exec($queryu) ){
			$updated = $updated+1;
//			echo "<BR>IP : ".$ip." MAC : ".$mac."<br>";	
		}

		// Makes query with post data
		$querya = "INSERT INTO devices (id, ip, iptype, mac) VALUES ('$id', '$ip', 'A', '$mac')";
		// Executes the query
		if( $db->exec($querya) ){
			$added = $added+1;		
			echo "<BR>IP : ".$ip." MAC : ".$mac."<br>";	
		}

	}

	echo "<P><BR>Updated ".$updated." devices to DB.";
	echo "<P>Added ".$added." devices to DB.";
	

	?>
	<P><a href="index.php">Back to Device List</a>
	

	</div>
</div>
</body>
</html>
