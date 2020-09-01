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
require("../TMQ_sys/function.php");
require("../TMQ_sys/head.php");
require("menu.php");
?>

 <div class="c-layout-sidebar-content ">


<div class="c-content-title-1">
<h3 class="c-font-uppercase c-font-bold">Thông tin tài khoản</h3>
<div class="c-line-left"></div>
</div>
<table class="table table-striped">
<tbody><tr>
<th scope="row">ID của bạn:</th>
<th><span class="c-font-uppercase"><?=TMQ_user()['id'];?></span></th>
</tr>
<tr>
<th scope="row">Tên tài khoản:</th>
<th><?=TMQ_user()['username'];?></th>
</tr>
<tr>
<th scope="row">Số dư tài khoản:</th>
<td><b class="text-danger"><?=number_format(TMQ_user()['cash']);?>đ</b></td>
</tr>

<tr>
<th scope="row">Số điện thoại:</th>
<td><b><i class="text-danger"><?=substr(TMQ_user()['phone'],0,-4)."****";?></i></b></td>
</tr>
<tr>
<th scope="row">Nhóm tài khoản:</th>
<td><?=TMQ_position(TMQ_user()['id']);?></td>
</tr>
<tr>
<th scope="row">Ngày tham gia:</th>
<td><?=TMQ_user()['date'];?></td>
</tr>
<tr>
<th scope="row">Mật khẩu:</th>
<td><a href="/profile/change-password"><b><i class="text-danger">****** (Đổi mật khẩu)</i></b></a></td>
</tr>
</tbody></table>

</div>
</div>
</div>

</div>

</div>
<?php require("../TMQ_sys/foot.php"); ?>