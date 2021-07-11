<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>Poll Devices</title>
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
<li class="nav-item"><a href="arp.php" class="nav-link">ARP Scan</a></li>
<li class="nav-item"><a href="nmap.php" class="nav-link">NMAP Scan</a></li>
<li class="nav-item"><a href="api.php" class="nav-link">Mikrotik API</a></li>
<li class="nav-item"><a href="poll.php" class="nav-link active" aria-current="page">Poll Devices</a></li>
</ul>
</header>

<div style="width: 500px; margin: 20px auto;">
<h3>Poll Details</h3><P>

<?php

// Includs database connection
include "db_connect.php";

// Makes query with rowid
//$query = "SELECT * FROM devices WHERE iptype='S'";
$query = "SELECT * FROM devices ";
$result = $db->query($query);

$online = 0;
$offline = 0;

	// Clear WIFI and AP Stats from DB
	$querywd = "UPDATE devices set ping='' ";
	$db->exec($querywd);

while($row = $result->fetchArray()) {

	$ip = $row['ip'];
	exec("fping $ip", $output, $status);
		
		if (strpos($output, 'alive') !== false) 
		  {
			$ping = 'G';
			$online = $online+1;
		  }
		else
		  {
			$ping = 'R';
			$offline = $offline+1;
		  }
//		echo $ip." - ".$ping."<BR>";

		// Update MAC Addresses
		$queryu = "UPDATE devices set ping='$ping' WHERE ip='$ip'";

		if( $db->query($queryu) ){
			$message = "Record is updated successfully.";
		}else {
			$message = "Sorry, Record is not udated.";	
		}
//		echo $message;

}

	echo "<P>Online : ".$online;
	echo "<P>Offline : ".$offline;

?>

	<P><a href="index.php">Back to Device List</a>

	</div>
</div>	
</body>
</html>
