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
require ("../../TMQ_sys/function.php");
//LẤY ID
$id = isset($_POST['id']) ? (int)$_POST['id'] : header("Location: /");
//LẤY DATA
$data = $db->query("SELECT * FROM `TMQ_service` WHERE `id` = '$id'")->fetch();
$name = strtolower(TMQ_xoadau($data['name']));
//KIỂM TRA DATA
if ($data['id'] == null)
{
    header("Location: /");
}
//LẤY GIÁ TIỀN
$price = $data['cash'];


//LẤY TỶ LỆ
$value = explode(PHP_EOL, $data['value']);
$count = count($value);
for ($a = 0;$a < $count;$a++)
{
    $mang[$a] = explode("|", $value[$a]);
}

//KIỂM TRA ĐIỀU KIỆN
if (empty(TMQ_user() ['id']))
{
    $status = 'LOGIN';
}
elseif (TMQ_user() ['cash'] < $price)
{
    $status = 'ERROR';
    $msg = 'Số dư không đủ';
}
elseif (TMQ_user() ['ban'] != 0)
{
    $status = 'ERROR';
    $msg = 'Tài khoản của bạn đã bị khóa';
}
elseif ($data['status'] == 'off'){
    $status = 'ERROR';
    $msg = 'Vòng quay đang bảo trì';
}
else
{
    //SẮP XẾP LẠI MẢNG
    $kq = SelectionSortAscending($mang);
    
    
    //RANDOM TỈ LỆ
    $random = rand(1, 100);
    
    
    //CHẠY VÒNG LẶP LẤY THÔNG TIN
    foreach ($kq as $key => $row)
    {
        $dulieu[$key] = $row[0];
        $gift[$key] = $row[2];
        $pos[$key] = $row[1];
        $loai[$key] = $row[3];
    }
    //KIỂM TRA KẾT QUẢ
    if ($random < $dulieu[0])
    {
        $gift = $gift[0];
        $pos = $pos[0];
        $loai = $loai[0];
    }
    elseif ($random < $dulieu[1])
    {
        $gift = $gift[1];
        $pos = $pos[1];
        $loai = $loai[1];
    }
    elseif ($random < $dulieu[2])
    {
        $gift = $gift[2];
        $pos = $pos[2];
        $loai = $loai[2];
    }
    elseif ($random < $dulieu[3])
    {
        $gift = $gift[3];
        $pos = $pos[3];
        $loai = $loai[3];
    }
    elseif ($random < $dulieu[4])
    {
        $gift = $gift[4];
        $pos = $pos[4];
        $loai = $loai[4];
    }
    elseif ($random < $dulieu[5])
    {
        $gift = $gift[5];
        $pos = $pos[5];
        $loai = $loai[5];
    }
    elseif ($random < $dulieu[6])
    {
        $gift = $gift[6];
        $pos = $pos[6];
        $loai = $loai[6];
    }
    elseif ($random < $dulieu[7])
    {
        $gift = $gift[7];
        $pos = $pos[7];
        $loai = $loai[7];
    }
    $status = null;
    $msg = array(
        'name' => $gift,
        'pos' => $pos,
        'locale' => 2,
        'input_auto' => 0,
        'ruby' => 8
    );
    
    
    
    
    
    //TRỪ TIỀN
    $db->exec("UPDATE `TMQ_user` SET `cash` = `cash` - $price WHERE `id` = '" . TMQ_user() ['id'] . "'");
    
    
    
    //LƯU LỊCH SỬ
    $text = 'Bạn nhận được phần thưởng '.$gift;
    $before = TMQ_user()['cash']+$price;
    TMQ_history(null,TMQ_user()['username'],$text,$price,$before,TMQ_user()['cash'],$name);
    
    //VẬT PHẨM TỰ ĐỘNG GỬI
    $check_item = $db->query("SELECT `id`,`name` FROM `TMQ_withdrawruby_form` WHERE `name` LIKE '%".$loai."%' AND `loai` = 'auto'")->fetch();
    if($check_item != null)
    {
        
        $get_item = $db->query("SELECT * FROM `TMQ_service_gift` WHERE `loai` = '$loai' ORDER BY RAND() LIMIT 1")->fetch();
        
        if($get_item['id'] != NULL)
        {
            
            $text = $get_item['text'];
            
            $db->exec("INSERT INTO `TMQ_history_gift` 
            (`username`,`text`,`loai`,`service`,`date`)
            VALUES
            ('".TMQ_user()['username']."','$text','$loai','".$data['name']."','".date("H:i:s d-m-Y")."')
            ");
        }
        
    }
    
    
    //CỘNG VẬT PHẨM CÓ THỂ RÚT THEO FORM
    if ($loai != 'null')
    { //NẾU LOẠI KHÁC NULL THÌ CHECK TIẾP
        $check = $db->query("SELECT `id` FROM `TMQ_service_trans` WHERE `loai` = '$loai' AND `username` = '" . TMQ_user() ['username'] . "' LIMIT 1")->fetch();
        if ($check['id'] == null)
        { //NẾU KHÔNG TỒN TẠI THÌ INSERT
            $db->exec("INSERT INTO `TMQ_service_trans` (`username`,`cash`,`loai`) VALUES ('" . TMQ_user() ['username'] . "','" . (int)$gift . "','$loai')");
        }
        else
        { //NẾU ĐÃ TỒN TẠI THÌ TIẾN HÀNH CỘNG
            $db->exec("UPDATE `TMQ_service_trans` SET `cash` = `cash` + '" . (int)$gift . "' WHERE `username` = '" . TMQ_user() ['username'] . "' AND `loai` = '$loai'");
        }
    }
}
//DỮ LIỆU TRẢ VỀ JSON
$data = array(
    'status' => $status,
    'numrollbyorder' => $pos,
    'msg' => $msg,
);
die(json_encode($data));
exit;