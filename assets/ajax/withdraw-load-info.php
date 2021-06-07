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
 require("../../TMQ_sys/function.php");
 $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
 
 $show = $db->query("SELECT * FROM `TMQ_bank` WHERE `id` = '$id' AND `username` = '".TMQ_user()['username']."'")->fetch();
 
 if($show['id'] == null){
     die();
     exit();
 }
?>

 <div class="form-group">
<label class="col-md-3 control-label">Ví điện tử:</label>
<div class="col-md-6">
<p id="bank" class="form-control c-square c-theme c-theme-static m-b-0"><?=$show['bank'];?></p>
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Tài khoản ví:</label>
<div class="col-md-6">
<p id="stk" class="form-control c-square c-theme c-theme-static m-b-0"><?=$show['number'];?></p>
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Số tiền cần rút:</label>
<div class="col-md-6">
<input id="money" class="form-control c-square c-theme price" name="amount" type="text" placeholder="" autofocus required="">
<span class="help-block">Số tiền rút từ 100,000đ đến 10,000,000đ</span>
<span class="help-block">Phí rút tiền: 0đ (Không trừ vào số tiền rút)</span>
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Nội dung rút tiền:</label>
<div class="col-md-6">
<input class="form-control c-square c-theme" name="description" type="text" placeholder="Nhập nội dung rút tiền nếu cần thiết">
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
<script>
    jQuery(document).ready(function () {

        $('.price').mask('000,000,000,000,000', {reverse: true});
        $('.price').focus();
    });

</script>