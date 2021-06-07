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
require('../TMQ_sys/head.php');
$id = $_GET['id'] ?? null;
$get = $db->query("SELECT `id`,`name`,`notification` FROM `TMQ_chuyenmuc` WHERE `loai` = '1' AND `status` = 'on' AND `id` = '$id' LIMIT 1")->fetch();
$get_filter = $db->query("SELECT `filter` FROM `TMQ_filter` WHERE `id_cm` = '$id'");
if ($get['id'] == null) {
    header('Location: /404.html');
}
?>

<div class="c-layout-page">

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info" role="alert">
                    <h2 class="alert-heading"><?= $get['name']; ?></h2>
                    <p><?php echo $get['notification']; ?></p>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 15px">
            <div class="m-l-10 m-r-10">
                <form class="form-inline m-b-10" role="form" method="POST">
                    <div class="col-md-3 col-sm-4 p-5 field-search">
                        <div class="input-group c-square">
                            <span class="input-group-addon">Tìm kiếm</span>
                            <input type="text" class="form-control c-square" value="" placeholder="Tìm kiếm"
                                   name="find">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 p-5 field-search">
                        <div class="input-group c-square">
                            <span class="input-group-addon">Mã số</span>
                            <input type="number" class="form-control c-square" value="" placeholder="Mã số" name="id">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12  p-5 field-search">
                        <div class="input-group c-square">
                            <span class="input-group-addon">Giá tiền</span>
                            <select style="" class="form-control c-square" name="price">
                                <option value="">Chọn giá tiền</option>
                                <option value="0;50000">Dưới 50K</option>
                                <option value="50000;200000">Từ 50K - 200K</option>
                                <option value="200000;500000">Từ 200K - 500K</option>
                                <option value="500000;1000000">Từ 500K - 1 Triệu</option>
                                <option value="1000000">Trên 1 Triệu</option>
                                <option value="5000000">Trên 5 Triệu</option>
                                <option value="10000000">Trên 10 Triệu</option>
                            </select>
                        </div>
                    </div>
                    <?php
                    foreach ($get_filter as $f) {
                        $filter = explode(PHP_EOL, $f['filter']);
                        if ($filter[1] == 'select') {
                            ?>
                            <div class="col-md-3 col-sm-4 col-xs-12  p-5 field-search">
                                <div class="input-group c-square">
                                    <span class="input-group-addon"><?= $filter[0]; ?></span>
                                    <select name="search_<?= TMQ_xoadau($filter[0]); ?>" class="form-control c-square"
                                            title="-- Không chọn --">
                                        <option value="">-- Không chọn --</option>
                                        <?php for ($i = 2; $i <= count($filter) - 1; $i++) { ?>
                                            <option value="<?= $filter[$i]; ?>"><?= $filter[$i]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-3 col-sm-4 p-5 field-search">
                                <div class="input-group c-square">
                                    <span class="input-group-addon"><?= $filter[0]; ?></span>
                                    <input name="search_<?= TMQ_xoadau($filter[0]); ?>" type="text"
                                           class="form-control c-square" value="" placeholder="<?= $filter[0]; ?>">
                                </div>
                            </div>
                        <?php }
                    } ?>


                    <div class="col-md-3 col-sm-4 p-5 no-radius">
                        <button type="submit" name="submit" class="btn c-square c-theme c-btn-green">Tìm kiếm</button>
                        <a class="btn c-square m-l-0 btn-danger" href="<?= $_SERVER['REQUEST_URI']; ?>">Tất cả</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="row row-flex  item-list">
            <?php
            $limit = TMQ_setting()['limit_page'];
            if (isset($_GET["page"])) {
                $page = $_GET["page"];
                settype($page, "int");
            } else {
                $page = 1;
            }
            $from = ($page - 1) * $limit;
            if (isset($_POST['submit'])) {
                //tìm kiếm nổi bật
                $search_noibat = TMQ_check($_POST['find']);
                if ($search_noibat) {
                    $search_noibat = "AND `thongtin` LIKE '%$search_noibat%'";
                }
                //tìm kiếm theo id
                $search_id = (int)$_POST['id'];
                if ($search_id) {
                    $search_id = "AND `id` LIKE '%$search_id%'";
                } else {
                    $search_id = "";
                }
                //tìm kiếm theo giá tiền
                $price = TMQ_check($_POST['price']);
                if ($price) {
                    $price = explode(";", $price);
                    if ($price[1] != null) {
                        $price = "AND `cash` BETWEEN " . (int)$price['0'] . " AND " . (int)$price[1] . "";
                    } else {
                        $price = "AND `cash` >= " . (int)$price['0'] . "";
                    }
                }
                //lọc thông tin
                $get1 = $db->query("SELECT * FROM `TMQ_filter` WHERE `id_cm` = '$id'");

                foreach ($get1 as $s) {
                    $f = explode(PHP_EOL, $s['filter']);
                    if (trim($_POST['search_' . TMQ_xoadau($f[0])]) != null) {
                        $post .= $f[0] . ":" . TMQ_check($_POST['search_' . TMQ_xoadau($f[0])]) . "\n";
                    }
                }
                if ($post) {
                    $search_filter = "AND `search` LIKE '%$post%'";
                }
//kết thúc lọc thông tin
                $get_account = $db->query("SELECT `id`,`thongtin`,`search`,`img`,`cash` FROM `TMQ_baiviet` WHERE `loai` = '$id' AND `trangthai` = 'on' $search_noibat $search_id $price $search_filter LIMIT $from,$limit");
            } else {
                $get_account = $db->query("SELECT `id`,`thongtin`,`search`,`img`,`cash` FROM `TMQ_baiviet` WHERE `loai` = '$id' AND `trangthai` = 'on' LIMIT $from,$limit");
            }
            foreach ($get_account as $row) {
                $thumb = explode(PHP_EOL, $row['img']);
                $thumb = $thumb[0];
                ?>
                <div class="col-sm-6 col-md-3">
                    <div class="classWithPad">
                        <div class="image">
                            <a href="/acc/<?= $row['id']; ?>">

                                <img src="<?= get_upload_url('account', $thumb); ?>">
                                <span class="ms">MS: <?= $row['id']; ?></span>
                            </a>
                        </div>
                        <div class="description">
                            <?= TMQ_cut($row["thongtin"], 40); ?>
                        </div>
                        <div class="attribute_info">
                            <div class="row">
                                <?php for ($i = 0; $i < 4; $i++) {
                                    $x = explode(PHP_EOL, $row['search']);
                                    $z = $x[$i];
                                    $s = explode(":", $z);
                                    ?>
                                    <div class="col-xs-6 a_att">
                                        <?= $s[0]; ?>: <b><?= $s[1]; ?></b>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="a-more">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="price_item">
                                        <?= number_format($row['cash']); ?>đ
                                    </div>
                                </div>
                                <div class="col-xs-6 ">
                                    <div class="view">
                                        <a href="/acc/<?= $row['id']; ?>">Chi tiết</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
        <div class="col-md-12">
            <?php
            $tong = $db->query("SELECT * FROM `TMQ_baiviet` WHERE `loai` = '$id' AND `trangthai` = 'on'")->rowcount();
            $link = '' . TMQ_xoadau($get['name']) . '-' . $id . '-';
            if ($tong > $sotin1trang) {
                echo '<center>' . TMQ_phantrang($link, $from, $tong, $limit) . '</center>';
            } ?>
        </div>
    </div>
</div>
</div>
</div>
<?php
require('../TMQ_sys/foot.php');
?>
