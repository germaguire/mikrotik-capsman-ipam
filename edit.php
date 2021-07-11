<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Update Device</title>
</head>

<div class="container">
<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
<a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
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

<h3>Edit Device</h3>

<?php

$message = ""; // initial message 

include "db_connect.php";

// Updating the table row with submited data according to rowid once form is submited 
if( isset($_POST['submit_data']) ){

	// Gets the data from post
	$id = $_POST['id'];
	$iptype = $_POST['iptype'];
	$ip = $_POST['ip'];
	$name = $_POST['name'];
	$hostname = $_POST['hostname'];
	$dhcp = $_POST['dhcp'];
	$model = $_POST['model'];
	$mac = $_POST['mac'];

	$arr = explode(".",$ip);
	$id = $arr[3];
	
	// Makes query with post data
	$query = "UPDATE devices set iptype='$iptype', id='$id', ip='$ip', name='$name', hostname='$hostname', dhcp='$dhcp', model='$model', mac='$mac' WHERE id=$id";
	
	// Executes the query
	if( $db->exec($query) ){
		$message = "Data is updated successfully.";
	}else{
		$message = "Sorry, Data is not updated.";
	}
}

$id = $_GET['id']; // rowid from url
// Prepar the query to get the row data with rowid
$query = "SELECT rowid, * FROM devices WHERE id=$id";
$result = $db->query($query);
$data = $result->fetchArray(); // set the row in $data

?>

		<div><?php echo $message;?></div>
		
		<div class="table-responsive">
		<table class="table table-striped border-primary">
			<form action="" method="post">
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<tr>
				<td>Type:</td>
				<td><input name="iptype" type="text" value="<?php echo $data['iptype'];?>"></td>
				</td>
			</tr>			
			<tr>
				<td>IP:</td>
				<td><input name="ip" type="text" value="<?php echo $data['ip'];?>"></td>
			</tr>
			<tr>
				<td>Name:</td>
				<td><input name="name" type="text" value="<?php echo $data['name'];?>"></td>
			</tr>
			<tr>
				<td>Hostame:</td>
				<td><input name="hostname" type="text" value="<?php echo $data['hostname'];?>"></td>
			</tr>			
			<tr>
				<td>DHCP:</td>
				<td><input name="dhcp" type="text" value="<?php echo $data['dhcp'];?>"></td>
			</tr>	
			<tr>
				<td>Model:</td>
				<td><input name="model" type="text" value="<?php echo $data['model'];?>"></td>
			</tr>
			<tr>
				<td>MAC:</td>
				<td><input name="mac" type="text" value="<?php echo $data['mac'];?>"></td>
			</tr>			
			<tr>
				<td></td>
				<td><button class="w-50 btn btn btn-primary" name="submit_data" type="submit">Update Data</button>
				</td>
			</tr>
			</form>
		</table>
		</div>	
	</div>
</div>	
</body>
</html>
