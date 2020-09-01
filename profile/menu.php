<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
if(!isset($_SESSION['id'])){ header("Location: /"); }
?>

<div class="c-layout-page">

<div class="m-t-20 visible-sm visible-xs"></div>
<center style="max-width:1140px; margin: 0 auto;" class="hidden-xs"><div class="c-layout-breadcrumbs-1 c-bgimage c-subtitle c-fonts-uppercase c-fonts-bold c-bg-img-center" style="background-image: url('https://nick.vn/assets/frontend/images/unknown-cover.jpg');background-position: center;width:100%;height: 350px;background-repeat: no-repeat;background-position: center;background-size: cover;">
<div class="container">
<div class="c-page-title c-pull-left">
<h3 class="c-font-uppercase c-font-bold c-font-white c-font-20 c-font-slim">&nbsp;</h3>
</div>
</div>
</div>
</center>
<div class="container c-size-md ">
<div class="col-md-12">
<div class="text-center" style="margin-top: -128px;">
<center>
<img class="img-responsive img-thumbnail hidden-xs" width="256" height="256" src="https://nick.vn/assets/frontend/images/unknown-avatar.jpg" alt="">
<h2 class="c-font-bold c-font-28">ID Web: <?=TMQ_user()['id'];?></h2>
<h2 class="c-font-bold c-font-28">
<?=TMQ_user()['email'];?>
<br>( <?=TMQ_user()['name'];?> )
</h2>
<h2 class="c-font-22"><?=TMQ_position(TMQ_user()['id']);?></h2>
<h2 class="c-font-22"></h2>
<h2 class="c-font-22 c-font-red"><?=number_format(TMQ_user()['cash']);?>đ</h2>
</center>
</div>
</div>
</div>
<div class="c-layout-page" style="margin-top: 20px;">
<div class="container">
<div class="c-layout-sidebar-menu c-theme ">
<div class="row">
<div class="col-md-12 col-sm-6 col-xs-6 m-t-15 m-b-20">

<div class="c-content-title-3 c-title-md c-theme-border">
<h3 class="c-left c-font-uppercase">Menu tài khoản</h3>
<div class="c-line c-dot c-dot-left "></div>
</div>
<div class="c-content-ver-nav">
<ul class="c-menu c-arrow-dot c-square c-theme">
<li><a href="/profile/info" class="<?php if($activePage == 'info'){echo 'active';};?>">Thông tin tài khoản</a></li>
<li><a href="/profile/inbox" class="p-quantity <?php if($activePage == 'inbox'){echo 'active';};?>">Hộp thư
<span id="quantity_noti" class="quantity">0</span>
</a>
</li>
<li><a href="/profile/history" class="<?php if($activePage == 'history'){echo 'active';};?>">Lịch sử giao dịch </a></li>
<li><a href="/profile/bank" class="<?php if($activePage == 'bank'){echo 'active';};?>">Tài khoản ngân hàng</a></li>
<li><a href="/profile/withdraw" class="">Rút tiền ra ATM - Ví</a></li>
</ul>
</div>
</div>
<div class="col-md-12 col-sm-6 col-xs-6 m-t-15">
<div class="c-content-title-3 c-title-md c-theme-border">
<h3 class="c-left c-font-uppercase">Menu giao dịch</h3>
<div class="c-line c-dot c-dot-left "></div>
</div>
<div class="c-content-ver-nav m-b-20">
<ul class="c-menu c-arrow-dot c-square c-theme">
<li><a href="/profile/nap-the" class="<?php if($activePage == 'nap-the'){echo 'active';};?>"><b>Nạp thẻ tự động</b></a></li>
<li><a class="load-modal" href="#" rel="/atm">Nạp tiền từ ATM - Ví Điện Tử</a></li>
<li><a href="/profile/tran_acc" class="<?php if($activePage == 'tran_acc'){echo 'active';};?>">Tài khoản đã mua</a></li>
<li><a href="/profile/transfer" class="<?php if($activePage == 'transfer'){echo 'active';};?>">Chuyển tiền</a></li>
</ul>
</div>
</div>
</div>
</div>
