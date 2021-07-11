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
		<title>Add Device</title>
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
<li class="nav-item"><a href="index.php" class="nav-link active" aria-current="page">Add Device</a></li>
<li class="nav-item"><a href="arp.php" class="nav-link">ARP Scan</a></li>
<li class="nav-item"><a href="nmap.php" class="nav-link">NMAP Scan</a></li>
<li class="nav-item"><a href="api.php" class="nav-link">Mikrotik API</a></li>
<li class="nav-item"><a href="poll.php" class="nav-link">Poll Devices</a></li>
</ul>
</header>

<div style="width: 500px; margin: 20px auto;">

<h3>Add Device</h3>

<?php
$message = ""; // initial message 

if( isset($_POST['submit_data']) ){

	// Includs database connection
	include "db_connect.php";

	// Gets the data from post
	$iptype = $_POST['iptype'];
	$ip = $_POST['ip'];
	$name = $_POST['name'];
	$model = $_POST['model'];
	$mac = $_POST['mac'];

	$arr = explode(".",$ip);
	$id = $arr[3];
	
	// Makes query with post data
	$query = "INSERT INTO devices (iptype, id, ip, name, model, mac) VALUES ('$iptype', '$id', '$ip', '$name', '$model', '$mac')";
	
	// Executes the query
	// If data inserted then set success message otherwise set error message
	// Here $db comes from "db_connection.php"
	if( $db->exec($query) ){
		$message = "Data is inserted successfully.";
	}else{
		$message = "Sorry, Data is not inserted.";
	}
}
?>

		<!-- showing the message here-->
		<div><?php echo $message;?></div>

		<div class="table-responsive">
		<table class="table table-striped border-primary">
			<form action="insert.php" method="post">
			<tr>
				<td>Type:</td>
				<td><input type="checkbox" id="iptype" name="iptype" value="S" checked><label for="iptype"> Static</label></td>
			</tr>
			<tr>
				<td>IP:</td>
				<td><input name="ip" type="text"></td>
			</tr>
			<tr>
				<td>Name:</td>
				<td><input name="name" type="text"></td>
			</tr>
			<tr>
				<td>Model:</td>
				<td><input name="model" type="text"></td>
			</tr>
			<tr>
				<td>MAC:</td>
				<td><input name="mac" type="text"></td>
			</tr>		
			<tr>
				<td></td>
				<td><button class="w-50 btn btn btn-primary" name="submit_data" type="submit">Update Data</button>
			</tr>
			</form>
		</table>
		</div>
	</div>
</div>
</body>
</html>
