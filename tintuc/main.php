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
?>

<div class="c-layout-page">


<div class="c-layout-breadcrumbs-1 c-fonts-uppercase c-fonts-bold c-bordered c-bordered-both">
<div class="container">
<div class="c-page-title c-pull-left">
<h3 class="c-font-uppercase c-font-sbold"><a href="/blog" title="Blog tin tức">Blog tin tức</a></h3>
</div>
<ul class="c-page-breadcrumbs c-theme-nav c-pull-right c-fonts-regular">
<li><a href="/">Trang chủ</a></li>
<li>/</li>
<li><a href="/tintuc">Blog tin tức</a></li>
</ul>
</div>
</div>


<div class="c-content-box c-size-md">
<div class="container">
<form class="form-horizontal form-find m-b-20" role="form" method="get">
<div class="row">
<div class="col-md-4">
<input type="text" class="form-control c-square c-theme" name="key" autocomplete="off" autofocus placeholder="Nhập từ khóa..." value="<?=isset($_GET['key']) ? TMQ_check($_GET['key']) : null;?>" style="width: 100%">
</div>
<div class="col-md-4">
<input type="submit" class="btn c-theme-btn c-btn-square m-b-10" value="Tìm kiếm">
<a class="btn c-btn-square m-b-10 btn-danger" href="/tin-tuc">Tất cả</a>
</div>
</div>
</form>
<div class="row">
<div class="col-md-9">
<div class="art-list">
<?php
$limit = 20;
if( isset($_GET["page"]) ){
	$page = $_GET["page"];
	settype($page, "int");
}else{
	$page = 1;	
}
$from = ($page -1 ) * $limit;


if(isset($_GET['key'])){
    $key = TMQ_check($_GET['key']);
$baiviet = $db->query("SELECT * FROM `TMQ_tintuc` WHERE (`title` LIKE '%$key%') OR (`text` LIKE '%$key%') OR (`description` LIKE '%$key%') LIMIT $from,$limit");
}else{
$baiviet = $db->query("SELECT * FROM `TMQ_tintuc` LIMIT $from,$limit");
}
while($row = $baiviet->fetch()){
?>
<div class="a-item">
<div class="thumbnail-image img-thumbnail"><a href="/view-tin-tuc/<?=TMQ_xoadau($row['title']).'/'.$row['id'];?>.html"><img src="<?=$row['image'];?>" alt=""></a></div>
<div class="info">
<div class="article_title "><h2><a href="/view-tin-tuc/<?=TMQ_xoadau($row['title']).'/'.$row['id'];?>.html" style="text-transform: initial;"><?=$row['title'];?></a></h2> </div>
<div class="article_cat_date">
<div style="display: inline-block;margin-right: 15px"><i class="fa fa-calendar" aria-hidden="true"></i> <?=$row['date'];?></div>
<div style="display: inline-block"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <a title="<?=$row['username'];?>"><?=$row['username'];?></a></div>
</div>
<div class="article_description hidden-xs"><?=$row['description'];?></div>
</div>
</div>
<?php } ?>

</div>
<div class="data_paginate paging_bootstrap paginations_custom" style="text-align: center">
<?php 
$tong = $db->query("SELECT * FROM `TMQ_tintuc`")->rowcount();
if ($tong > $sotin1trang){
echo '<center>'.TMQ_phantrang('?', $from, $tong, $limit).'</center>';
} ?>
</div>
</div>

</div>
<?php
require('../TMQ_sys/foot.php');