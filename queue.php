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
if (isset($_GET['id']))
  $ofcid = $_GET['id'];

$var = array();
 
 $sql ="SELECT distinct officetypes.name,
 officetypes.type_id,
 city.name as city,
 tickets.number as nr_given,
 tickets.time as nr_given_time,
 serving.number as nr_serving,
 serving.time as nr_serving_time,
 offices.active as active,
 offices.est_serving_time_min,
 offices.address,
 offices.telephone,
 offices.longtitude,
 offices.latitude
FROM offices 
LEFT JOIN tickets ON offices.ofc_id=tickets.ofc_id
LEFT JOIN serving ON offices.ofc_id=serving.ofc_id
LEFT JOIN city ON offices.city_id=city.city_id
LEFT JOIN officetypes ON offices.srv_type_id=officetypes.type_id
WHERE offices.ofc_id=$ofcid
ORDER BY tickets.time DESC, serving.time DESC
LIMIT 1";
$result = mysqli_query($con, $sql);

while($obj = mysqli_fetch_object($result)) {
$var[] = $obj;
}
echo '{"queue":'.json_encode($var).'}';
?>
