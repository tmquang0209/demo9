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
if (TMQ_admin() != 9) {
    header('Location: /');
}
$subcategory = isset($_GET['sub']) ? (int)$_GET['sub'] : 0;
?>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Quản lý danh mục </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Quản lý danh mục</li>
                </ol>
            </nav>
        </div>
        <?php
        if (isset($_POST['status'])) {
            $id = $_POST['status'];
            $check = $db->query("SELECT `status` FROM `TMQ_chuyenmuc` WHERE `id` = '$id'")->fetch();
            if ($check['status'] == 'on') {
                $db->exec("UPDATE `TMQ_chuyenmuc` SET `status` = 'off' WHERE `id` = '$id'");
            } elseif ($check['status'] == 'off') {
                $db->exec("UPDATE `TMQ_chuyenmuc` SET `status` = 'on' WHERE `id` = '$id'");
            }
        }
        if (isset($_POST['del'])) {
            if (isset($_POST['confirm'])) {
                $id = (int)$_POST['del'];
                $db->exec("DELETE FROM `TMQ_chuyenmuc` WHERE `id` = '$id'");
                $db->exec("DELETE FROM `TMQ_chuyenmuc` WHERE `id_cmm` = '$id'");
                header('Location: /admin/category');
            }
            if (isset($_POST['cancel'])) {
                header('Location: /admin/category');
            }
            echo '<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">XÁC NHẬN XÓA #' . (int)$_POST['del'] . '</h4>
                    <form class="forms-sample" method="POST">
                      <div class="form-group">
                        <p><h1 style="color:red;">Nếu xóa, mọi chuyên mục con đều bị xóa và không thể khôi phục lại!</h1></p>
                        <p><h1 style="color:red;">Đối với chuyên mục con sau khi xóa, account sẽ vẫn lưu trên hệ thống!</h1></p>
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
        }
        if (isset($_POST['edit'])) {
            $get = $db->query("SELECT `name`,`id_cmm`, `notification` FROM `TMQ_chuyenmuc` WHERE `id` = '" . TMQ_check($_POST['edit']) . "'")->fetch();
            if (isset($_POST['confirm'])) {
                $name = TMQ_check($_POST['name']);
                $id = (int)$_POST['edit'];
                $back_url = TMQ_check($_POST['back_url']);
                $db->exec("UPDATE `TMQ_chuyenmuc` SET `name` = " . $db->quote($name) . ", `notification` = " . $db->quote($_POST['notification']) . " WHERE `id` = '$id'");
                header("Location: $back_url");
            }
            ?>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Sửa #<?= (int)$_POST['edit']; ?></h4>
                            <form class="forms-sample" method="POST">
                                <div class="form-group">
                                    <label>Tên chuyên mục</label>
                                    <input type="text" class="form-control" placeholder="Category name" name="name"
                                           value="<?= $get['name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Loại</label>
                                    <select class="js-example-basic-single" style="width:100%" name="species">
                                        <option value="0" <?php if ($subcategory == 0) {
                                            echo 'selected';
                                        } ?>>Chuyên mục mẹ
                                        </option>
                                        <?php $get_cm = $db->query("SELECT `id`,`name`,`id_cmm` FROM `TMQ_chuyenmuc` WHERE `loai` = '0' AND `id_cmm` = '0' AND `status` = 'on'");
                                        foreach ($get_cm as $r) {
                                            ?>
                                            <option value="<?= $r['id_cmm']; ?>"<?php if ($get['id_cmm'] == $r['id']) {
                                                echo 'selected';
                                            } ?>><?= $r['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="notification">Thông báo </label>
                                    <textarea class="form-control" name="notification" id="notification" cols="30"
                                              rows="10"><?= $get['notification']; ?></textarea>
                                </div>
                                <input type="hidden" name="back_url" value="<?= $_SERVER['REQUEST_URI']; ?>"/>
                                <input type="hidden" name="edit" value="<?= (int)$_POST['edit']; ?>"/>
                                <button type="submit" name="confirm" class="btn btn-primary mr-2">Sửa</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        }
        if (isset($_GET['add'])) {
            if (isset($_POST['add'])) {
                $name = TMQ_check($_POST['name']);
                $species = (int)$_POST['species'];
                $img = TMQ_check($_FILES['image']);

                if ($species == 0) {
                    $loai = 0;
                } else {
                    $loai = 1;
                }
                if ($_FILES['image']) {
                    $imageUpload = upload_file('categories', $_FILES['image']);
                } else {
                    $imageUpload = [
                        'success' => false,
                        'file_name' => 'https://demo9.tmquang.monster/images/no_image.png'
                    ];
                }
                if (!empty($name)) {

                    $db->exec("INSERT INTO `TMQ_chuyenmuc`
            (`name`, `image`, `notification`, `loai`, `id_cmm`, `status`, `date`)
            VALUES
            (" . $db->quote($name) . "," . $db->quote($imageUpload['file_name']) . "," . $db->quote($_POST['notification']) . "," . $db->quote($loai) . "," . $db->quote($species) . ",'on','" . date("d-m-Y") . "')
            ");
                    header('Location: /admin/category');
                }
            }
            ?>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tạo chuyên mục</h4>
                            <form class="forms-sample" enctype="multipart/form-data" method="POST">
                                <div class="form-group">
                                    <label>Tên chuyên mục</label>
                                    <input type="text" class="form-control" placeholder="Category name" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="image">Hình ảnh</label>
                                    <input type="file" class="form-control" placeholder="Image name" name="image"
                                           id="image">
                                </div>
                                <div class="form-group">
                                    <label>Loại</label>
                                    <select class="js-example-basic-single" style="width:100%" name="species">
                                        <option value="0">Chuyên mục mẹ</option>
                                        <?php $get_cm = $db->query("SELECT id,name FROM `TMQ_chuyenmuc` WHERE `loai` = '0' AND `id_cmm` = '0' AND `status` = 'on'");
                                        foreach ($get_cm as $r) {
                                            ?>
                                            <option value="<?= $r['id']; ?>"><?= $r['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="notification">Thông báo </label>
                                    <textarea class="form-control" name="notification" id="notification" cols="30"
                                              rows="10"></textarea>
                                </div>
                                <button type="submit" name="add" class="btn btn-primary mr-2">Tạo</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php
        if ($subcategory == 0){
        ?>
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
                                    <th>Tên chuyên mục</th>
                                    <th>Chuyên mục con</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $status = array(
                                    'on' => '<label class="badge badge-success">Hoạt động</label>',
                                    'off' => '<label class="badge badge-danger">Không hoạt động</label>'
                                );
                                $category = $db->query("SELECT `id`,`name`,`loai`,`id_cmm`,`status`,`date` FROM `TMQ_chuyenmuc` WHERE `loai` = '0' AND `id_cmm` = '0'");
                                foreach ($category as $row) {
                                    $on = $db->query("SELECT `id` FROM `TMQ_chuyenmuc` WHERE `id_cmm` = '" . $row['id'] . "' AND `loai` = '1' AND `status` = 'on'")->rowCount();
                                    $off = $db->query("SELECT `id` FROM `TMQ_chuyenmuc` WHERE `id_cmm` = '" . $row['id'] . "' AND `loai` = '1' AND `status` = 'off'")->rowCount();
                                    ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><a href="?sub=<?= $row['id']; ?>"><?= $row['name']; ?></a></td>
                                        <td>
                                            <p><label class="badge badge-success">Đang HĐ: <?= $on; ?></label></p>
                                            <p><label class="badge badge-danger">Đang tắt: <?= $off; ?></label></p>
                                        </td>
                                        <td><?= $status[$row['status']]; ?></td>
                                        <td><?= $row['date']; ?></td>
                                        <td class="dropdown">
                                            <form method="POST">
                                                <p>
                                                    <button type="submit" name="edit" value="<?= $row['id']; ?>"
                                                            class="btn btn-outline-secondary btn-icon-text">
                                                        <i class="mdi mdi-file-check btn-icon-append"></i> Sửa
                                                    </button>
                                                </p>
                                                <p>
                                                    <button type="submit" name="status" value="<?= $row['id']; ?>"
                                                            class="btn btn-outline-success btn-icon-text">
                                                        <i class="mdi mdi-reload btn-icon-prepend"></i> Trạng thái
                                                    </button>
                                                </p>
                                                <p>
                                                    <button type="submit" name="del" value="<?= $row['id']; ?>"
                                                            class="btn btn-outline-danger btn-icon-text">
                                                        <i class="mdi mdi-delete btn-icon-prepend"></i> Xóa
                                                    </button>
                                                </p>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php }
                else{
                $get_name = $db->query("SELECT `name` FROM `TMQ_chuyenmuc` WHERE `id` = '" . (int)$_GET['sub'] . "'")->fetch();
                $get_name = $get_name['name'];
                ?>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Chuyên mục trong <?= $get_name; ?></h4>

                                <div class="table-responsive">
                                    <table id="bootstrap-data-table" style="text-align:center;"
                                           class="table table-hover table-bordered table-contextual">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên chuyên mục</th>
                                            <th>Thống kê</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $status = array(
                                            'on' => '<label class="badge badge-success">Hoạt động</label>',
                                            'off' => '<label class="badge badge-danger">Không hoạt động</label>'
                                        );
                                        $category = $db->query("SELECT `id`,`name`,`loai`,`id_cmm`,`status`,`date` FROM `TMQ_chuyenmuc` WHERE `loai` = '1' AND `id_cmm` = '" . (int)$_GET['sub'] . "'");
                                        foreach ($category as $row) {
                                            $on = $db->query("SELECT `id` FROM `TMQ_baiviet` WHERE `loai` = '" . $row['id'] . "' AND `trangthai` = 'on'")->rowCount();
                                            $off = $db->query("SELECT `id` FROM `TMQ_baiviet` WHERE `loai` = '" . $row['id'] . "' AND `trangthai` = 'off'")->rowCount();
                                            ?>
                                            <tr>
                                                <td><?= $row['id']; ?></td>
                                                <td><?= $row['name']; ?></td>
                                                <td>
                                                    <p><label class="badge badge-success">Đang bán: <?= $on; ?></label>
                                                    </p>
                                                    <p><label class="badge badge-danger">Đã bán: <?= $off; ?></label>
                                                    </p>
                                                </td>
                                                <td><?= $status[$row['status']]; ?></td>
                                                <td><?= $row['date']; ?></td>
                                                <td>
                                                    <form method="POST">
                                                        <p>
                                                            <button type="submit" name="edit" value="<?= $row['id']; ?>"
                                                                    class="btn btn-outline-secondary btn-icon-text">
                                                                <i class="mdi mdi-file-check btn-icon-append"></i> Sửa
                                                            </button>
                                                        </p>
                                                        <p>
                                                            <button type="submit" name="status"
                                                                    value="<?= $row['id']; ?>"
                                                                    class="btn btn-outline-success btn-icon-text">
                                                                <i class="mdi mdi-reload btn-icon-prepend"></i> Trạng
                                                                thái
                                                            </button>
                                                        </p>
                                                        <p>
                                                            <button type="submit" name="del" value="<?= $row['id']; ?>"
                                                                    class="btn btn-outline-danger btn-icon-text">
                                                                <i class="mdi mdi-delete btn-icon-prepend"></i> Xóa
                                                            </button>
                                                        </p>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- content-wrapper ends -->
            <?php
            require('foot.php');
            ?>
