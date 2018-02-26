<?php

$con = @mysqli_connect('localhost', 'root', '', 'base');

if (!$con) {
    echo "Error: " . mysqli_connect_error();
	exit();
}

// Some Query
$sql 	= 'SELECT * FROM sp_product';
$query 	= mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($query))
{
	echo $row['product_id'];
}

// Close connection
mysqli_close ($con);
?>