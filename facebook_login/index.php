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
require_once ('Facebook/autoload.php');
require_once('../TMQ_sys/function.php');
require_once ('config.php');

$helper = $fb->getRedirectLoginHelper();
if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
}
try {
$accessToken = $helper->getAccessToken($domain);
//$accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
    
if (! isset($accessToken)) {
    
    $permissions = array('public_profile','email'); // Optional permissions
    $loginUrl = $helper->getLoginUrl($domain,$permissions);
    header("Location: ".$loginUrl);  
  exit;
}

try {
  // Returns a `Facebook\FacebookResponse` object
  $fields = array('id', 'name', 'email');
//  $response = $fb->get('/me?fields='.implode(',', $fields).'', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
$_SESSION['facebook_access_token'] = (string) $accessToken;


$response = $fb->get('/me?fields=id,name,email', $accessToken);
$name = $response->getGraphUser()['name'];
@$email = $response->getGraphUser()['email'];
$fb_ID = $response->getGraphUser()['id'];
$referral_code = strtoupper(TMQ_random(6));

$check = $db->query("SELECT * FROM `TMQ_user` WHERE `username` = '$fb_ID'");
$check_number = $check->rowcount();
if($check_number == 0){
//Lưu tài khoản vào Database rồi đăng nhập
 $smtp = $db->prepare("INSERT INTO `TMQ_user` 
    (`name`, `username`, `password`,`password_2`,`login`, `phone`, `email`, `cash`, `ban`,`referral_code` ,`admin`,`date`) 
    VALUES 
    (?,?,?,?,?,?,?,?,?,?,?,?)");
    $data = array($name,$fb_ID,null,null,null,null,$email,0,0,$referral_code,0,date('H:i:s d-m-Y'));
    $smtp->execute($data);
}
$_SESSION['id'] = $check->fetch()['id'];
header("Location: /");

?>