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
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8" />
<link rel="apple-touch-icon" href="/images/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/images/android-chrome-192x192.png">
<link rel="icon" type="image/png" sizes="512x512"  href="/images/android-chrome-512x512.png">
<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">
<link rel="manifest" href="/images/main.json">
    <title><?=TMQ_setting() ['title']; ?></title>
<meta name="description" content="Web mua bán nick game,  Acc Game, Shop Nick  Ngọc rồng - nro, ninja school - nso, avatar , Hải Tặc - HTTH, Làng Lá - LLPLK, Liên Quân, Liên Minh - LMHT - LOL , Đột kích - CF, Truy Kích, Army 2, Hiệp Sĩ - HSO, nick vip, giá rẻ , uy tín của Quanplay">
<meta name="keywords" content="Web mua bán nick game, Web mua bán Acc Game, Shop mua bán Nick game,  Ngọc rồng - nro, ninja school - nso, avatar, Hải Tặc - HTTH, Làng Lá - LLPLK, Liên Quân - LQM, Liên Minh - LMHT - LOL , Đột kích - CF, Truy Kích, Army 2, Hiệp Sĩ - HSO, nick vip, giá rẻ , uy tín, Quanplay">
<link rel="shortcut icon" href="" type="image/x-icon">
<meta http-equiv="X-Frame-Options" content="deny">
<link rel="canonical" href="https://<?=TMQ_domain(); ?>">
<meta content="" name="author" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://<?=TMQ_domain(); ?>" />
<meta property="og:title" content="Web Mua Bán Nick Game, Acc Game, Shop Nick Game - <?=TMQ_domain(); ?>" />
<meta property="og:description" content="Web mua bán nick game,  Acc Game, Shop Nick  Ngọc rồng - nro, ninja school - nso, avatar , Hải Tặc - HTTH, Làng Lá - LLPLK, Liên Quân, Liên Minh - LMHT - LOL , Đột kích - CF, Truy Kích, Army 2, Hiệp Sĩ - HSO, nick vip, giá rẻ , uy tín của Quanplay" />
<meta property="og:image" content="/images/anhbia.jpg" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700&amp;subset=all' rel='stylesheet' type='text/css'>
<link href="/assets/frontend/theme/assets/plugins/socicon/socicon.css" rel="stylesheet"  />
<link href="/assets/frontend/theme/assets/plugins/bootstrap-social/bootstrap-social.css" rel="stylesheet"  />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="/assets/frontend/theme/assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet"  />
<link href="/assets/frontend/theme/assets/plugins/animate/animate.min.css" rel="stylesheet"  />
<link href="/assets/frontend/theme/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"  />
<link href="/assets/frontend/theme/assets/global/plugins/magnific/magnific.css" rel="stylesheet"  />
<link href="/assets/frontend/theme/assets/plugins/cubeportfolio/css/cubeportfolio.min.css" rel="stylesheet"  />
<link href="/assets/frontend/theme/assets/plugins/owl-carousel/assets/owl.carousel.css" rel="stylesheet"  />
<link href="/assets/frontend/theme/assets/plugins/fancybox/jquery.fancybox.css" rel="stylesheet"  />
<link href="/assets/frontend/theme/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet"  />
<link href="/assets/frontend/theme/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet"  />
<link href="/assets/frontend/theme/assets/demos/default/css/plugins.css" rel="stylesheet"  />
<link href="/assets/frontend/theme/assets/demos/default/css/components.css" id="style_components" rel="stylesheet"/>
<link href="/assets/frontend/theme/assets/demos/default/css/themes/default.css" rel="stylesheet" id="style_theme"  />
<link href="/assets/frontend/theme/assets/demos/default/css/custom.css" rel="stylesheet"  />
<link rel="stylesheet" href="/assets/frontend/plugins/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="/assets/frontend/plugins/owl-carousel/owl.theme.css">
<link rel="stylesheet" href="/assets/frontend/plugins/owl-carousel/owl.transitions.css">
<link href="/assets/frontend/css/style.css" rel="stylesheet"  />
<link href="/assets/frontend/theme/assets/global/plugins/magnific/magnific.css" rel="stylesheet"/>
<script src="/assets/frontend/plugins/jquery/jquery-2.1.0.min.js"></script>
<script src="/assets/frontend/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/frontend/plugins/owl-carousel/owl.carousel.min.js"></script>
<script src="/assets/frontend/plugins/owl-carousel/slider.js"></script>
<script src="/assets/frontend/plugins/jquery-cookie/jquery.cookie.js"></script>
<style>
/* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}

    .nav-tabs {
    margin-bottom: 15px;
}
.sign-with {
    margin-top: 25px;
    padding: 20px;
}
div#OR {
    height: 30px;
    width: 30px;
    border: 1px solid #C2C2C2;
    border-radius: 50%;
    font-weight: bold;
    line-height: 28px;
    text-align: center;
    font-size: 12px;
    float: right;
    position: absolute;
    right: -16px;
    top: 40%;
    z-index: 1;
    background: #DFDFDF;
}
 .c-menu-type-mega:hover {
                        transition-delay: 1s;
                    }

                    .c-layout-header.c-layout-header-4 .c-navbar .c-mega-menu > .nav.navbar-nav > li:focus > a:not(.btn), .c-layout-header.c-layout-header-4 .c-navbar .c-mega-menu > .nav.navbar-nav > li:active > a:not(.btn), .c-layout-header.c-layout-header-4 .c-navbar .c-mega-menu > .nav.navbar-nav > li:hover > a:not(.btn) {
                        color: #3a3f45;
                        background: #FAFAFA;
                    }
</style>
</head>
<body class="c-layout-header-fixed c-layout-header-mobile-fixed c-layout-header-topbar c-layout-header-topbar-collapse">
<!--
    <p style="text-align:center;color:red;font-size:50px;font-weight:bold;">Warning!</p>
<p style="text-align:center;font-size:40px;">SHOP NÀY ĐƯỢC DEVELOPER BỞI TMQ</p>
<p style="text-align:right;font-size:50px">~~~TMQ~~~</p>
</div>
-->

<header class="c-layout-header c-layout-header-4 c-layout-header-default-mobile" data-minimize-offset="80">
<div class="c-topbar c-topbar-light">
<div class="container">

<nav class="c-top-menu c-pull-left">
<ul class="c-icons c-theme-ul">
<li>
<a href="<?=TMQ_setting() ['facebook']; ?>" target="_blank">
<i class="icon-social-facebook"></i>
</a>
</li>
<li>
<a href="<?=TMQ_setting() ['youtube']; ?>" target="_blank">
<i class="icon-social-youtube"></i>
</a>
</li>
</ul>
</nav>


<nav class="c-top-menu c-pull-right m-t-10">
<ul class="c-links c-theme-ul">
<li>
Hotline: <a href="tel:<?=TMQ_setting() ['phone']; ?>"><?=TMQ_setting() ['phone']; ?> </a>
</li>

</ul>
</nav>

</div>
</div>
<div class="c-navbar">
<div class="container">

<div class="c-navbar-wrapper clearfix">
<div class="c-brand c-pull-left">
<h1 style="margin: 0px;display: inline-block">
<a href="/" class="c-logo" alt="Shop bán nick game, acc game online avatar, đột kích – CF, liên minh huyền thoại lol , ngọc rồng, khí phách anh hùng - kpah giá rẻ, uy tín...">
<img height="35px" src="<?=TMQ_setting() ['logo']; ?>" alt="" class="c-desktop-logo">
<img height="29px" src="<?=TMQ_setting() ['logo']; ?>" alt="" class="c-desktop-logo-inverse">
<img height="35px" src="<?=TMQ_setting() ['logo']; ?>" alt="" class="c-mobile-logo"> </a>
</h1>
<button class="c-hor-nav-toggler" type="button" data-target=".c-mega-menu">
<span class="c-line"></span>
<span class="c-line"></span>
<span class="c-line"></span>
</button>
<button class="c-topbar-toggler" type="button">
<i class="fa fa-ellipsis-v"></i>
</button>
<button class="c-search-toggler" type="button">
<i class="fa fa-search" aria-hidden="true"></i>
</button>

</div>


<form class="c-quick-search" action="#">
<input type="text" name="query" placeholder="Tìm kiếm..." value="" class="form-control" autocomplete="off">
<span class="c-theme-link">&times;</span>
</form>
 
<nav class="c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold d-none hidden-xs hidden-sm">
<ul class="nav navbar-nav c-theme-nav">
<?php
echo TMQ_setting() ['header']; 
if ($_SESSION['id'])
{
if(TMQ_admin() == 9 || TMQ_admin() == 1)
{
    echo '<li class="c-menu-type-classic"><a style="color:red;" href="/admin/main" class="c-link dropdown-toggle ">ADMIN CPANEL</a></li>';
}
?>
<li><a href="/profile/info" title="<?=TMQ_user() ['username']; ?>" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold"><i class="icon-user"></i> <?=substr(TMQ_user() ['name'], 0, -4) . '...'; ?></a>
</li>
<li><a href="/logout" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
<i class="icon-signout"></i> Đăng xuất</a>
</li>
<?php
}
else
{
?> 
<li><a href="#" data-modal-id="modal-login" class="launch-modal c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
<i class="icon-user"></i> Đăng nhập / Đăng ký</a>
</li>
<?php
}
?></ul>
</nav>
<nav class="menu-main-mobile c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold hidden-md hidden-lg">
<ul class="nav navbar-nav c-theme-nav">
<?=TMQ_setting() ['header']; ?>
<?php if (TMQ_user())
{
if(TMQ_admin() == 9 || TMQ_admin() == 1)
{
    echo '<li class="c-menu-type-classic"><a style="color:red;" href="/admin/main" class="c-link dropdown-toggle ">ADMIN CPANEL</a></li>';
}?>
<li><a href="/proile/info" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
<i class="icon-user"></i> <?=TMQ_user() ['name']; ?></a>
</li>
<li><a href="/logout.php" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
<i class="icon-signout"></i> Đăng xuất</a>
</li>
<?php
}
else
{ ?>
<li><a href="#" data-modal-id="modal-login" class="launch-modal c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
<i class="icon-user"></i> Đăng nhập/Đăng ký</a>
</li>
<?php
} ?>
</ul>
</nav>
</div>
</div>
</div>
</header>