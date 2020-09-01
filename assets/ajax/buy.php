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
require('../../TMQ_sys/function.php');

if(TMQ_user()['id'] != null){
$id = isset($_POST['id'])? (int)$_POST['id'] : null;
$coupon = TMQ_check($_POST['giftcode']);
$magioithieu = TMQ_check($_POST['magioithieu']);
//lấy dữ liệu account
$data = $db->query("SELECT * FROM `TMQ_baiviet` WHERE `id` = '$id'")->fetch();
//lấy dữ liệu coupon
$data_coupon = $db->query("SELECT `code`,`amount` FROM `TMQ_coupon` WHERE `code` = '$coupon'")->fetch();
//check mã giới thiệu
$data_mgt = $db->query("SELECT `referral_code` FROM `TMQ_user` WHERE `referral_code` = '$magioithieu'")->fetch();
//lấy tên chuyên mục
$data_category = $db->query("SELECT `name` FROM `TMQ_chuyenmuc` WHERE `id` = '".$data['loai']."'")->fetch()['name'];

if($data['id'] == null){
    $result = 'Tài khoản không tồn tại';
}elseif($id == null){
    $result = 'Có lỗi xảy ra!';
}elseif($data['trangthai'] == 'off'){
    $result = 'Tài khoản đã được mua bởi người khác.';
}elseif($data['cash'] > TMQ_user()['cash']){
    $result = 'Tài khoản của bạn không đủ tiền.';
}elseif(!empty($coupon) && $data_coupon['code'] == null){
   $result = 'Mã giảm giá không tồn tại.';
}elseif(!empty($coupon) && $data_coupon['amount'] >= $data['cash']){
   $result = 'Mã giảm giá không phù hợp.';   
}elseif(!empty($magioithieu) && !$data_mgt['referral_code']){
    $result = 'Mã giới thiệu không hợp lệ.';
}else{
    if($data_coupon['code'] == null){
        $giamoi = $data['cash'];
    }else{
        $giamoi = $data['cash']-$data_coupon['amount'];
    }
    $result = 'Thành công.';
    $text = $data['taikhoan']."\n".$data['matkhau']."\n".$data_category."\n#".$id;
    //xử lý dữ liệu
    $db->exec("UPDATE `TMQ_user` SET `cash` = `cash` - ".$giamoi." WHERE `username` = '".TMQ_user()['username']."'");
    $db->exec("UPDATE `TMQ_baiviet` SET `trangthai` = 'off' WHERE `id` = '$id'");
    $db->exec("UPDATE `TMQ_coupon` SET `solan` = `solan` - 1 WHERE `code` = '$coupon'");
    $db->exec("DELETE FROM `TMQ_coupon` WHERE `solan` = '0'");
    $cash_truoc = TMQ_user()['cash']+$giamoi;
    $cash_sau = TMQ_user()['cash'];
    
    $db->exec("INSERT INTO `TMQ_history` SET
    `buyer` = '".TMQ_user()['username']."', 
    `seller` = '".$data['username']."', 
    `infomation` = '$text', 
    `cash` = '$giamoi', 
    `original` = '$cash_truoc',
    `sodu` = '$cash_sau', 
    `loai` = 'muanick', 
    `time` = '".time()."'
    ");
}
print $result;


}