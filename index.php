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
if (!file_exists("TMQ_sys/database.php")) {
    header("Location: /install");
}
require('TMQ_sys/function.php');

TMQ_baotri();
require('TMQ_sys/head.php');
require('TMQ_sys/main.php');
require('TMQ_sys/foot.php');
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/license.php')) {
    require($_SERVER['DOCUMENT_ROOT'] . '/license.php');
} else {
    die("The file license doesn't exists");
}
