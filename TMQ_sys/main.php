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
?>
<div class="c-layout-page">

<div class="c-content-box">
<div id="slider" class="owl-theme section section-cate slideshow_full_width ">
<div id="slide_banner" class="owl-carousel">
<?php
$banner = explode(PHP_EOL,TMQ_setting()['banner']);
foreach($banner as $row)
{
?>
<div class="item">
<a href="#">
<img src="<?=$row;?>" alt="">
</a>
</div>
<?php 
}
?>
</div>
</div>
</div>
<div class="c-content-box c-size-md c-bg-white">
<div class="container">

<div class="c-content-client-logos-slider-1  c-bordered" data-slider="owl">

<div class="c-content-title-1">
<h3 class="c-center c-font-uppercase c-font-bold">Dịch vụ nổi bật</h3>
<div class="c-line-center c-theme-bg"></div>
</div>
<div class="owl-carousel owl-theme c-theme owl-bordered1 c-owl-nav-center" data-items="6" data-desktop-items="4" data-desktop-small-items="3" data-tablet-items="3" data-mobile-items="2" data-slide-speed="5000" data-rtl="false">
<?php 
$noibat = $db->query("SELECT name,image,url FROM `TMQ_noibat`");
foreach($noibat as $row){
?>
<div class="item">
<a href="<?=$row['url']?>"><img src="<?=$row['image']?>" alt="<?=$row['name']?>" /></a>
</div>
<?php
}
?>
</div>

</div>

</div>
</div>

<?php
$get = $db->query("SELECT id,name FROM `TMQ_chuyenmuc` WHERE `loai` = '0' AND `status` = 'on'");
foreach($get as $cmm){
?>
<div class="c-content-box c-size-md c-bg-white">
<div class="container">

<div class="c-content-client-logos-slider-1  c-bordered" data-slider="owl">

<div class="c-content-title-1">
<h3 class="c-center c-font-uppercase c-font-bold"><?=$cmm['name']?></h3>
<div class="c-line-center c-theme-bg"></div>
</div>
<div class="row row-flex-safari game-list">
    <?php
    $get_cmc = $db->query("SELECT id,name,image FROM `TMQ_chuyenmuc` WHERE `loai` = '1' AND `id_cmm` = '".$cmm['id']."' AND `status` = 'on'");
    foreach($get_cmc as $row){
    $tk_dangban = $db->query("SELECT `id` FROM `TMQ_baiviet` WHERE `loai` = '".$row['id']."' AND `trangthai` = 'on'")->rowCount();
    $tk_daban = $db->query("SELECT `id` FROM `TMQ_baiviet` WHERE `loai` = '".$row['id']."' AND `trangthai` = 'off'")->rowCount();
    $url = '/'.TMQ_xoadau($row['name']).'-'.$row['id'];
    ?>
<div class="col-sm-3 col-xs-6 p-5">
<div class="classWithPad">
<div class="news_image">
<a href="<?=$url;?>" title="<?=$row['name'];?>" class="">
<!---<span class="sale">30%<span style="display: block;color: #fff;">GIẢM</span></span>
<style>
											span.sale {
											    position: absolute;
											    z-index: 1000;
											    left: 5px;
											    background: rgba(255,212,36,.9);
											    padding: 5px;
											    text-align: center;
											    color: #ee4d2d;
											    width: 44px;
											    font-weight: 700;
											    font-size: 15px;
											}
											.sale:after{
												content: "";
											    width: 0;
											    height: 0;
											    left: 0;
											    bottom: -4px;
											    position: absolute;
											    border-color: transparent rgba(255,212,36,.9);
											    border-style: solid;
											    border-width: 0 22px 4px;
											}
                                		</style>
                                		-->
<img src="<?=$row['image'];?>" alt="<?=$row['name'];?>"></a>
</div>
<div class="news_title">
<h2>
<a href="<?=$url;?>" title="<?=$row['name'];?>"><?=$row['name'];?></a>
</h2>
</div>
<div class="news_description">
<p>Số tài khoản: <?=number_format($tk_dangban);?></p>
<p>Tài khoản đã bán: <?=number_format($tk_daban);?></p>

</div>
<div class="a-more">
<div class="row">
<div class="col-xs-12">
<div class="view">
<a href="<?=$url;?>" title="<?=$row['name'];?>">Xem tất cả</a>
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
<?php } ?>

<?php
$service = $db->query("SELECT * FROM `TMQ_service`");
if($service->rowCount() != 0){
?>
<div class="c-content-box c-size-md c-bg-white">
<div class="container">

<div class="c-content-client-logos-slider-1  c-bordered" data-slider="owl">

<div class="c-content-title-1">
<h3 class="c-center c-font-uppercase c-font-bold">Dịch vụ</h3>
<div class="c-line-center c-theme-bg"></div>
</div>
<div class="row row-flex-safari game-list">
<?php
foreach($service as $row){
$daquay = $db->query("SELECT `id` FROM `TMQ_history` WHERE `loai` = '".TMQ_xoadau($row['name'])."'")->rowCount();
$daquay = number_format($daquay);
?>
<div class="col-sm-3 col-xs-6 p-5">
<div class="classWithPad">
<div class="news_image">
<a href="/service/<?=TMQ_xoadau($row['name']);?>/<?=$row['id'];?>.html" class=""><img src="<?=$row['image_thumb'];?>"></a>
</div>
<div class="news_title"><a href="/service/<?=TMQ_xoadau($row['name']);?>/<?=$row['id'];?>.html"><?=$row['name'];?></a></div>
<div class="news_description">
<p>
Đã quay: <?=$daquay;?>
</p>
</div>
<div class="a-more">
<div class="row">
<div class="col-xs-12">
<div class="view">
<a href="/service/<?=TMQ_xoadau($row['name']).'/'.$row['id'];?>.html">Xem tất cả</a>
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
<?php } ?>

<div class="modal fade" id="noticeModal" role="dialog" style="display: none;" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
<h4 class="modal-title" style="font-weight: bold;text-transform: uppercase;color: #FF0000;text-align: center">Thông báo</h4>
</div>
<div class="modal-body">
<?=html_entity_decode(TMQ_setting()['thongbao']);?>
</div>
<div class="modal-footer">
<button type="button" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" data-dismiss="modal">Đóng</button>
</div>
</div>
</div>
</div>
<style type="text/css">
    @media  only screen and (min-width: 768px){
        .row-flex-safari .classWithPad {
            height: 389px;
            max-height: 360px;
        }
    }
</style>
</div>
<div class="modal fade" id="noticeModal" role="dialog" style="display: none;" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="loader" style="text-align: center"><img src="/assets/frontend/images/loader.gif" style="width: 50px;height: 50px;display: none"></div>
<div class="modal-content">
<?=html_entity_decode(TMQ_setting()['thongbao']);?>
</div>
</div>
</div>
</div>