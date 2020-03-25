<?php 
$db = new mysqli("localhost","root","","easytodo");
if($db->connect_error){
	exit("cannot connect to database.");
}/*else {
	echo "connection successful2";
}*/

 ?>