<?php
/*
        $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
        $$ NAME CODE: SHOP BÁN TỰ ĐỘNG ĐA CHỨC NĂNG             $$
        $$ DEVELOPER: TRẦN MINH QUANG (TMQ)                     $$
        $$ CONTACT: 0397847805 - tmquang0209@gmail.com          $$
        $$ CREATE: 06/2020                                      $$
        $$ VUI LÒNG KHÔNG XÓA BẢN QUYỀN ĐỂ TÔN TRỌNG TÁC GIẢ    $$
        $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
*/
require('../TMQ_sys/function.php');
require('head.php');
if (TMQ_admin() != 9 && TMQ_admin() != 1) {
    header('Location: /');
}
$subcategory = isset($_GET['subcategory']) ? (int)$_GET['subcategory'] : 0;
?>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Quản lý tài khoản </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Quản lý tài khoản</li>
                </ol>
            </nav>
        </div>
        <?php
        if (isset($_GET['edit'])) {
            require("assets/php/edit_account.php");
        }
        if (isset($_POST['del'])) {
            if (isset($_POST['confirm'])) {
                $id = (int)$_POST['del'];
                $db->exec("DELETE FROM `TMQ_baiviet` WHERE `id` = '$id'");
                header('Location: /admin/account');
            }
            isset($_POST['cancel']) ? header("Location: /admin/account") : false;
            echo '<div class="row">
                      <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="card-title">XÁC NHẬN XÓA #' . (int)$_POST['del'] . '</h4>
                            <form class="forms-sample" method="POST">
                              <div class="form-group">
                                <h1 style="color:red;">Sau khi xóa sẽ không thể khôi phục lại!</h1>
                                </div>
                                <input type="hidden" name="del" value="' . (int)$_POST['del'] . '" />
                              <button type="submit" name="confirm" class="btn btn-primary mr-2">Xóa</button>
                              <button class="btn btn-dark" type="submit" name="cancel">Hủy</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    ';
        } ?>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Danh sách</h4>

                        <div class="table-responsive">
                            <table id="bootstrap-data-table" style="text-align:center;"
                                   class="table table-hover table-bordered table-contextual">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Thông tin đăng nhập</th>
                                    <th>Giá tiền</th>
                                    <th>Thông tin</th>
                                    <th>Loại</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $status = array(
                                    'on' => '<label class="badge badge-success">Chưa bán</label>',
                                    'off' => '<label class="badge badge-danger">Đã bán</label>'
                                );
                                $account = $db->query("SELECT * FROM `TMQ_baiviet` WHERE `username` = '" . TMQ_user() ['username'] . "'");
                                foreach ($account as $row) {
                                    $get_category = $db->query("SELECT `name` FROM `TMQ_chuyenmuc` WHERE `id` = '" . $row['loai'] . "'")->fetch();
                                    $get_category = $get_category['name'];
                                    if ($get_category == null) {
                                        $get_category = 'Chuyên mục không tồn tại hoặc đã bị xóa!';
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td>
                                            <p><label>Tài khoản:</label> <?= $row['taikhoan']; ?></p>
                                            <p><label>Mật khẩu:</label> <?= $row['matkhau']; ?></p>
                                        </td>
                                        <td><?= number_format($row['cash']); ?><sup>đ</sup></td>
                                        <td><?php echo TMQ_cut($row['thongtin'], 25); ?></td>
                                        <td><?= $status[$row['trangthai']]; ?></td>
                                        <td><?= $get_category; ?></td>
                                        <td>
                                            <p>
                                                <button onclick="window.location = '?edit=<?= $row['id']; ?>';"
                                                        class="btn btn-outline-secondary btn-icon-text">
                                                    <i class="mdi mdi-file-check btn-icon-append"></i> Sửa
                                                </button>
                                            </p>
                                            <form method="POST">
                                                <p>
                                                    <button type="submit" name="del" value="<?= $row['id']; ?>"
                                                            class="btn btn-outline-danger btn-icon-text">
                                                        <i class="mdi mdi-delete btn-icon-prepend"></i> Xóa
                                                    </button>
                                                </p>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <?php require('foot.php'); ?>
