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
require ("../TMQ_sys/function.php");
require ("../TMQ_sys/head.php");
require ("menu.php");
?>
<div class="c-layout-sidebar-content ">


<div class="c-content-title-1">
<h3 class="c-font-uppercase c-font-bold">Lịch sử giao dịch</h3>
<div class="c-line-left"></div>
</div>
<form class="form-horizontal form-find m-b-20" role="form" method="POST">
<div class="row">
<div class="col-md-4">
<div class="input-group m-b-10 c-square">
<div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-rtl="false">
<span class="input-group-btn">
<button class="btn default c-btn-square p-l-10 p-r-10" type="button"><i class="fa fa-calendar"></i></button>
</span>
<input type="text" class="form-control c-square c-theme" name="started_at" autocomplete="off" placeholder="Từ ngày" value="<?=$_POST['started_at']; ?>">
</div>
</div>
</div>
<div class="col-md-4">
<div class="input-group m-b-10 c-square">
<div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-rtl="false">
<span class="input-group-btn">
<button class="btn default c-btn-square p-l-10 p-r-10" type="button"><i class="fa fa-calendar"></i></button>
</span>
<input type="text" class="form-control c-square c-theme" name="ended_at" autocomplete="off" placeholder="Đến ngày" value="<?=$_POST['ended_at']; ?>">
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-4">
<input type="submit" class="btn c-theme-btn c-btn-square m-b-10" name="submit" value="Tìm kiếm">
<a class="btn c-btn-square m-b-10 btn-danger" href="/profile/history">Tất cả</a>
</div>
</div>
</form>
<table class="table table-hover table-custom-res">
<tbody>
<tr>
<th>Thời gian</th>
<th>ID</th>
<th>Nội dung</th>
<th>Giao dịch</th>
<th>Số tiền</th>
<th>Số dư cuối</th>
</tr>
</tbody>
<tbody>
<?php
$limit = 10;
if (isset($_GET["page"]))
{
    $page = $_GET["page"];
    settype($page, "int");
}
else
{
    $page = 1;
}
$from = ($page - 1) * $limit;
if (isset($_POST['submit']))
{
    $started_at = TMQ_check($_POST['started_at']);
    $ended_at = TMQ_check($_POST['ended_at']);
    if ($started_at > 0)
    {
        $started = "AND `time` >= '" . strtotime($started_at) . "'";
    }
    if ($ended_at > 0)
    {
        $ended = "AND `time` <= '" . strtotime($ended_at) . "'";
    }
    $data = $db->query("SELECT * FROM `TMQ_history` WHERE `buyer` = '" . TMQ_user() ['username'] . "' $started $ended LIMIT $from,$limit");
}
else
{
    $data = $db->query("SELECT * FROM `TMQ_history` WHERE `buyer` = '" . TMQ_user() ['username'] . "' LIMIT $from,$limit");
}
foreach ($data as $row)
{
    if($row['loai'] == 'muanick'){
    $info = explode(PHP_EOL, $row['infomation']);
    $info = 'Mua thành công tài khoản '.$info[3];
    }else{
    $info = $row['infomation'];
    }
?>
    <tr>
        <td><?=date("H:i:s d-m-Y", $row['time']); ?></td>
        <td><?=$row['id']; ?></td>
        <td><?=$info; ?></td>
        <td><?=$row['loai']; ?></td>
        <td><?=number_format($row['cash']); ?><sup>đ</sup></td>
        <td><?=number_format($row['sodu']); ?><sup>đ</sup></td>
        
    </tr>
    <?php
}
?>
</tbody>
</table>

<div class="data_paginate paging_bootstrap paginations_custom" style="text-align: center">
<?php
$tong = $db->query("SELECT `id` FROM `TMQ_history` WHERE `buyer` = '" . TMQ_user() ['username'] . "'")
    ->rowcount();
if ($tong > $sotin1trang)
{
    echo '<center>' . TMQ_phantrang('/profile/history?', $from, $tong, $limit) . '</center>';
} ?>
</div>
</div>
</div>
</div>
<?php
require ("../TMQ_sys/foot.php");
?>
