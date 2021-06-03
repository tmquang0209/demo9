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
include $_SERVER['DOCUMENT_ROOT'] . '/TMQ_sys/database.php';
include $_SERVER['DOCUMENT_ROOT'] . '/TMQ_sys/PHPMailer/PHPMailerAutoload.php';

// PAM Import File
include $_SERVER['DOCUMENT_ROOT'] . '/PAM/init.php';


//TEST CODE
function TMQ_pre($code)
{
    return '<pre>' . print_r($code) . '</pre><br />';
}


//Maintenance
function TMQ_baotri()
{
    global $db;
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $web_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $setting = $db->query("SELECT baotri FROM `TMQ_setting` WHERE `id` = '1' LIMIT 1")
        ->fetch();
    if ($setting['baotri'] == 'off') {
        if ($actual_link != $web_link . '/admin') {
            die('bảo trì');
        }
    }

}

//mã hóa
function TMQ_mahoa($var)
{
    return sha1(md5(md5(md5(md5(md5($var))))));
}

//bọc hàm
function TMQ_check($var)
{
    return trim(addslashes(htmlspecialchars(strip_tags($var), ENT_QUOTES, 'UTF-8')));
}

//domain
function TMQ_domain()
{
    return $_SERVER['HTTP_HOST'];
}

//setting
function TMQ_setting()
{
    global $db;
    $setting = $db->query("SELECT * FROM `TMQ_setting` WHERE `id` = '1'")
        ->fetch();
    return $setting;
}

//tạo chuỗi random
function TMQ_random($length)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $size = strlen($chars);
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[rand(0, $size - 1)];
    }
    return $str;
}

//Position
function TMQ_admin()
{
    return TMQ_user()['admin'];
}

//Chức vụ
function TMQ_position($id)
{
    global $db;
    $smtp = $db->query("SELECT `id`,`admin` FROM `TMQ_user` WHERE `id` = '$id'")->fetch();
    if ($smtp['admin'] == 0) {
        $result = 'Thành viên';
    } elseif ($smtp['admin'] == 1) {
        $result = 'Cộng tác viên';
    } elseif ($smtp['admin'] == 9) {
        $result = 'Quản trị viên';
    }
    return $result;
}

