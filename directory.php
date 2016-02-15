<?php
$mysql_db_hostname = "localhost";
$mysql_db_user = "root";
$mysql_db_password = "c0mm0ns";
$mysql_db_database = "queues";

$con = mysqli_connect($mysql_db_hostname, $mysql_db_user, $mysql_db_password,
 $mysql_db_database);

if (!$con) {
 trigger_error('Could not connect to MySQL: ' . mysqli_connect_error());
}
if (isset($_GET['city']))
  $city = $_GET['city'];
if (isset($_GET['ofc']))
  $ofc = $_GET['ofc'];
  
$var = array();
 
 $sql ="";
$result = mysqli_query($con, $sql);

while($obj = mysqli_fetch_object($result)) {
$var[] = $obj;
}
echo '{"queue":'.json_encode($var).'}';
?>
