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
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
//if(empty($id)) header("Location: /tintuc");
$dulieu = $db->query("SELECT * FROM `TMQ_tintuc` WHERE `id` = '$id' LIMIT 1")->fetch();
if($dulieu['id'] == null) header("Location: /tintuc");
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
<li><a href="/blog">Blog tin tức</a></li>
<li>/</li>
<li><a href="#"><?=$dulieu['title'];?></a></li>
</ul>
</div>
</div>


<div class="c-content-box c-size-md">
<div class="container">
<div class="row">
<div class="col-md-12">
<h2 class="article-title title_custom"> <?=$dulieu['title'];?></h2>
<div class="article_cat_date">
<div style="display: inline-block;margin-right: 15px"><i class="fa fa-calendar" aria-hidden="true"></i> <?=$dulieu['date'];?></div>
<div style="display: inline-block"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <a href="dot-kich-cf" title="<?=$dulieu['username'];?>"><?=$dulieu['username'];?></a></div>
</div>
<div class="article-content">
<?=html_entity_decode($dulieu['text']);?>
</div>
</div>



</div>
<?php
require('../TMQ_sys/foot.php');