//insert change
function TMQ_history($seller, $buyer, $text, $cash, $before, $after, $loai)
{
    global $db;
    $db->exec("INSERT INTO `TMQ_history` SET
    `buyer` = '$buyer', 
    `seller` = '$seller', 
    `infomation` = '$text', 
    `cash` = '$cash', 
    `original` = '$before',
    `sodu` = '$after', 
    `loai` = '$loai', 
    `time` = '" . time() . "'
    ");
}

//User data
function TMQ_user()
{
    global $db;
    $id = $_SESSION['id'];
    $id = isset($id) ? (int)$id : null;
    $user = $db->query("SELECT * FROM `TMQ_user` WHERE `id`= '$id'")->fetch();
    return isset($user) ? $user : null;
}

//bbcode
function TMQ_bbcode($str)
{
    $Bbcode = array(
        $_SERVER['HTTP_HOST'] => '{domain}',
        strtoupper($_SERVER['HTTP_HOST']) => '{domain_strtoupper}',
        TMQ_setting()['phone'] => '{phone}',
        date("d") => '{day}',
        date("m") => '{month}',
        date("Y") => '{year}',
        TMQ_admin() => '{admin}',
    );
    foreach ($Bbcode as $nonBbcode => $bb) {
        $str = preg_replace("/($bb)/i", $nonBbcode, $str);
    }

    return $str;
}

//sendmail
function TMQ_mail($email_nhan, $chu_de, $body)
{
    $set = explode(PHP_EOL, TMQ_setting() ['send_mail']);
    $fromserver = $set[0];
    $pass = $set[1];
    $port = $set[2];
    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = $port; // or 587
    $mail->IsHTML(true);
    $mail->Username = $fromserver;
    $mail->Password = $pass;
    $mail->SetFrom($fromserver, "Trần Minh Quang");
    $mail->Subject = $chu_de;
    $mail->Body = $body;
    $mail->AddAddress("$email_nhan");

    if (!$mail->Send()) {
        echo $mail->ErrorInfo;
        echo "Gửi thất bại.";
    } else {
        echo "Thư đã được gửi. Vui lòng kiểm tra Email";
    }

}

//cắt ngắn ký tự
function TMQ_cut($string = '', $size = 100, $link = '...')
{
    $string = strip_tags(trim($string));
    $strlen = strlen($string);
    $str = substr($string, $size, 20);
    $exp = explode(" ", $str);
    $sum = count($exp);
    $yes = "";
    for ($i = 0; $i < $sum; $i++) {
        if ($yes == "") {
            $a = strlen($exp[$i]);
            if ($a == 0) {
                $yes = "no";
                $a = 0;
            }
            if (($a >= 1) && ($a <= 12)) {
                $yes = "no";
                $a;
            }
            if ($a > 12) {
                $yes = "no";
                $a = 12;
            }
        }
    }
    $sub = substr($string, 0, $size + $a);
    if ($strlen - $size > 0) {
        $sub .= $link;
    }
    return $sub;
}

//Phân trang
function TMQ_phantrang($url, $start, $total, $kmess)
{
    $out[] = '<div class="row"><center><ul class="pagination">';
    $neighbors = 2;
    if ($start >= $total) $start = max(0, $total - (($total % $kmess) == 0 ? $kmess : ($total % $kmess)));
    else $start = max(0, (int)$start - ((int)$start % (int)$kmess));
    $base_link = '<li><a class="pagenav" href="' . strtr($url, array(
            '%' => '%%'
        )) . 'page=%d' . '">%s</a></li>';
    $out[] = $start == 0 ? '' : sprintf($base_link, $start / $kmess, '«');
    if ($start > $kmess * $neighbors) $out[] = sprintf($base_link, 1, '1');
    if ($start > $kmess * ($neighbors + 1)) $out[] = '<li><a>...</a></li>';
    for ($nCont = $neighbors; $nCont >= 1; $nCont--) if ($start >= $kmess * $nCont) {
        $tmpStart = $start - $kmess * $nCont;
        $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
    }
    $out[] = '<li class="active"><a>' . ($start / $kmess + 1) . '</a></li>';
    $tmpMaxPages = (int)(($total - 1) / $kmess) * $kmess;
    for ($nCont = 1; $nCont <= $neighbors; $nCont++) if ($start + $kmess * $nCont <= $tmpMaxPages) {
        $tmpStart = $start + $kmess * $nCont;
        $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
    }
    if ($start + $kmess * ($neighbors + 1) < $tmpMaxPages) $out[] = '<li><a>...</a></li>';
    if ($start + $kmess * $neighbors < $tmpMaxPages) $out[] = sprintf($base_link, $tmpMaxPages / $kmess + 1, $tmpMaxPages / $kmess + 1);
    if ($start + $kmess < $total) {
        $display_page = ($start + $kmess) > $total ? $total : ($start / $kmess + 2);
        $out[] = sprintf($base_link, $display_page, '»');
    }
    $out[] = '</ul></center></div>';
    return implode('', $out);
}

//Delete accents
function TMQ_xoadau($str)
{
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D' => 'Đ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    $str = str_replace(' ', '_', $str);
    return $str;
}

//ẩn email
function TMQ_hide_email($email)

{
    $character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';

    $key = str_shuffle($character_set);
    $cipher_text = '';
    $id = 'e' . rand(1, 999999999);

    for ($i = 0; $i < strlen($email); $i += 1) $cipher_text .= $key[strpos($character_set, $email[$i])];

    $script = 'var a="' . $key . '";var b=a.split("").sort().join("");var c="' . $cipher_text . '";var d="";';

    $script .= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';

    $script .= 'document.getElementById("' . $id . '").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';

    $script = "eval(\"" . str_replace(array(
            "\\",
            '"'
        ), array(
            "\\\\",
            '\"'
        ), $script) . "\")";

    $script = '<script type="text/javascript">/*<![CDATA[*/' . $script . '/*]]>*/</script>';

    return '<span id="' . $id . '">[javascript protected email address]</span>' . $script;

}

//sắp xếp mảng
function SelectionSortAscending($mang)
{
    // Đếm tổng số phần tử của mảng
    $sophantu = count($mang);

    // Lặp để sắp xếp
    for ($i = 0; $i < $sophantu - 1; $i++) {
        // Tìm vị trí phần tử nhỏ nhất
        $min = $i;
        for ($j = $i + 1; $j < $sophantu; $j++) {
            if ($mang[$j] < $mang[$min]) {
                $min = $j;
            }
        }

        // Sau khi có vị trí nhỏ nhất thì hoán vị
        // với vị trí thứ $i
        $temp = $mang[$i];
        $mang[$i] = $mang[$min];
        $mang[$min] = $temp;
    }

    // Trả về mảng đã sắp xếp
    return $mang;
}

function json_encode_objs($item)
{
    if (!is_array($item) && !is_object($item)) {
        return json_encode($item);
    } else {
        $pieces = array();
        foreach ($item as $k => $v) {
            $pieces[] = "\"$k\":" . json_encode_objs($v);
        }
        return '{' . implode(',', $pieces) . '}';
    }
}

if (!function_exists('debug')) {
    function debug($type, $name, $text = null)
    {
        $file = fopen($_SERVER['DOCUMENT_ROOT'] . '/log/debug.txt', "w") or die("Unable to open file!");

        if (is_array($text)) {
            $text = json_encode($text);
        } elseif (is_object($text)) {
            $text = json_encode_objs($text);
        }

        fwrite($file, "[{$type}] {$name}: {$text}" . PHP_EOL);
        fclose($file);
    }
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/license.php')) {
    require($_SERVER['DOCUMENT_ROOT'] . '/license.php');
} else {
    die("The file license doesn't exists");
}
//Ban tài khoản
if (TMQ_user() ['ban'] == 1) {
    die('<p style="font-size:40px;text-align:center;color:red;">Your account has been disabled. Please contact admin for assistance!');
    exit();
}

// Register Recharge Service
$rechargeApiSetting = json_decode(TMQ_setting()['api_napthe'], true) ?? [];
$rechargeCard = new \PAM\RechargeCard($rechargeApiSetting['service'], $rechargeApiSetting['id'], $rechargeApiSetting['secret']);

$rechargeService = null;

if ($rechargeCard->service($rechargeApiSetting['service'])) {
    $rechargeService = $rechargeCard->service($rechargeApiSetting['service']);
}
