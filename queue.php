<?php
$mysql_db_hostname = "localhost";
$mysql_db_user = "";
$mysql_db_password = "";
$mysql_db_database = "";

$con = mysqli_connect($mysql_db_hostname, $mysql_db_user, $mysql_db_password,
 $mysql_db_database);
 
$con->set_charset('utf8');

if (!$con) {
 trigger_error('Could not connect to MySQL: ' . mysqli_connect_error());
}

$ofcid = -1;
$typeid = -1;
if (isset($_GET['id']))
  $ofcid = $_GET['id'];
if (isset($_GET['type']))
  $typeid = $_GET['type'];
if (isset($_GET['city']))
  $cityid = $_GET['city'];
    
$var = array();
 if ($ofcid != -1) {
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
} else if ($typeid != -1) {
    $sql = "SELECT * FROM (
SELECT distinct offices.address,
 tickets.number as nr_given,
 tickets.time as nr_given_time,
 serving.number as nr_serving,
 serving.time as nr_serving_time,
 offices.active as active,
 offices.est_serving_time_min,
 offices.telephone,
 offices.longtitude,
 offices.latitude
FROM offices 
LEFT JOIN tickets ON offices.ofc_id=tickets.ofc_id
LEFT JOIN serving ON offices.ofc_id=serving.ofc_id
LEFT JOIN city ON offices.city_id=city.city_id
LEFT JOIN officetypes ON offices.srv_type_id=officetypes.type_id
WHERE offices.city_id=11 AND offices.srv_type_id=5
ORDER BY tickets.time DESC, serving.time DESC
) AS offices GROUP BY offices.address";
}
$result = mysqli_query($con, $sql);

while($obj = mysqli_fetch_object($result)) {
$var[] = $obj;
}
echo '{"queue":'.json_encode($var).'}';
?>
