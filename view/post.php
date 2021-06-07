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
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$get = $db->query("SELECT * FROM `TMQ_baiviet` WHERE `trangthai` = 'on' AND `id` = '$id' LIMIT 1")->fetch();
$category_name = $db->query("SELECT `name` FROM `TMQ_chuyenmuc` WHERE `id` = '".$get['loai']."'")->fetch();
$category_name = $category_name['name'];
if($get['id'] == null){
     header('Location: /404.html');
}
?>

<div class="c-layout-page">

<div class="c-content-box c-size-lg c-overflow-hide c-bg-white">
<div class="container">
<div class="c-shop-product-details-4">
<div class="row">
<div class="col-md-4 m-b-20">
<div class="c-product-header">

<div class="c-content-title-1">
<h3 class="c-font-uppercase c-font-bold">#<?=$id;?></h3>
<span class="c-font-red c-font-bold"><?=$category_name;?></span>
</div>
</div>
</div>
<div class="col-sm-12 visible-sm visible-xs visible-sm">
<div class="text-center m-t-20">
<img class="img-responsive img-thumbnail" src="/storage/images/jxCnUnEMvj_1560847203.jpg" />
</div>
<div class="c-product-meta">
<div class="c-content-divider">
<i class="icon-dot"></i>
</div>
<div class="row">
<?php
$search = explode(PHP_EOL,$get['search']);
foreach($search as $value){
$result = explode(":",$value);
if($key < count($search)-1){
?>    
<div class="col-sm-4 col-xs-6 c-product-variant">
<p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold"><?=$result[0];?>: <span class="c-font-red"><?=$result[1];?></span></p>
</div>
<?php 
} }
?>
<div class="col-sm-12 col-xs-12 c-product-variant">
<p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">Nổi bật: <span class="c-font-red"><?=$get['thongtin'];?></span></p>
</div>
</div>
<div class="c-content-divider">
<i class="icon-dot"></i>
</div>
</div>
</div>
<div class="col-md-4">
<div class="c-product-meta">
<div class="c-product-price c-theme-font" style="float: none;text-align: center"><?=number_format($get['cash']);?> ATM<br />
<?=number_format($get['cash']);?> CARD
</div>
</div>
</div>
<div class="col-md-4 text-right">
<div class="c-product-header">
<div class="c-content-title-1">
<button type="button" class="btn c-btn btn-lg c-theme-btn c-font-uppercase c-font-bold c-btn-square m-t-20 load-modal" rel="/buyacc/<?=$id;?>">Mua ngay</button>
<button type="button" class="btn c-btn btn-lg c-bg-green-4 c-font-white c-font-uppercase c-font-bold c-btn-square m-t-20 load-modal" rel="/atm">ATM - Ví điện tử</button>
<a class="btn c-btn btn-lg c-bg-green-4 c-font-white c-font-uppercase c-font-bold c-btn-square m-t-20" href="/nap-the">Nạp thẻ cào</a>
</div>
</div>
</div>
</div>
<div class="c-product-meta visible-md visible-lg">
<div class="c-content-divider">
<i class="icon-dot"></i>
</div>
<div class="row">
<?php
foreach($search as $key => $value){
$result = explode(":",$value);
if($key < count($search)-1){
?>    
<div class="col-sm-4 col-xs-6 c-product-variant">
<p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold"><?=$result[0];?>: <span class="c-font-red"><?=$result[1];?></span></p>
</div>
<?php 
} }
?>
<div class="col-sm-12 col-xs-12 c-product-variant">
<p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">Nổi bật: <span class="c-font-red"><?=$get['thongtin'];?></span></p>
</div>
</div>
<div class="c-content-divider">
<i class="icon-dot"></i>
</div>
</div>
</div>
</div>
<div class="container m-t-20 content_post">
<?php
$img = explode(PHP_EOL,$get['img']);
foreach($img as $row){
?>
<p>
<img src="<?=$img[0];?>" class="zoom">
</p>
<?php 
}
?>
<div class="buy-footer" style="text-align: center">
</div>
</div>
<div class="container m-t-20 ">
<div class="game-item-view" style="margin-top: 40px">
<div class="c-content-title-1">
<h3 class="c-center c-font-uppercase c-font-bold">Tài khoản liên quan</h3>
<div class="c-line-center c-theme-bg"></div>
<div class="row row-flex  item-list">
<?php
$acc_lienquan = $db->query("SELECT `id`,`thongtin`,`search`,`img`,`cash` FROM `TMQ_baiviet` WHERE `loai` = '".$get['loai']."' AND `cash` LIKE '%".$get['cash']."%' AND `id` != '$id' ORDER BY RAND () LIMIT 4");
foreach($acc_lienquan as $lq){
$thumb = explode(PHP_EOL,$lq['img']);
$thumb = $thumb[0];
?>
<div class="col-sm-6 col-md-3">
<div class="classWithPad">
<div class="image">
<a href="/acc/<?=$lq['id'];?>">
<img src="<?=$thumb;?>">
<span class="ms">MS: <?=$lq['id'];?></span>
</a>
</div>
<div class="description">
<?=TMQ_cut($lq["thongtin"],40);?></div>
<div class="attribute_info">
<div class="row">
  <div class="row">
<?php for($i = 0;$i < 4;$i++){
$x = explode(PHP_EOL,$lq['search']);
$z = $x[$i];
$s = explode(":",$z);
?>    
<div class="col-xs-6 a_att">
<?=$s[0];?>: <b><?=$s[1];?></b>
</div>
<?php } ?>
</div>
</div>
<div class="a-more">
<div class="row">
<div class="col-xs-6">
<div class="price_item">
<?=number_format($lq['cash']);?>đ
</div>
</div>
<div class="col-xs-6 ">
<div class="view">
<a href="/acc/<?=$lq['id'];?>">Chi tiết</a>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
<?php
require("../TMQ_sys/foot.php");
?>