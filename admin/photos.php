<?php
require_once 'core/init.php';

// Nếu đăng nhập
if ($user) {
    if (isset($_FILES['img_up'])) {
        foreach ($_FILES['img_up']['name'] as $name => $value) {
            $dir = '../uploads/';
            $name_img = stripslashes($_FILES['img_up']['name'][$name]);
            $source_img = $_FILES['img_up']['tmp_name'][$name];

            // Lấy ngày tháng năm hiện tại
            $day_current = substr($date_current, 8, 2);
            $month_current = substr($date_current, 5, 2);
            $year_current = substr($date_current, 0, 4);

            // Tạo folder năm hiện tại
            if(!is_dir($dir.$year_current)) {
                mkdir($dir.$year_current.'/');
            }

            // Tạo folder tháng hiện tại
            if (!is_dir($dir.$year_current.'/'.$month_current))
            {
                mkdir($dir.$year_current.'/'.$month_current.'/');
            }   
 
            // Tạo folder ngày hiện tại
            if (!is_dir($dir.$year_current.'/'.$month_current.'/'.$day_current))
            {
                mkdir($dir.$year_current.'/'.$month_current.'/'.$day_current.'/');
            }

            // đường dẫn chứa file ảnh
            $path_img = $dir.$year_current.'/'.$month_current.'/'.$day_current.'/'.$name_img;
            move_uploaded_file($source_img, $path_img); // Upload file
            $type_img = explode("/", $_FILES['img_up']['type'][$name]);
            $type_img = array_pop($type_img); // loại file
            $url_img = substr($path_img, 3); // dường dẫn file
            $size_img = $_FILES['img_up']['size'][$name];
            $uploader_id = $data_user['id_acc'];

            // Thêm dữ liệu vào table
            $qr_up_file = "
            INSERT INTO images VALUES (
                '',
                '$url_img',
                '$type_img',
                '$size_img',
                '$uploader_id',
                '$date_current'
            )
            ";
            $db->query($qr_up_file);
        }
        echo "Upload thành công.";
        $db->close();
        new Redirect($_DOMAIN.'photos');

    }

    // Nếu tồn tại POST action
    elseif (isset($_POST['action'])) {
        $action = trim(addslashes(htmlspecialchars($_POST['action'])));

        // Xóa nhiều ảnh
        if ($action == 'del_img_list') {
            foreach($_POST['id_img'] as $key => $id_img) {
                $qr_check_id_img_exist = "
                SELECT * FROM images
                WHERE id_img = '$id_img';
                ";
                if ($db->num_rows($qr_check_id_img_exist)) {
                    $data_img = $db->fetch_assoc($qr_check_id_img_exist, 0);
                    if (file_exists('../'.$data_img['url'])) {
                        unlink('../'.$data_img['url']);
                    }
                    $qr_delete_img = "
                    DELETE FROM images WHERE id_img = '$id_img';
                    ";
                    $db->query($qr_delete_img);
                }
            }
            $db->close();
        }

        // Xóa ảnh chỉ định
        elseif($action == 'delete_img') {
            $id_img = trim(addslashes(htmlspecialchars($_POST['id_img'])));
            $qr_check_id_img_exist = "
            SELECT * FROM images WHERE id_img = '$id_img';
            ";
            if ($db->num_rows($qr_check_id_img_exist)) {
                $data_img = $db->fetch_assoc($qr_check_id_img_exist, 0);
                if (file_exists('../'.$data_img['url']))
                {
                    unlink('../'.$data_img['url']);
                }
        
                $qr_delete_img = "
                DELETE FROM images WHERE id_img = '$id_img'";
                $db->query($qr_delete_img);
                $db->close();
            }
        }
    }
    else {
        new Redirect($_DOMAIN.'photos');
    }
}
// Ngược lại chưa đăng nhập
else
{
    new Redirect($_DOMAIN); // Trở về trang index
}
?>