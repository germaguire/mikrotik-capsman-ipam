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
	<title>Mikrotik API</title>	
</head>
<body>
<div class="container">
<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
<a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
<svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
<span class="fs-4">Mikrotik IPAM</span>
</a>

<ul class="nav nav-pills">
<li class="nav-item"><a href="index.php" class="nav-link">Devices</a></li>
<li class="nav-item"><a href="insert.php" class="nav-link">Add Device</a></li>
<li class="nav-item"><a href="arp.php" class="nav-link">ARP Scan</a></li>
<li class="nav-item"><a href="nmap.php" class="nav-link">NMAP Scan</a></li>
<li class="nav-item"><a href="api.php" class="nav-link active" aria-current="page">Mikrotik API</a></li>
<li class="nav-item"><a href="poll.php" class="nav-link" >Poll Devices</a></li>
</ul>
</header>

<div style="width: 500px; margin: 20px auto;">
<h3>Mikrotik API Details</h3>

<?php
include "config.php";
include "db_connect.php";
	
require('routeros-api/routeros_api.class.php');

$API = new RouterosAPI();

$API->debug = false;
 
$neigh = "0";
$added = "0";

if ($API->connect($mikrotik, $muser, $mpass)) {

//////////////////  Mikrotik Identity  //////////////////////////////

   $ARRAY = $API->comm("/system/identity/print", array(
//      "value-list"=> "",
      "~active-address" => "1.1.",
   ));

	foreach($ARRAY as $row){

		$ip = $mikrotik;
		$mac = $row['mac-address'];
		$hostname = $row['name'];
		$arr = explode(".",$ip);
		$id = $arr[3];
		
		// Makes query with post data
		$queryid1 = "UPDATE devices set mac='$mac', hostname='$hostname', model='$model' WHERE ip='$ip'";
		$db->exec($queryid1);
		
		if($ip) {
			// Makes query with post data
			$queryid2 = "INSERT INTO devices (id, iptype, ip, mac, hostname, model) VALUES ('$id', 'M', '$ip', '$mac', '$hostname', '$model')";
			if( $db->exec($queryid2) ){
//				echo $ip."  - ".$mac."<br>";
			}
		}
	}
	echo "<P> Updated Mikrotik Identity Information";

//////////////////  Mikrotik Model  //////////////////////////////

   $ARRAY = $API->comm("/system/routerboard/print", array(
//      "value-list"=> "",
      "~active-address" => "1.1.",
   ));

	foreach($ARRAY as $row){

		$ip = $mikrotik;
		$model = $row['model'];
		$arr = explode(".",$ip);
		$id = $arr[3];
		
		// Makes query with post data
		$querymodel = "UPDATE devices set mac='$mac', hostname='$hostname', model='$model' WHERE ip='$ip'";
		$db->exec($querymodel);
		
		if($ip) {
			// Makes query with post data
			$querymodel2 = "INSERT INTO devices (id, iptype, ip, mac, hostname, model) VALUES ('$id', 'M', '$ip', '$mac', '$hostname', '$model')";
			if( $db->exec($querymodel2) ){
//				echo $ip."  - ".$mac."<br>";
			}
		}
	}
	echo "<P> Updated Mikrotik Identity Information";

//////////////////  Neighbours  //////////////////////////////

   $ARRAY = $API->comm("/ip/neighbor/print", array(
//      "value-list"=> "",
      "~active-address" => "1.1.",
   ));

	foreach($ARRAY as $row){

		$ip = $row['address'];
		$mac = $row['mac-address'];
		$hostname = $row['identity'];
		$model = $row['board'];
		$arr = explode(".",$ip);
		$id = $arr[3];
		
		// Makes query with post data
		$queryneigh = "UPDATE devices set mac='$mac', hostname='$hostname', model='$model' WHERE ip='$ip'";
		$db->exec($queryneigh);
		
		if($ip) {
			// Makes query with post data
			$queryneigh2 = "INSERT INTO devices (id, iptype, ip, mac, hostname, model) VALUES ('$id', 'M', '$ip', '$mac', '$hostname', '$model')";
			if( $db->exec($queryneigh2) ){
				$neigh = $neigh+1;
//				echo $ip."  - ".$mac."<br>";
			}
		}
	}
	echo "<P> Updated Neighbors Information";
	echo "<P>Added ".$neigh." devices to DB.<P>";

//////////////////  ARP  //////////////////////////////

   $ARRAY = $API->comm("/ip/arp/print", array(
//      "value-list"=> "",
      "~active-address" => "1.1.",
   ));

	foreach($ARRAY as $row){

		$ip = $row['address'];
		$mac = $row['mac-address'];
		$arr = explode(".",$ip);
		$id = $arr[3];
		
		// Makes query with post data
		$query = "UPDATE devices set mac='$mac' WHERE ip='$ip'";
		$db->exec($query);
		
		if($mac) {
			// Makes query with post data
//			$queryi = "INSERT INTO devices (id, iptype, ip, mac) VALUES ('$id', 'M', '$ip', '$mac')";
//			if( $db->exec($queryi) ){
//				$added = $added+1;
//				echo $ip."  - ".$mac."<br>";
//			}
		}
	}
	echo "<P> Updated IP ARP Information";
	echo "<P>Added ".$added." devices to DB.<P>";

//////////////////  Clear WIFI Stats  //////////////////////////////

	// Clear WIFI and AP Stats from DB
	$querywd = "UPDATE devices set ap='', snr='' ";
	$db->exec($querywd);

//////////////////  CAPSMAN  //////////////////////////////

   $ARRAY = $API->comm("/caps-man/registration-table/print", array(
//      "value-list"=> "",
      "~active-address" => "1.1.",
   ));

	$updated="0";
	
	foreach($ARRAY as $row){

//		print_r($row);
//		echo "<P>";
		
		$mac = $row['mac-address'];
		$ap = $row['interface'];
		$snr = $row['rx-signal'];		
		
		// Makes query with post data
		$queryw = "UPDATE devices set ap='$ap', snr='$snr' WHERE mac='$mac'";

		if( $db->exec($queryw) ){
			$updated = $updated+1;
//			echo $mac." - ".$ap."  - ".$snr."<br>";
		}
	}

		echo "<P>Updated CAPSMAN Information";
		echo "<P>Updated ".$updated." devices in DB.<P>";		


/////////////////  Wireless Registrations  //////////////////////////////


   $ARRAY = $API->comm("/interface/wireless/registration-table/print", array(
//      "value-list"=> "",
      "~active-address" => "1.1.",
   ));
	
	foreach($ARRAY as $row){
		
		$mac = $row['mac-address'];
//		$ap = $row['interface'];
		$ap = "ap";
		$signal = $row['signal-strength'];
		$arr = explode("@",$signal);
		$snr = $arr[0];
		
		// Makes query with post data
		$querywr = "UPDATE devices set ap='$ap', snr='$snr' WHERE mac='$mac'";

		if( $db->exec($querywr) ){
			$updated = $updated+1;
//			echo $mac."  ".$snr."<br>";
		}
	}

		echo "<P>Updated Wireless Registration Information";
		echo "<P>Updated ".$updated." devices in DB.<P>";


//////////////////  DHCP  //////////////////////////////

   $ARRAY = $API->comm("/ip/dhcp-server/lease/print", array(
//      "value-list"=> "",
//      "~active-address" => "1.1.",
   ));

	$updated="0";
	
	foreach($ARRAY as $row){
//		print_r($row);
//		echo "<P>";
		
		$ip = $row['address'];
		$hostname = $row['host-name'];
		$dhcp = $row['comment'];		

//		echo " --> ".$ip." ".$hostname." ".$dhcp;
//		echo "<P>";

		// Makes query with post data
		$queryd = "UPDATE devices set hostname='$hostname', dhcp='$dhcp' WHERE ip='$ip'";
//		$db->exec($queryd);
		if( $db->exec($queryd) ){
			$updated = $updated+1;
//			echo $ip." - ".$hostname."  - ".$dhcp."<br>";
		}
	}

		echo "<P> Updated DHCP Lease Information";
		echo "<P>Updated ".$updated." devices in DB.<P>";	
		
   $API->disconnect();

}



?>

	<P><a href="index.php">Back to Device List</a>

	</div>
</body>
</html>

