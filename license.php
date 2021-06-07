<?php
/*
*
* CODE ĐƯỢC THỰC HIỆN BỞI TRẦN MINH QUANG (TMQ)
* PHONE: 0397847805 - EMAIL: tmquang0209@gmail.com
* VUI LÒNG KHÔNG XÓA DÒNG NÀY ĐỂ TÔN TRỌNG TÁC GIẢ
* XIN CẢM ƠN!
*
*/

//class license
//{
//
//    public function get()
//    { //get license
//        global $db;
//        $data = $db->query("SELECT * FROM `TMQ_license` LIMIT 1")->fetch();
//        $this->code = $data['key'];
//        $this->expiry_date = $data['expiry_date'];
//        $this->status = $data['status'];
//    }
//
//    public function code()
//    { //get key
//        return $this->code;
//    }
//
//    public function expiry_date()
//    { //get expiry date
//        return $this->expiry_date;
//
//    }
//
//    public function status()
//    { //get status
//        return $this->status;
//    }
//
//    public function check() //check code
//    {
//        $key = $this->code();
//        $param = array('key' => $key, "domain" => $_SERVER['HTTP_HOST']);
//        $url = 'https://tmquang.xyz/check_key.php';
//        $ch = curl_init($url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_POST, count($param));
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
//        $result = curl_exec($ch);
//        curl_close($ch);
//        if ($result == 0) {
//            return die('License is not valid');
//        } elseif ($result == 1) {
//            return die('The domain is incorrect');
//        } elseif ($result == 2) {
//            return die('The license has expired');
//        }
//    }
//
//    public function update()
//    {
//        global $db;
//        if (isset($_POST['date']) || isset($_POST['server']) || isset($_POST['secret']) || isset($_POST['key'])) {
//
//
//            $date = (int)TMQ_check($_POST['date']);
//            $server = TMQ_check($_POST['server']);
//            $secret = TMQ_check($_POST['secret']);
//            $key = TMQ_check($_POST['key']);
//
//
//            switch ($date) {
//                case $date == 0:
//                    $status = "Expired";
//                    break;
//                case $date > 0:
//                    $status = "Working";
//                    break;
//                default:
//                    $status = "";
//                    break;
//            }
//
//            $check = $db->query("SELECT * FROM `TMQ_license` WHERE `key` = '$key' LIMIT 1")->fetch();
//            if ($check['key'] != null) {
//                if ($secret == $check['secret_code']) {
//                    if ($server == "tmquang.xyz") {
//                        $db->exec("UPDATE `TMQ_license` SET
//               `expiry_date` = " . $db->quote($date) . ",
//               `status` = '$status'
//               WHERE `key` = '$key' ");
//
//                    }
//                }
//            }
//
//        }
//    }
//}
//
//
//$license = new license();
// $license->get();
// $license->check();
// $license->update();
