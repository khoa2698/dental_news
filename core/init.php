<?php
require_once "admin/classes/db.php";
require_once "admin/classes/session.php";
require_once "admin/classes/functions.php";

// Kết nối database
$db = new DB();
$db->connect();
$db->set_char('utf8');

$_DOMAIN = 'http://localhost/newsKN/';
// Lấy thông tin website
$sql_get_data_web = "SELECT * FROM website";
if ($db->num_rows($sql_get_data_web)) {
    $data_web = $db->fetch_assoc($sql_get_data_web, 0);
}
?>