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
	<title>Devices</title>
</head>
<body>
 
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

 
<?php
include "config.php";
include "db_connect.php";

$sort = $_GET['sort'];

if( $sort == "snr" )
{
	$query = "SELECT rowid, * FROM devices ORDER BY snr";
}
elseif( $sort == "ap" )
{
	$query = "SELECT rowid, * FROM devices ORDER BY ap DESC";
}
elseif( $sort == "name" )
{
	$query = "SELECT rowid, * FROM devices ORDER BY name DESC";
}
elseif( $sort == "hostname" )
{
	$query = "SELECT rowid, * FROM devices ORDER BY hostname DESC";
}
else
{
	$query = "SELECT rowid, * FROM devices ORDER BY id";
}
	

// Run the query and set query result in $result
// Here $db comes from "db_connection.php"
$result = $db->query($query);
$count = "0";
?>
<!--	<div style="width: 900px; margin: 20px auto;"> -->
	<div>

		<div class="table-responsive">
		<table class="table table-striped border-primary">
			<tr>
				<td>Ping</td>
				<td><a href="index.php">IP Address</a></td>
				<td><a href="index.php?sort=name">Name</a></td>
				<td><a href="index.php?sort=hostname">Hostname</a></td>
				<td>DHCP Comment</td>
				<td>Model</td>
				<td>MAC</td>
				<td>Type</td>				
				<td><a href="index.php?sort=ap">AP</a></td>
				<td><a href="index.php?sort=snr">SNR</a></td>
				<td>Action</td>
				
			</tr>
			
			<?php while($row = $result->fetchArray()) {?>
			<?php $count = $count+1;?>
			<tr>
				<td>
					<?php
						$color = $row['ping'];
						if ($color == 'R') 
						{
							?><i class="fa fa-times-circle" style="color:red"><?php
						}
						elseif ($color == 'Y')
						{
							?><i class="fa fa-exclamation-circle" style="color:orange"><?php	
						}
						elseif ($color == 'G')
						{
							?><i class="fa fa-check-circle" style="color:green"><?php
						}	
						//echo $row['ping'];
					?>
				</td>
				<td><?php echo $row['ip'];?></td>
				<td><?php echo $row['name'];?></td>
				<td><?php echo $row['hostname'];?></td>
				<td><?php echo $row['dhcp'];?></td>
				<td><?php echo $row['model'];?></td>
				<td><a href="maclookup.php?id=<?php echo $row['id'];?>"><?php echo $row['mac'];?></a></td>
				<td><?php echo $row['iptype'];?></td>				
				<td><?php echo $row['ap'];?></td>
				<td><?php echo $row['snr'];?></td>
				<td>
					<a href="edit.php?id=<?php echo $row['id'];?>">Edit</a> 
					<a href="delete.php?id=<?php echo $row['id'];?>" onclick="return confirm('Are you sure?');">Delete</a> <BR>
					<a href="hostscan.php?id=<?php echo $row['id'];?>">Scan</a>
	
				</td>
			</tr>
			<?php } ?>
		</table>
		</div>
		<P>There are <?php echo $count;?> devices in DB.
	</div>  </div>
</body>
</html>
