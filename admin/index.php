<?php
require_once "core/init.php";
require_once "includes/header.php";

if ($user) {
    require_once "templates/sidebar.php";
    require_once "templates/content.php";
}

//Chưa đăng nhập
else {
    require_once "templates/signin.php";
}

require_once "includes/footer.php";
?>
