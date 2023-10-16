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
    $inputEmail = trim($json_data["email"]);
    $inputPassword = trim($json_data["password"]);
    $session = trim($json_data["session"]);
} else {
    ob_end_clean();
    @header("HTTP/1.0 412 Precondition Failed");
    die();
}
?>

<?php
$strSQL = "SELECT * FROM customer WHERE email = '" . $inputEmail . "' ";
$query = @mysqli_query($conn, $strSQL);
$resultQuery = @mysqli_fetch_array($query);
print_r($resultQuery);

$datalist = array();

if (trim($resultQuery['email']) != "" && trim($resultQuery['password']) == $inputPassword) {
    $result = 1;
    $message = "เข้าสู่ระบบ";
    $datalist = array("id" => $resultQuery['id'], "name" => $resultQuery['name'], "email" => $resultQuery['email']);
    $strSQL = "UPDATE customer SET session='" . $session . "' WHERE email ='" . $resultQuery['email'] . "' ";
    $query = @mysqli_query($conn, $strSQL);
} else {
    $result = 0;
    $message = "เข้าสู่ระบบไม่สำเร็จ";
    $datalist = null;
}
?>

<?php
ob_end_clean();
@mysqli_close($conn);
echo $json_response = json_encode(array("result" => $result, "message" => $message, "datalist" => $datalist));
_log_customer_login($content, $json_response);
exit;
?>

<?php
function _log_customer_login($content, $json_response)
{
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = @date("Y-m-d H:i:s");
    $_log = "\n" . $date . " " . $ip . " request:" . $content . " response:" . $json_response;
    $objFopen = @fopen("log/_log_customer_login.log", "a+"); #a a+ w w+
    @fwrite($objFopen, $_log);
    @fclose($objFopen);
}
?>