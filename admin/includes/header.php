<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản trị</title>
    <link rel="stylesheet" href="<?php echo $_DOMAIN; ?>bootstrap/css/bootstrap.min.css">
    <script src="<?php echo $_DOMAIN ?>js/jquery.min.js"></script>
</head>
<body>
<?php
 
 // Nếu chưa đăng nhập
if (!$user){
    echo
    '
        <div class="container">
            <div class="page-header">
                <div>
                    <img class="media-object" src="'.$_DOMAIN.'images/dentalcare-logo-color.png" width="150px">
                </div>
                <h2>Dental News <small>Administration</small></h2>
            </div>
        </div>
    ';
}
 // Nếu đăng nhập
else
{
    echo
    '
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="' . $_DOMAIN . '">
                        <img class="media-object" src="'.$_DOMAIN.'images/dentalcare-logo-color.png" width="150px">
                    </a>
                </div>
                <div style="display: flex;justify-content: center;">
                    <h2>Dental News Administration</h2>
                </div>
            </div>
        </nav>
    ';
}
?>