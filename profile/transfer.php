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

if (isset($_POST['transfer']) && $_SESSION['token'] == TMQ_check(strip_tags($_POST['_token']))) {
  $username = TMQ_check($_POST['username']);
  $amount = TMQ_check($_POST['amount']);
  $amount = str_replace(",", null, $amount);
  $amount = (int)abs($amount);
  $description = TMQ_check($_POST['description']);
  $captcha = isset($_POST['captcha']) ? TMQ_check($_POST['captcha']) : false;

  //kiểm tra người chuyển
  $check = $db->query("SELECT `id`,`username`,`cash` FROM `TMQ_user` WHERE (`id` = ".$db->quote($username).") OR (`username` = ".$db->quote($username).") LIMIT 1")->fetch();

  //kiểm tra đầu vào
  if(empty($username) || empty($amount) || empty($captcha)){
    $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Vui lòng nhập đủ thông tin.</div>';  
  }elseif($check['id'] == null){
$err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Người nhận không tồn tại.</div>';  
  }elseif($amount > TMQ_user()['cash']){
$err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Tài khoản không đủ tiền.</div>';  
  }elseif($amount < 10000){
$err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Số tiền tối thiểu là 10.000<sup>đ</sup>.</div>';  
  }elseif($amount > 10000000){
$err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Số tiền tối đa là 10.000.000<sup>đ</sup>.</div>';  
  }elseif($username == TMQ_user()['id'] || $username == TMQ_user()['username']){
 $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Bạn không thể chuyển cho chính mình.</div>';     
  }elseif(!isset($_SESSION['captcha_code']) || $captcha != $_SESSION['captcha_code']){
 $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Captcha không chính xác.</div>';  
  }else{
$err = '<div class="alert alert-success alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Chuyển tiền thành công.</div>';  
  //insert transter
  $db->exec("INSERT INTO `TMQ_transfer` 
  (`transfer`, `receiver`, `amount`, `description`, `date`) 
  VALUES 
  ('".TMQ_user()['username']."','".$check['username']."','$amount',".$db->quote($description).",'".date("H:i:s d-m-Y")."')
  ");
  //minus money
  $text_transfer = 'Chuyển tiền cho '.$check['username'];
  $db->exec("UPDATE `TMQ_user` SET `cash` = `cash` - $amount WHERE `id` = '".TMQ_user()['id']."'");
  $before = TMQ_user()['cash']+$amount;
  TMQ_history(null,TMQ_user()['username'],$text_transfer,$amount,$before,TMQ_user()['cash'],'transfer');
  //plus money
  $db->exec("UPDATE `TMQ_user` SET `cash` = `cash` + $amount WHERE `id` = '".$check['id']."'");
  $text_receiver = 'Nhận tiền từ '.TMQ_user()['username'];
  $after_receiver = $check['cash']+$amount;
  TMQ_history(null,$check['username'],$text_receiver,$amount,$check['cash'],$after_receiver,'transfer');
  }
}
$salt = "Iui8*&@IJsad".date("Y-m-d H:i:s");
$token = md5($salt.TMQ_random(20));
$_SESSION["token"] = $token;
?>
<div class="c-layout-sidebar-content ">
<div class="c-content-title-1">
<h3 class="c-font-uppercase c-font-bold">Chuyển tiền thành viên</h3>
<div class="c-line-left"></div>
</div>
<?=$err;?>
<div class="text-center">
<center>
<h2 class="c-font-bold c-font-28">ID: <?=TMQ_user()['id'];?></h2>
<h2 class="c-font-bold c-font-28"><a><?=TMQ_hide_email(TMQ_user()['email']);?></a></h2>
<h2 class="c-font-22"><?=TMQ_position(TMQ_user()['id']);?></h2>
<h2 class="c-font-22"></h2>
<h2 class="c-font-22 c-font-red"><?=number_format(TMQ_user()['cash']);?>đ</h2>
</center>
</div>
<form class="form-horizontal" method="POST">
<input type="hidden" name="_token" value="<?=$token;?>">
<div class="form-group">
<label class="col-md-3 control-label">Tài khoản/ID người nhận:</label>
<div class="col-md-6">
<input class="form-control  c-square c-theme" name="username" type="text" placeholder="Tài khoản người nhận" required="">
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Số tiền:</label>
<div class="col-md-6">
<input id="money" class="form-control c-square c-theme price" name="amount" type="text" placeholder="Số tiền cần chuyển (Tối thiểu 20,000)" required="">
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Nội dung chuyển tiền:</label>
<div class="col-md-6">
<input class="form-control c-square c-theme" name="description" type="text" placeholder="Nhập nội dung chuyển khoản nếu cần thiết">
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label"><b>Mã bảo vệ:</b></label>
<div class="col-md-6">
<div class="input-group">
<span class="input-group-addon" style="padding: 0px;">
<img src="/captcha" height="30px" id="imgcaptcha" onclick="document.getElementById('imgcaptcha').src ='/captcha?'+Math.random();document.getElementById('captcha').focus();">
</span>
<input type="text" class="form-control c-square" id="captcha" name="captcha" placeholder="" maxlength="3" autocomplete="off" required="">
</div>
</div>
</div>
<div class="form-group c-margin-t-40">
<div class="col-md-offset-3 col-md-6">
<button type="submit" name="transfer" class="btn c-theme-btn c-btn-square c-btn-uppercase c-btn-bold btn-block btn-confirm">Thực hiện</button>
</div>
</div>
</form>

<table id="charge_recent" class="table table-striped table-custom-res">
<tbody><tr>
<th>Thời gian</th>
<th>Giao dịch</th>
<th>Tài khoản/ID người nhận</th>
<th>Số tiền</th>
<th>Nội dung</th>
<th>Trạng thái</th>
</tr>
</tbody>
<tbody>
<?php 
$list_transfer = $db->query("SELECT * FROM `TMQ_transfer` WHERE (`transfer` = '".TMQ_user()['username']."') OR (`receiver` = '".TMQ_user()['username']."')");
if($list_transfer->rowCount() == 0){
echo '<tr><td colspan="5">Không có dữ liệu</td></tr>';
}
foreach($list_transfer as $row){
    if($row['transfer'] == TMQ_user()['username']){
        $giaodich = 'Chuyển tiền';
        $sign = '-';
    }elseif($row['receiver'] == TMQ_user()['username']){
        $giaodich = 'Nhận tiền';
        $sign = '+';
    }
?>
<tr>
    <td><?=$row['date'];?></td>
    <td><?=$giaodich;?></td>
    <td><?=$row['receiver'];?></td>
    <td><?=$sign.number_format($row['amount']);?><sup>đ</sup></td>
    <td><?=$row['description'];?></td>
    <td><?=$row['id'];?></td>
</tr>
<?php 
}
?>
</tbody>
</table>
</div>
</div>
</div>
<?php
    require ("../TMQ_sys/foot.php");
?>