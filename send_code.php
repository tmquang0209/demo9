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
    $email = TMQ_check($_POST['email']);
    $username = TMQ_check($_POST['taikhoan']);
    $check = $db->query("SELECT `id`,`email` FROM `TMQ_user` WHERE `username` = '$username' AND `email` = ".$db->quote($email)." ")->fetch();
    $check_code = $db->query("SELECT `id` FROM `TMQ_key` WHERE `loai` = 'reset_password' AND `email` = ".$db->quote($email)."")->fetch();
    if(!empty($email) || !empty($username)){
        if($check['id'] != null){
            if($check_code['id'] == null){
    $key = rand(100000,999999);
    $title = 'Quên Mật Khẩu - '.TMQ_domain().'';
    $body = 'Mã xác nhận của bạn là: '.$key.'';
    $date = mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+1, date("Y"));
    $date = date("d-m-Y",$date);
    TMQ_mail($email,$title,$body);
    $db->exec("INSERT INTO `TMQ_key` 
    (`email`,`key`,`date`,`loai`) 
    VALUES 
    (".$db->quote($email).",".$db->quote($key).",".$db->quote($date).",'reset_password')");
                }else{
                 echo 'Email đã được gửi đi gần đây, vui lòng kiểm tra email!';}
        }else{
        echo 'Email không đúng!';}
    }else{
    echo 'Vui lòng nhập đủ Tài khoản và email!';}
