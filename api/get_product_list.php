<?php ob_start(); ?>

<?php
@header('Content-Type: application/json');
@header("Access-Control-Allow-Origin: *");
@header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
?>

<?php
require("../config/config_db.php");
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = @file_get_contents('php://input');
    $json_data = @json_decode($content, true);
} else {
    ob_end_clean();
    @header("HTTP/1.0 412 Precondition Failed");
    die();
}
?>

<?php
$strSQL = "SELECT *,product.name AS pname,product_type.name AS tname FROM product JOIN product_type On product.typeid = product_type.typeid";
$query = @mysqli_query($conn, $strSQL);
$datalist = array();

while ($resultQuery = @mysqli_fetch_array($query)) {
    //print_r($resultQuery['pname']."--".$resultQuery['tname']."\n");
    $sku = $resultQuery['sku'];
    $id = $resultQuery['id'];
    $pname = $resultQuery['pname'];
    $detail = $resultQuery['detail'];
    $price = $resultQuery['price'];
    $nums = $resultQuery['nums'];
    $imgid = $resultQuery['imgid'];
    $tname = $resultQuery['tname'];
    $datalist[] = array("sku" => $sku, "id" => $id, "pname" => $pname, "price" => $price, "nums" => $nums, "imgid" => $imgid, "tname" => $tname);
}
?>

<?php
ob_end_clean();
@mysqli_close($conn);
if ($query) {
    echo $json_response = json_encode(array("result" => 1, "message" => "พบข้อมูล", "datalist" => $datalist));
} else {
    echo $json_response = json_encode(array("result" => 0, "message" => "ไม่พบข้อมูล", "datalist" => null));
}
exit;
?>