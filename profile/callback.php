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
$url = 'http://sys.napthenhanh.com/api/charging-wcb'; //url API gạch thẻ của hệ thống
$info = explode(PHP_EOL, TMQ_setting() ['api_napthe']);
$partner_id = $info[0]; //API key, lấy từ website napthenhanh.com
$partner_key = $info[1]; //API secret lấy từ website napthenhanh.com
$callback_sign = md5($partner_key . $_GET['tranid'] . $_GET['pin'] . $_GET['serial']);

if ($_GET['callback_sign'] != $callback_sign)
{
    exit();
}

if (isset($_GET['status']))
{

    if ($_GET['status'] == "1")
    {
       $get_the = $db->query("SELECT * FROM `TMQ_napthe` WHERE `tran_id` = '".$_GET['tranid']."' AND `mathe` = '".$_GET['pin']."'")->fetch();
        // status = 1 ==> thẻ đúng + Cộng tiền cho khách bằng  $_GET['amount'] tại đây
        $congtien = $db->prepare("UPDATE `TMQ_user` SET `cash` = `cash` + ? WHERE `username` = ?");
        $congtien->execute(array(
            $_GET['amount'],
           $get_the['username']
        ));

        $update = $db->prepare("UPDATE `TMQ_napthe` SET `status` = ? WHERE `mathe` = ? AND `tran_id` = ?");
        $update->execute(array(
            'Thành công',
            $_GET['pin'],
            $_GET['tranid']
        ));

    }
    else
    {
        /// Thẻ sai hoặc đã được nạp
        $update = $db->prepare("UPDATE `TMQ_napthe` SET `status` = ? WHERE `mathe` = ? AND `tran_id` = ?");
        $update->execute(array(
            'Thẻ sai',
            $_GET['pin'],
            $_GET['tranid']
        ));

    }

}

?>
