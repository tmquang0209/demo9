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

$id = (int)$_GET['edit'];

$data = $db->query("SELECT * FROM `TMQ_baiviet` WHERE `id` = '$id' LIMIT 1")->fetch();
$bien = explode(PHP_EOL, $data['search']);


if (!$id || $data['id'] == null || $data['username'] != TMQ_user()['username'] || $data['trangthai'] == 'off') {
    header("Location: /admin/account");
}

$filter = $db->query("SELECT `id_cm`,`filter` FROM `TMQ_filter` WHERE `id_cm` = '" . $data['loai'] . "'");

$chuyenmuc = $db->query("SELECT `name` FROM `TMQ_chuyenmuc` WHERE `id` = '" . $data['loai'] . "' LIMIT 1")->fetch();


$chuyenmuc = $chuyenmuc['name'];


if (isset($_POST['edit'])) {

    $taikhoan = TMQ_check($_POST['taikhoan']);
    $matkhau = TMQ_check($_POST['matkhau']);
    $cash = (int)abs($_POST['cash']);
    $thongtin = TMQ_check($_POST['information']);
    $image = TMQ_check($_POST['image']);


    foreach ($filter as $dulieu) {
        $tach = explode(PHP_EOL, $dulieu['filter']);
        if (empty($_POST[TMQ_xoadau($tach[0])])) {
            $res = null;
        } else {
            $res .= $tach[0] . ":" . $_POST[TMQ_xoadau($tach[0])] . "\n";
        }

    }

    if (empty($taikhoan) || empty($matkhau) || empty($cash)) {
        echo '<div class="alert alert-danger"><strong>Danger!</strong> Vui lòng nhập đủ thông tin.</div>';
    } else {
        $db->exec("UPDATE `TMQ_baiviet` SET
        `taikhoan` = " . $db->quote($taikhoan) . ",
        `matkhau` = " . $db->quote($matkhau) . ",
        `cash` = '$cash',
        `thongtin` = " . $db->quote($thongtin) . ",
        `search` = '$res',
        `img` = " . $db->quote($image) . "
        WHERE `id` = '$id'
      ");
        header("Location: /admin/account");
    }
}
?>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Sửa tài khoản #<?= $id; ?></h4>
                <form class="forms-sample" method="POST">
                    <div class="row form-group">
                        <div class="col-3">
                            <label class=" form-control-label">Tài khoản</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="taikhoan" placeholder="Nhập tài khoản ..."
                                       value="<?= $data['taikhoan']; ?>">
                            </div>
                        </div>
                        <div class="col-3">
                            <label>Mật khẩu</label>
                            <input type="text" class="form-control" name="matkhau" placeholder="Nhập mật khẩu"
                                   value="<?= $data['matkhau']; ?>">
                        </div>
                        <div class="col-3">
                            <label>Giá tiền</label>
                            <input type="number" class="form-control" name="cash" placeholder="Nhập giá tiền ..."
                                   value="<?= $data['cash']; ?>">
                        </div>
                        <style>
                            input[type=text]:disabled {
                                background: #2A3038;
                            }
                        </style>
                        <div class="col-3">
                            <label for="">Loại nick</label>
                            <input type="text" class="form-control" name="loai" value="<?= $chuyenmuc; ?>" disabled>
                        </div>
                    </div>
                    <?php


                    $get_filter = $db->query("SELECT `filter` FROM `TMQ_filter` WHERE `id_cm` = '" . $data['loai'] . "'");


                    $dem = $db->query("SELECT `filter` FROM `TMQ_filter` WHERE `id_cm` = '" . $data['loai'] . "'")->rowCount();


                    $j = 1;
                    $e = 0;


                    foreach ($get_filter as $bla => $row) {
                        $j += 3;
                        $e++;
                        $filter = explode(PHP_EOL, $row['filter']);
                        $kq = explode(":", $bien[$bla]);

                        if ($j % 4 == 0) {
                            if ($j != 4) {
                                echo '</div>';
                            }
                            echo '<div class="row form-group">';
                        }
                        if ($filter[1] == 'select') { ?>
                            <div class="col-3">
                                <label><?= $filter[0]; ?></label>
                                <select class="form-control" name="<?= TMQ_xoadau($filter[0]); ?>">
                                    <?php for ($i = 2; $i < count($filter); $i++) { ?>
                                        <option value="<?= $filter[$i]; ?>" <?php echo (trim($filter[$i]) == trim($kq[1])) ? "selected" : null; ?>><?= $filter[$i] . "-" . $kq[1]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php }
                        if ($filter[1] == 'input') { ?>
                            <div class="col-3">
                                <label for=""><?= $filter[0]; ?></label>
                                <input type="text" class="form-control" name="<?= TMQ_xoadau($filter[0]); ?>"
                                       placeholder="Nhập <?= $filter[0]; ?>..." value="<?= $kq[1]; ?>">
                            </div>
                        <?php }
                        if ($e == $dem) {
                            echo "</div>";
                        }
                    }

                    ?>
                    <div class="form-group">
                        <label for="">Nổi bật</label>
                        <textarea class="form-control" name="information" rows="4"><?= $data['thongtin']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Hình ảnh</label>
                        <textarea class="form-control" name="image" rows="4"><?= $data['img']; ?></textarea>
                    </div>


                    <button type="submit" name="edit" class="btn btn-primary mr-2">Sửa</button>

                </form>
            </div>
        </div>
    </div>
</div>
