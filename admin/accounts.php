<?php
require_once 'core/init.php';

if ($user) {
    if(isset($_POST['action'])) {
        $action = trim(addslashes(htmlspecialchars($_POST['action'])));

        if ($action == 'add_acc') {
            // Xử lý các giá trị
            $user_add_acc = trim(htmlspecialchars(addslashes($_POST['user_add_acc'])));
            $display_name = trim(htmlspecialchars(addslashes($_POST['user_add_acc'])));
            $pw_add_acc = trim(htmlspecialchars(addslashes($_POST['pw_add_acc'])));
            $repw_add_acc = trim(htmlspecialchars(addslashes($_POST['repw_add_acc'])));
            $position_add_acc = $_POST['position_add_acc'];
            $status_add_acc = $_POST['status_add_acc'];
            // Các biến xử lý thông báo
            $show_alert = '<script>$("#formAddAcc .alert").removeClass("hidden");</script>';
            $hide_alert = '<script>$("#formAddAcc .alert").addClass("hidden");</script>';
            $success = '<script>$("#formAddAcc .alert").attr("class", "alert alert-success");</script>';

            $qr_check_user_exist = "
            SELECT username FROM accounts
            WHERE username = '$user_add_acc';
            ";
            if ($user_add_acc == '' || $pw_add_acc == '' || $repw_add_acc == '') {
                echo $show_alert.'Vui lòng điền đầy đủ thông tin.';
            } else if (strlen($user_add_acc) < 6 || strlen($user_add_acc) > 32) {
                echo $show_alert.'Tên đăng nhập nằm trong khoảng 6-32 ký tự.';
            } else if (preg_match('/\W/', $user_add_acc)) {
                echo $show_alert.'Tên đăng nhập không chứa kí tự đậc biệt và khoảng trắng.';
            } else if ($db->num_rows($qr_check_user_exist)) {
                echo $show_alert.'Tên đăng nhập đã tồn tại.';
            } else if (strlen($pw_add_acc) < 6) {
                echo $show_alert.'Mật khẩu quá ngắn.';
            } else if ($pw_add_acc != $repw_add_acc) {
                echo $show_alert.'Mật khẩu nhập lại không khớp.';
            }
            else {
                $pw_add_acc = md5($pw_add_acc);
                $qr_add_acc = "INSERT INTO accounts VALUES (
                    '',
                    '$user_add_acc',
                    '$pw_add_acc',
                    '$display_name',
                    '',
                    '$position_add_acc',
                    '$status_add_acc',
                    '$date_current',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                );
                ";
                $db->query($qr_add_acc);
                $db->close();
                echo $show_alert.$success.'Thêm tài khoản thành công.';
                new Redirect($_DOMAIN.'accounts'); // Trở về trang danh sách tài khoản
            }
        }
        // Mở tài khoản
        // Mở khóa nhiều tài khoản
        elseif ($action == 'unlock_acc_list') {
            foreach($_POST['id_acc'] as $key => $id_acc) {
                $qr_check_id_acc_exist = "
                SELECT id_acc FROM accounts WHERE id_acc = '$id_acc';
                ";
                if ($db->num_rows($qr_check_id_acc_exist)) {
                    $qr_unlock_acc = "
                    UPDATE accounts SET status = '0'
                    WHERE id_acc = '$id_acc';
                    ";
                    $db->query($qr_unlock_acc);
                }
            }
            $db->close();
        }
        // Mở khóa tài khoản chị định
        elseif ($action == 'unlock_acc') {
            $id_acc = trim(htmlspecialchars(addslashes($_POST['id_acc'])));
            $qr_check_id_acc_exist = "
            SELECT id_acc FROM accounts WHERE id_acc = '$id_acc';
            ";
            if ($db->num_rows($qr_check_id_acc_exist)) {
                $qr_unlock_acc = "
                UPDATE accounts SET status = '0'
                WHERE id_acc = '$id_acc';
                ";
                $db->query($qr_unlock_acc);
                $db->close();
            }
        }
        // Khoá tài khoản
        // Khóa nhiều tài khoản
        elseif ($action == 'lock_acc_list') {
            foreach($_POST['id_acc'] as $key => $id_acc) {
                $qr_check_id_acc_exist = "
                SELECT id_acc FROM accounts WHERE id_acc = '$id_acc';
                ";
                if ($db->num_rows($qr_check_id_acc_exist)) {
                    $qr_lock_acc = "
                    UPDATE accounts SET status = '1'
                    WHERE id_acc = '$id_acc';
                    ";
                    $db->query($qr_lock_acc);
                }
            }
            $db->close();
        }
        // Khóa tài khoản chỉ định
        elseif ($action == 'lock_acc') {
            $id_acc = trim(htmlspecialchars(addslashes($_POST['id_acc'])));
            $qr_check_id_acc_exist = "
            SELECT id_acc FROM accounts WHERE id_acc = '$id_acc';
            ";
            if ($db->num_rows($qr_check_id_acc_exist)) {
                $qr_lock_acc = "
                UPDATE accounts SET status = '1'
                WHERE id_acc = '$id_acc';
                ";
                $db->query($qr_lock_acc);
                $db->close();
            }
        }
        // Xoá tài khoản
        // Xoá nhiều tài khoản cùng lúc     
        else if ($action == 'del_acc_list')
        {
            foreach ($_POST['id_acc'] as $key => $id_acc)
            {
                $sql_check_id_acc_exist = "SELECT id_acc FROM accounts WHERE id_acc = '$id_acc'";
                if ($db->num_rows($sql_check_id_acc_exist))
                {
                    $sql_del_acc = "DELETE FROM accounts WHERE id_acc = '$id_acc'";
                    $db->query($sql_del_acc);
                }
            }   
            $db->close();
        }
        // Xoá 1 tài khoản
        else if ($action == 'del_acc')
        {       
            $id_acc = trim(htmlspecialchars(addslashes($_POST['id_acc'])));
            $sql_check_id_acc_exist = "SELECT id_acc FROM accounts WHERE id_acc = '$id_acc'";
            if ($db->num_rows($sql_check_id_acc_exist))
            {
                $sql_del_acc = "DELETE FROM accounts WHERE id_acc = '$id_acc'";
                $db->query($sql_del_acc);
                $db->close();
            }       
        }   
    }
    else
    {
        new Redirect($_DOMAIN); // Trở về trang index
    }
}
else
{
    new Redirect($_DOMAIN); // Trở về trang index
}
?>