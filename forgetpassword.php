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
require('TMQ_sys/function.php');
if(isset($_POST['ajax']) == 'true'){
$username = TMQ_check($_POST['taikhoan']);
$email = TMQ_check($_POST['email']);
$code = TMQ_check($_POST['code']);
$npass = TMQ_check($_POST['newpass']);
$re_npass = TMQ_check($_POST['frenew']);
$check = $db->query("SELECT `id`,`email` FROM `TMQ_user` WHERE `username` = '$username' AND `email` = '$email'")->fetch();
$check_code = $db->query("SELECT `id`,`date` FROM `TMQ_key` WHERE `key` = '$code' AND `loai` = 'reset_password' AND `email` = '$email'")->fetch();
if(!empty($username) || !empty($email) || !empty($code) || !empty($npass) || !empty($re_npass)){
    if($check['id'] != null){
        if($check_code['date'] >= date('d-m-Y')){
       echo 'Mật khẩu đã được đổi thành công';
       $db->exec("UPDATE `TMQ_user` SET `password` = '".TMQ_mahoa($npass)."' WHERE `username` = '$username'");
       $db->exec("DELETE FROM `TMQ_key` WHERE `key` = '$code'");
        }else{
            echo 'Mã không tồn tại!';}
    }else{
        echo 'Email không đúng!';}        
}else{
    echo 'Vui lòng nhập đủ thông tin!';
}
}else{
require("TMQ_sys/head.php");
isset($_SESSION['id']) ? header("Location: /") : null;
if(isset($_POST['reset'])){
$username = TMQ_check($_POST['fusername']);
$email = TMQ_check($_POST['femail']);
$code = TMQ_check($_POST['code']);
$npass = TMQ_check($_POST['newpass']);
$re_npass = TMQ_check($_POST['frenew']);
$check = $db->query("SELECT `id`,`email` FROM `TMQ_user` WHERE `username` = '$username' AND `email` = '$email'")->fetch();
$check_code = $db->query("SELECT `id`,`date` FROM `TMQ_key` WHERE `key` = '$code' AND `loai` = 'reset_password' AND `email` = '$email'")->fetch();    
if(!empty($username) || !empty($email) || !empty($code) || !empty($npass) || !empty($re_npass)){
    if($check['id'] != null){
        if($check_code['date'] >= date('d-m-Y')){
       $err = 'Mật khẩu đã được đổi thành công';
       $db->exec("UPDATE `TMQ_user` SET `password` = '".TMQ_mahoa($npass)."' WHERE `username` = '$username'");
       $db->exec("DELETE FROM `TMQ_key` WHERE `key` = '$code'");
        }else{
            $err = 'Mã không tồn tại!';}
    }else{
        $err = 'Email không đúng!';}        
}else{
    $err = 'Vui lòng nhập đủ thông tin!'; }
}else{
    $err = '';
}
?>
<div class="c-layout-page">

<div class="login-box">

<div class="login-box-body box-custom">
<p class="login-box-msg">Khôi phục mật khẩu</p>
<span class="help-block" style="text-align: center;color: #dd4b39">
<strong id="result_2"><?=$err;?></strong>
</span>
<form method="POST" aria-label="Reset Password">
<input type="hidden" id="ajax" value="true"/>
<div class="form-group has-feedback">
<input type="text" class="form-control" name="fusername" id="fusername" value="" required placeholder="Tài khoản đăng ký">
</div>
<div class="form-group has-feedback">
<input type="text" class="form-control" name="femail" id="femail" value="" required placeholder="Email tài khoản đăng ký">
</div>
 <div class="form-group has-feedback">
           
                                    <input type="email" class="form-control" id="code" placeholder="Mã xác nhận gừi về email..." />
                                  
                                   <span>
                                    <button type="submit" id="send_code" class="btn btn-success btn-sm">Gửi mã</button>
                                    </span>
                                </div>
<div class="form-group has-feedback">
<input type="text" class="form-control" name="newpass" value="" required placeholder="Mật khẩu mới">
</div>
<div class="form-group has-feedback">
<input type="text" class="form-control" name="frenew" value="" required placeholder="Nhập lại mật khẩu mới">
</div>
<div class="row">

<div class="col-xs-12">
<button type="submit" name="reset" class="btn btn-primary btn-block btn-flat" style="margin: 0 auto;">Xác nhận</button>
</div>

</div>
</form>
</div>

</div>

<style>
    .login-box, .register-box {
        width: 400px;
        margin: 7% auto;

        padding: 20px;;
    }

    .login-box-msg, .register-box-msg {
        margin: 0;
        text-align: center;
        padding: 0 20px 20px 20px;
        text-align: center;
        font-size: 20px;;
        font-weight: bold;
    }

    .box-custom{
        border: 1px solid #cccccc;
        padding: 20px;

        color: #666;
    }
</style>

</div>
    
<?php require("TMQ_sys/foot.php"); } ?>