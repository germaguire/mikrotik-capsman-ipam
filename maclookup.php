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
	<title>MAC Lookup</title>	
</head>
<body>
 
<div class="container">
<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
<a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
<svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
<span class="fs-4">Mikrotik IPAM</span>
</a>

<ul class="nav nav-pills">
<li class="nav-item"><a href="index.php" class="nav-link active" aria-current="page">Devices</a></li>
<li class="nav-item"><a href="insert.php" class="nav-link">Add Device</a></li>
<li class="nav-item"><a href="arp.php" class="nav-link">ARP Scan</a></li>
<li class="nav-item"><a href="nmap.php" class="nav-link">NMAP Scan</a></li>
<li class="nav-item"><a href="api.php" class="nav-link">Mikrotik API</a></li>
<li class="nav-item"><a href="poll.php" class="nav-link">Poll Devices</a></li>
</ul>
</header>


<div style="width: 500px; margin: 20px auto;">
<h3>MAC Lookup</h3>

<?php

// Includs database connection
include "db_connect.php";

$id = $_GET['id']; // rowid from url

// Prepar the query to get the row data with rowid
$query = "SELECT rowid, * FROM devices WHERE id=$id";
$result = $db->query($query);

$data = $result->fetchArray(); // set the row in $data

$mac_address = $data['mac'];

//  $mac_address = "FC:FB:FB:01:FA:21";

  $url = "https://api.macvendors.com/" . urlencode($mac_address);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $response = curl_exec($ch);

  if($response) {
    echo "MAC Lookup: <P> $response";
  } else {
    echo "Not Found";
  }
?>

	<P><a href="index.php">Back to Device List</a>

	</div>
</div>	
</body>
</html>


