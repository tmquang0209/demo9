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

$callback = $rechargeService->callback($_GET ?? $_POST);

debug('CALLBACK', 'Callback Var', $callback);
debug('CALLBACK', 'GET Params', $_GET);
debug('CALLBACK', 'POST Form Data', $_POST);

if (isset($callback)) {

    if ($callback['success'] == "1") {
        $get_the = $db->query("SELECT * FROM `TMQ_napthe` WHERE `tran_id` = '" . $callback['data']['tranid'] . "' AND `mathe` = '" . $callback['data']['pin'] . "'")->fetch();
        // status = 1 ==> thẻ đúng + Cộng tiền cho khách bằng  $_GET['amount'] tại đây
        $congtien = $db->prepare("UPDATE `TMQ_user` SET `cash` = `cash` + ? WHERE `username` = ?");
        $congtien->execute(array(
            $callback['data']['amount'],
            $get_the['username']
        ));

        $update = $db->prepare("UPDATE `TMQ_napthe` SET `status` = ? WHERE `mathe` = ? AND `tran_id` = ?");
        $update->execute(array(
            'Thành công',
            $callback['data']['pin'],
            $callback['data']['tranid']
        ));

    } else {
        /// Thẻ sai hoặc đã được nạp
        $update = $db->prepare("UPDATE `TMQ_napthe` SET `status` = ? WHERE `mathe` = ? AND `tran_id` = ?");
        $update->execute(array(
            'Thẻ sai',
            $callback['pin'],
            $callback['tranid']
        ));

    }

}
