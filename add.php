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
$var = array();
$type = $_POST["type"];
$ofc_id = $_POST["ofc_id"];

$sql = "SELECT number FROM tickets WHERE ofc_id=$ofc_id ORDER BY number DESC LIMIT 1";
 $result = $con->query($sql);
 if ($result->num_rows > 0 ) {
   $row = $result->fetch_assoc();
   $last_ticket = $row["number"];
   $last_ticket++;
 } else {
    $last_ticket = 1;
 }
 $sql = "SELECT number FROM serving WHERE ofc_id=$ofc_id ORDER BY number DESC LIMIT 1";
 $result = $con->query($sql);
 if ($result->num_rows >0 ) {
   $row = $result->fetch_assoc();
   $last_serving = $row["number"];
   $last_serving++;
 } else {
     $last_serving = 1;
 }
 
if ($type == 'tickets') {
    $sql = "INSERT INTO tickets (ofc_id, number, time) VALUES ($ofc_id,$last_ticket,NOW())";
} else {
    $sql = "INSERT INTO serving (ofc_id, number, time) VALUES ($ofc_id,$last_serving,NOW())";
}
if ($con->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}

$con->close();
?> 
?>
