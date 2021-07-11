<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Scan Device</title>	
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
<li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Add Device</a></li>
<li class="nav-item"><a href="arp.php" class="nav-link">ARP Scan</a></li>
<li class="nav-item"><a href="nmap.php" class="nav-link">NMAP Scan</a></li>
<li class="nav-item"><a href="api.php" class="nav-link">Mikrotik API</a></li>
<li class="nav-item"><a href="poll.php" class="nav-link">Poll Devices</a></li>
</ul>
</header>

<?php

// Includs database connection
include "db_connect.php";

$id = $_GET['id']; // rowid from url

// Prepar the query to get the row data with rowid
$query = "SELECT rowid, * FROM devices WHERE id=$id";
$result = $db->query($query);

$data = $result->fetchArray(); // set the row in $data
?>

	<div style="width: 500px; margin: 20px auto;">

	<?php

	$ip = $data['ip'];
	$name = $data['name'];
	echo "<h3> ".$ip." Status</h3><P> Name: ".$name."<P>";

	$target = $data['ip'];

	// Required /etc/sudoers/nmap file (www-data ALL=(ALL) NOPASSWD: /usr/bin/nmap)
	exec("sudo nmap -O $target", $output, $status);
	echo "<P>";
	$arrlength = count($output);
	for($x = 0; $x < $arrlength; $x++) {
		echo " ".$output[$x]." <BR>";	
	}


	?>
	<P><a href="index.php">Back to Device List</a>

	</div>
</div>	
</body>
</html>
