<?
/*
$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
$$ NAME CODE: SHOP BÁN TỰ ĐỘNG ĐA CHỨC NĂNG             $$
$$ DEVELOPER: TRẦN MINH QUANG (TMQ)                     $$
$$ CONTACT: 0397847805 - tmquang0209@gmail.com          $$
$$ CREATE: 06/2020                                      $$
$$ VUI LÒNG KHÔNG XÓA BẢN QUYỀN ĐỂ TÔN TRỌNG TÁC GIẢ    $$
$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
*/
$info = explode(PHP_EOL,TMQ_setting()['api_login']);
$fb = new Facebook\Facebook ([
  'app_id' => $info[0], // Id app
  'app_secret' => $info[1], // Mã bảo mật app
  'default_graph_version' => 'v3.0', //Giữ Nguyên
  ]);
$domain = 'https://'.TMQ_domain().'/login_facebook'; //Domain có / ở cuối
?>