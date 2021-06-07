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
$password = TMQ_check($_POST['matkhau']);
$re_pass = TMQ_check($_POST['re_pass']);
$name = TMQ_check($_POST['name']);
$email = TMQ_check($_POST['email']);
$phone = TMQ_check($_POST['phone']);
$referral_code = strtoupper(TMQ_random(6));
$check = $db->query("SELECT id,username,password FROM `TMQ_user` WHERE `username` = '$username' LIMIT 1")->fetch();
if(empty($username) || empty($password) || empty($re_pass) || empty($name) || empty($email) || empty($phone)){
    $err = 'Vui lòng nhập đủ thông tin!';
}elseif($check['id'] != null){
    $err = 'Tài khoản đã tồn tại!';
}elseif($password != $re_pass){
    $err = 'Hai mật khẩu không giống nhau!';
}elseif(filter_var($email,FILTER_VALIDATE_EMAIL) === false){
    $err = 'Email sai định dạng';
}elseif(strlen($phone) != 10){
    $err = 'Số điện thoại sai định dạng';
}else{
    $smtp = $db->prepare("INSERT INTO `TMQ_user` 
    (`name`, `username`, `password`,`password_2`,`login`, `phone`, `email`, `cash`, `ban`,`referral_code` ,`admin`,`date`) 
    VALUES 
    (?,?,?,?,?,?,?,?,?,?,?,?)");
    $data = array($name,$username,TMQ_mahoa($password),null,null,$phone,$email,0,0,$referral_code,9,date('H:i:s d-m-Y'));
    $smtp->execute($data);
    $err = 'Đăng ký thành công';
    $user = $db->query("SELECT `id` FROM `TMQ_user` WHERE `username` = '$username' LIMIT 1")->fetch();
    $_SESSION['id'] = $user['id'];
    echo '<script>window.location="/";</script>';
}
print $err;
}else{
    require("TMQ_sys/head.php");
    isset($_SESSION['id']) ? header("Location: /") : null;
if(isset($_POST['register'])){
$username = TMQ_check($_POST['taikhoan']);
$password = TMQ_check($_POST['matkhau']);
$re_pass = TMQ_check($_POST['re_pass']);
$name = TMQ_check($_POST['name']);
$email = TMQ_check($_POST['email']);
$phone = TMQ_check($_POST['phone']);
$check = $db->query("SELECT id,username,password FROM `TMQ_user` WHERE `username` = '$username' LIMIT 1")->fetch();   
    if(!empty($username) || !empty($password) || !empty($re_pass) || !empty($name) || !empty($email) || !empty($phone)){
        if($check['id'] == null){
            if($password == $re_pass){
                if(!filter_var($email,FILTER_VALIDATE_EMAIL) === false){
                    if(strlen($phone) == 10){
                    $smtp = $db->prepare("INSERT INTO `TMQ_user` (`name`, `username`, `password`, `phone`, `email`, `cash`, `ban`, `admin`,`date`)  VALUES  (?,?,?,?,?,?,?,?,?)");    
                    $data = array($name,$username,TMQ_mahoa($password),$phone,$email,0,0,9,date('H:i:s d-m-Y'));
                    $smtp->execute($data);
                    $err = 'Đăng ký thành công.';
                    }else{ 
                        $err = 'Số điện thoại sai định dạng.';
                    }
                }else{
                    $err = 'Email sai định dạng.';
                }
            }else{
                $err = 'Hai mật khẩu không giống nhau.';
            }
        }else{
            $err = 'Tài khoản đã tồn tại.';
        }
    }else{
        $err = 'Vui lòng nhập đủ thông tin.';
    }
}else{
    $err = '';
}
?>

<div class="c-layout-page">

<div class="login-box">

<div class="login-box-body box-custom">
<p class="login-box-msg">Đăng ký thành viên</p>
<span class="help-block" style="text-align: center;color: #dd4b39">
<strong><?=$err;?></strong>
</span>
<form method="POST">
<div class="form-group has-feedback  ">
<input type="text" class="form-control" name="name" value="" placeholder="Họ và tên">
<span class="glyphicon glyphicon-user form-control-feedback"></span>
</div>
<div class="form-group has-feedback  ">
<input type="text" class="form-control" name="taikhoan" value="" placeholder="Tài khoản">
<span class="glyphicon glyphicon-user form-control-feedback"></span>
</div>
<div class="form-group has-feedback">
<input type="text" class="form-control" name="email" value="" placeholder="Email">
<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
</div>
<div class="form-group has-feedback">
<input type="text" class="form-control number" maxlength="11" name="phone" value="" placeholder="Số điện thoại">
<span class="glyphicon glyphicon-phone form-control-feedback"></span>
</div>
<div class="form-group has-feedback">
<input type="password" class="form-control" name="matkhau" placeholder="Mật khẩu">
<span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>
<div class="form-group has-feedback">
<input type="password" class="form-control" name="re_pass" placeholder="Xác nhận mật khẩu">
<span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>
<div class="row">

<div class="col-xs-12">
<button type="submit" name="register" class="btn btn-primary btn-block btn-flat" style="margin: 0 auto;">Đăng ký</button>
</div>

</div>
</form>
<div class="social-auth-links text-center">
<p style="margin-top: 5px">- HOẶC -</p>
<a href="https://nhapnick.com/nick_vn" class="btn  btn-social btn-facebook btn-flat d-inline-block"><i class="fa fa-facebook"></i>Login FB</a>
</div>

</div>

</div>

<style>
        .login-box, .register-box {
            width: 400px;
            margin: 7% auto;
            padding: 20px;;
        }

        @media (max-width: 767px){
            .login-box, .register-box {
                width: 100%;
            }

        }

        .login-box-msg, .register-box-msg {
            margin: 0;
            text-align: center;
            padding: 0 20px 20px 20px;
            text-align: center;
            font-size: 20px;
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