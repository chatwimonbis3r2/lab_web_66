<?php ob_start(); ?>
<?php
#header
@header('Content-Type: application/json');
@header("Access-Control-Allow-Origin: *");
@header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
?>   
<?php
#connection and data include  OR require
require("../config/config_db.php");
//print_r($conn);
?>
<?php
#input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = @file_get_contents('php://input');
    $json_data = @json_decode($content, true);
    //print_r($json_data);
    $input = trim($json_data["mem_type"]);
} else {
    ob_end_clean();
    @header("HTTP/1.0 412 Precondition Failed");
    die();
}
?>
<?php
#process
$strSQL = "SELECT * FROM `bis42_member` WHERE `mem_type` = '" . $input . "' ";
$query = @mysqli_query($conn,$strSQL);
$datalist =array();

while ($resultQuery = @mysqli_fetch_array($query)) {
    $mem_id = $resultQuery['mem_id'];
    $mem_name = $resultQuery['mem_name'];
    $mem_type = $resultQuery['mem_type'];
    $mem_point = $resultQuery['mem_point'];
    $mem_accumulat = $resultQuery['mem_accumulat'];
    $datalist[] = array(
        "id" => $mem_id,
        "name" => $mem_name,
        "type" => $mem_type,
        "point" => $mem_point,
        "accumulat" => $mem_accumulat
    );
}
?>
<?php
#output
ob_end_clean();
@mysqli_close($conn);
if ($query) {
    echo $json_response = json_encode(array("result" => 1, "message" => "พบข้อมูล", "datalist" => $datalist));
} else {
    echo $json_response = json_encode(array("result" => 0, "message" => "ไม่พบข้อมูล", "datalist" => null));
}
exit;
?>