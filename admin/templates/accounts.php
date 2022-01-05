<?php

if ($user) {
    
    // Nếu là tác giả
    if ($data_user['position'] == 0) {
        echo '<div class="alert alert-danger">Bạn không có quyền để truy cập vào trang này</div>';
    }
    // Nếu là admin

    elseif ($data_user['position'] == 1) {
        echo '<h3>Tài khoản</h3>';

        if(isset($_GET['ac'])) {
            $ac = trim(addslashes(htmlspecialchars($_GET['ac'])));
        } else {
            $ac = '';
        }
        if(isset($_GET['id'])) {
            $id = trim(addslashes(htmlspecialchars($_GET['id'])));
        } else {
            $id = '';
        }

        // Nếu có tham số ac
        if ($ac != '') {
            if ($ac = 'add') {
                // Dãy nút của thêm tài khoản
                echo
                '
                    <a href="' . $_DOMAIN . 'accounts" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span> Trở về
                    </a> 
                ';
      
                // Content thêm tài khoản
                echo 
                '
                <p class="form-add-acc">
                    <form action="" method="POST" id="formAddAcc" onsubmit="return false;">
                        <div class="form-group">
                            <label for="user_add_acc">Tên đăng nhập</label>
                            <input type="text" class="form-control title" id="user_add_acc">
                        </div>
                        <div class="form-group">
                            <label for="pw_add_acc">Mật khẩu</label>
                            <input type="password" class="form-control title" id="pw_add_acc">
                        </div>
                        <div class="form-group">
                            <label for="repw_add_acc">Nhập lại mật khẩu</label>
                            <input type="password" class="form-control title" id="repw_add_acc">
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="position_add_acc" value="0" checked class="position_add_acc_1"> Tác giả
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="position_add_acc" value="1" class="position_add_acc_2"> Quản trị viên
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái tài khoản</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status_add_acc" value="0" checked class="status_add_acc_1"> Bình thường
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status_add_acc" value="1" class="status_add_acc_2"> Khóa
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </div>
                        <div class="alert alert-danger hidden"></div>
                    </form>
                </p>
                ';
            }
        }
        // Không có tham số ac, in danh sách tài khoản
        else {
            // Dãy nút của danh sách tài khoản
            echo
            '
                <a href="' . $_DOMAIN . 'accounts/add" class="btn btn-default">
                    <span class="glyphicon glyphicon-plus"></span> Thêm
                </a> 
                <a href="' . $_DOMAIN . 'accounts" class="btn btn-default">
                    <span class="glyphicon glyphicon-repeat"></span> Reload
                </a>
                <a class="btn btn-warning" id="lock_acc_list">
                    <span class="glyphicon glyphicon-lock"></span> khoá
                </a>
                <a class="btn btn-success" id="unlock_acc_list">
                    <span class="glyphicon glyphicon-lock"></span> Mở khoá
                </a> 
                <a class="btn btn-danger" id="del_acc_list">
                    <span class="glyphicon glyphicon-trash"></span> Xoá
                </a> 
            ';

            // Content danh sách tài khoản
            $qr_get_list_acc = "
            SELECT * FROM accounts
            ORDER BY id_acc DESC;
            ";
            if ($db->num_rows($qr_get_list_acc)) {
                echo '
                <br><br>
                <div class="table-responsive">
                    <table class="table table-striped list" id="list_acc">
                        <tr>
                            <td><input type="checkbox"></td>
                            <td><strong>ID</strong></td>
                            <td><strong>Tên đăng nhập</strong></td>
                            <td><strong>Trạng thái</strong></td>
                            <td><strong>Tools</strong></td>
                        </tr>
                ';

                //in danh sach tài khoản
                foreach($db->fetch_assoc($qr_get_list_acc, 1) as $key => $data_acc) {

                    // Trạng thái tài khoản
                    if ($data_acc['status'] == 0) {
                        $stt_acc = '<label class="label label-success">Hoạt động</label>';
                    } elseif($data_acc['status'] == 1) {
                        $stt_acc = '<label class="label label-warning">Khoá</label>';
                    }

                    echo
                    '
                    <tr>
                        <td><input type="checkbox" name="id_acc[]" value="' . $data_acc['id_acc'] .'"></td>
                        <td>' . $data_acc['id_acc'] .'</td>
                        <td>' . $data_acc['username'] . '</td>
                        <td>' . $stt_acc . '</td>
                        <td>
                            <a data-id="' . $data_acc['id_acc'] . '" class="btn btn-sm btn-warning lock-acc-list">
                                <span class="glyphicon glyphicon-lock"></span>
                            </a>
                            <a data-id="' . $data_acc['id_acc'] . '" class="btn btn-sm btn-success unlock-acc-list">
                                <span class="glyphicon glyphicon-lock"></span>
                            </a>
                            <a data-id="' . $data_acc['id_acc'] . '" class="btn btn-sm btn-danger del-acc-list">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </td>
                    </tr>
                    ';
                }
                echo
                '
                        </table>
                    </div>
                ';
            }
            // Nếu không có tài khoản
            else
            {
                echo '<br><br><div class="alert alert-info">Chưa có tài khoản nào.</div>';
            }
        }
    }
}

// Ngược lại chưa đăng nhập
else
{
    new Redirect($_DOMAIN); // Trở về trang index
}
?>