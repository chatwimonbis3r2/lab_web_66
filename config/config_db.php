<?php
$serverName = 'localhost';
$userName = 'root';
$userPassword = '';
$dbName = 'mysql_database';
?>
<?php
$conn = @mysqli_connect($serverName, $userName, $userPassword, $dbName);
?>
<?php
@date_default_timezone_set("Asia/Bangkok");
@mysqli_set_charset($conn, "utf8");
@mysqli_query($conn, "SET NAMES UTF8");
?>