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
require('../TMQ_sys/function.php');
require('head.php');
if (TMQ_admin() != 9) {
    header('Location: /');
}
$email = explode(PHP_EOL, TMQ_setting()['send_mail']);
if (isset($_POST['submit'])) {
    $title = TMQ_check($_POST['title']);
    $logo = TMQ_check($_POST['logo']);
    $email = TMQ_check($_POST['email']);
    $phone = TMQ_check($_POST['phone']);
    $facebook = TMQ_check($_POST['facebook']);
    $youtube = TMQ_check($_POST['youtube']);
    $limit = (int)$_POST['limit'];
    $noti = trim(addslashes(htmlspecialchars($_POST['notification'])));
    $baotri = TMQ_check($_POST['baotri']);
    $db->exec("UPDATE `TMQ_setting` SET
    `title`= '$title',
    `thongbao` = '$noti',
    `phone`= '$phone',
    `email`= '$email',
    `logo`= '$logo',
    `baotri` = '$baotri',
    `facebook`= '$facebook',
    `youtube`= '$youtube',
    `limit_page`= '$limit'
");
}
if (isset($_POST['setting_email'])) {
    $username = TMQ_check($_POST['username']);
    $password = TMQ_check($_POST['password']);
    $port = (int)$_POST['port'];
    $db->exec("UPDATE `TMQ_setting` SET `send_mail`= '$username\n$password\n$port'");
}
if (isset($_POST['setting_themes'])) {


    $header = trim(addslashes($_POST['header']));
    $header = str_replace("<script>", null, $header);
    $header = str_replace("</script>", null, $header);


    $footer = trim(addslashes($_POST['footer']));
    $footer = str_replace("<script>", null, $footer);
    $footer = str_replace("</script>", null, $footer);

    $pos = strpos($footer, 'https://www.facebook.com/tmq.dz.pro');

    if ($pos === false) {
        echo('<script>alert(\'Xóa bản quyền làm gì?\');</script>');
    } else {
        $banner = TMQ_check($_POST['banner']);
        $db->exec("UPDATE `TMQ_setting` SET `header` = '$header',`footer` = '$footer',`banner` = '$banner'");
    }
}
if (isset($_POST['setting_atm'])) {
    $atm = TMQ_check($_POST['atm']);
    $wallet = TMQ_check($_POST['wallet']);
    $db->exec("UPDATE `TMQ_setting` SET `atm` = '$atm',`wallet` = '$wallet'");
}
if (isset($_POST['setting_api'])) {
    $service = TMQ_check($_POST['service']);
    $id = TMQ_check($_POST['id']);
    $partner = TMQ_check($_POST['partner_key']);

    $app_id = TMQ_check($_POST['app_id']);
    $app_secret = TMQ_check($_POST['app_secret']);

    $db->exec("UPDATE `TMQ_setting` SET `api_napthe` = '" . json_encode([
            'service' => $service,
            'id' => $id,
            'secret' => $partner
        ]) . "'");
    $db->exec("UPDATE `TMQ_setting` SET `api_login` = '$app_id\n$app_secret'");
}
?>
<link rel="stylesheet" href="/assets/code/lib/codemirror.css">
<link rel="stylesheet" href="/assets/code/addon/dialog/dialog.css">
<link rel="stylesheet" href="/assets/code/addon/search/matchesonscrollbar.css">
<script src="/assets/code/lib/codemirror.js"></script>
<script src="/assets/code/xml.js"></script>
<script src="/assets/code/addon/dialog/dialog.js"></script>
<script src="/assets/code/addon/search/searchcursor.js"></script>
<script src="/assets/code/addon/search/search.js"></script>
<script src="/assets/code/addon/scroll/annotatescrollbar.js"></script>
<script src="/assets/code/addon/search/matchesonscrollbar.js"></script>
<script src="/assets/code/addon/search/jump-to-line.js"></script>
<style>
    .CodeMirror {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }

    dt {
        font-family: monospace;
        color: #666;
    }
</style>
<style>
    /* Style tab links */
    .tablink {
        background-color: #555;
        color: white;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        font-size: 17px;
        width: 20%;
    }

    .tablink:hover {
        background-color: #777;
        text-align: center;
    }
</style>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title"> Quản lý hệ thống </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/admin/main">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Quản lý hệ thống</li>
        </ol>
      </nav>
    </div>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <button class="tablink" onclick="openPage('infomation')" id="defaultOpen">Thông tin web</button>
            <button class="tablink" onclick="openPage('setting_email')">Cấu hình email</button>
            <button class="tablink" onclick="openPage('setting_themes')">Cài đặt giao diện</button>
            <button class="tablink" onclick="openPage('setting_atm')">ATM/Ví điện tử</button>
            <button class="tablink" onclick="openPage('setting_api')">Api website</button>
            <br /><br /><br /><br />


              <?php if (!$_GET) {
                  $status = array(
                      "Working" => '<label class="badge badge-success">Hoạt động</label>',
                      "Expired" => '<label class="badge badge-danger">Hết hạn</label>'
                  );
                  $status = $status[$license->status()];
                  ?>
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">

                      <h4 class="card-title" style="text-align:center;">THÔNG TIN WEBSITE</h4>
                      <div class="row">
                        <table style="text-align:center;" class="table table-hover table-bordered table-contextual">
                          <thead>
                          <tr>
                            <th>Mã kích hoạt</th>
                            <th><?= $license->code(); ?></th>
                          </tr>
                          <tr>
                            <th>Trạng thái</th>
                            <th><?= $status; ?></th>
                          </tr>
                          <tr>
                            <th>Thời gian sử dụng</th>
                            <th><?= $license->expiry_date(); ?></th>
                          </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>


                  <?php
              }
              if (isset($_GET['infomation'])): ?>
                <form class="forms-sample" method="POST">
                  <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" placeholder="Title Website" name="title"
                           value="<?= TMQ_setting()['title']; ?>">
                  </div>
                  <div class="form-group">
                    <label>Logo</label>
                    <input type="text" class="form-control" placeholder="Logo url" name="logo"
                           value="<?= TMQ_setting()['logo']; ?>">
                  </div>

                  <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" placeholder="email" name="email"
                           value="<?= TMQ_setting()['email']; ?>">
                  </div>

                  <div class="form-group">
                    <label>Number phone</label>
                    <input type="text" class="form-control" placeholder="Number phone" name="phone"
                           value="<?= TMQ_setting()['phone']; ?>">
                  </div>

                  <div class="form-group">
                    <label>Facebook</label>
                    <input type="text" class="form-control" placeholder="Url fanpage" name="facebook"
                           value="<?= TMQ_setting()['facebook']; ?>">
                  </div>

                  <div class="form-group">
                    <label>Youtube</label>
                    <input type="text" class="form-control" placeholder="Url youtube" name="youtube"
                           value="<?= TMQ_setting()['youtube']; ?>">
                  </div>

                  <div class="form-group">
                    <label>1 page per page limit</label>
                    <input type="text" class="form-control" placeholder="1 page per page limit" name="limit"
                           value="<?= TMQ_setting()['limit_page']; ?>">
                  </div>
                  <div class="form-group">
                    <label>Notification</label>
                    <textarea rows="10" type="text" class="form-control" placeholder="Notification"
                              name="notification"><?= TMQ_setting()['thongbao']; ?></textarea>
                  </div>
                  <div class="form-group">
                    <label>Maintenance</label>
                    <select class="form-control" name="baotri">
                      <option <?php if (TMQ_setting()['baotri'] == 'on'){ ?>selected<?php } ?> value="on">Hoạt động
                      </option>
                      <option <?php if (TMQ_setting()['baotri'] == 'off'){ ?>selected<?php } ?> value="off">Bảo trì
                      </option>
                    </select>
                  </div>


                  <input type="hidden" name="infomation" value="infomation" />
                  <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                </form>
              <?php endif;
              if (isset($_GET['setting_email'])):
                  ?>
                <form class="forms-sample" method="POST">
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" placeholder="Username..." name="username"
                           value="<?= $email[0]; ?>">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="text" class="form-control" placeholder="Password..." name="password"
                           value="<?= $email[1]; ?>">
                  </div>
                  <div class="form-group">
                    <label>Port</label>
                    <input type="number" class="form-control" placeholder="Port..." name="port"
                           value="<?= $email[2]; ?>">
                  </div>
                  <button type="submit" name="setting_email" class="btn btn-primary mr-2">Submit</button>
                </form>
              <?php endif;
              if (isset($_GET['setting_themes'])): ?>
                <form method="POST">
                  <div class="form-group"><label>Header</label>
                    <textarea id="code1" name="header">
    <?= TMQ_setting()['header']; ?>
    </textarea>
                  </div>
                  <div class="form-group"><label>Footer</label>
                    <textarea id="code2" name="footer">
    <?= TMQ_setting()['footer']; ?>
    </textarea>
                  </div>
                  <div class="form-group"><label>Banner</label>
                    <textarea id="code3" name="banner"><?= TMQ_setting()['banner']; ?></textarea>
                  </div>
                  <button type="submit" name="setting_themes" class="btn btn-primary mr-2">Submit</button>
                </form>
                <p></p>
                <h1 style="color:yellow;">Danh sách function</h1>
                <p>- {domain}: hiển thị tên domain của bạn</p>
                <p>- {domain_strtoupper}: in hoa teen miền</p>
                <p>- {phone}: lấy số điện thoại trong setting</p>
                <p>- {day}: lấy ngày hiện tại</p>
                <p>- {month}: lấy tháng hiện tại</p>
                <p>- {year}: lấy năm hiện tại</p>
                <p>- {admin}: lấy quyền admin</p>
              <?php endif;
              if (isset($_GET['setting_atm'])):
                  ?>
                <form method="POST">
                  <div class="form-group"><label>Ngân hàng (ATM)</label>
                    <textarea id="code1" name="atm"><?= TMQ_setting()['atm']; ?></textarea>
                  </div>
                  <div class="form-group"><label>Ví điện tử</label>
                    <textarea id="code2" name="wallet"><?= TMQ_setting()['wallet']; ?></textarea>
                  </div>
                  <button type="submit" name="setting_atm" class="btn btn-primary mr-2">Submit</button>
                </form>
              <?php endif;
              if (isset($_GET['setting_api'])):
                  $napthe = json_decode(TMQ_setting()['api_napthe'], true);
                  $login = explode(PHP_EOL, TMQ_setting()['api_login']);
                  $rechargeServiceList = [
                      'CardVip' => 'CardVip.Vn',
                      'NapTuDong' => 'NapTuDong.Com',
                      'TheSieuRe' => 'TheSieuRe.Com',
                  ];
                  ?>
                <form method="POST">
                  <hr style="border-top: 1px dashed yellow;">
                  <h2 style="text-align:center;">Api nạp thẻ</h2>
                  <hr style="border-top: 1px dashed yellow;">
                  <div class="form-group">
                    <select class="form-control" name="service">
                        <?php foreach ($rechargeServiceList as $key => $value): ?>
                          <option
                            value="<?= $key ?>" <?= $key === $napthe['service'] ? 'selected' : null ?> ><?= $value ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group"><label>ID</label>

                    <input type="text" class="form-control" name="id" value="<?= $napthe['id']; ?>" />
                  </div>
                  <div class="form-group"><label>Partner Key</label>
                    <input type="text" class="form-control" name="partner_key" value="<?= $napthe['secret']; ?>" />
                  </div>
                  <div style="color:red;">
                    <p style="font-size:20px;">
                      Link
                      callback: <?= 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/profile/callback"; ?>
                    </p>
                  </div>
                  <hr style="border-top: 1px dashed yellow;">
                  <h2 style="text-align:center;">Api login facebook</h2>
                  <hr style="border-top: 1px dashed yellow;">
                  <div class="form-group"><label>App ID</label>
                    <input type="text" class="form-control" name="app_id" value="<?= $login[0]; ?>" />
                  </div>
                  <div class="form-group"><label>App Secret</label>
                    <input type="text" class="form-control" name="app_secret" value="<?= $login[1]; ?>" />
                  </div>
                  <div style="color:red;">
                    <p style="font-size:20px;">
                      Note: Truy cập vào <a href="http://developer.facebook.com/"
                                            target="_blank">Developer.facebook.com</a> để tạo app
                    </p>
                    <p style="font-size:20px;">
                      Miền ứng dụng nhập: <?= TMQ_domain(); ?>
                    </p>
                    <p style="font-size:20px;">
                      Url chuyển hướng hợp
                      lệ: <?= 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/login_facebook"; ?>
                      và <?= 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}"; ?>
                    </p>
                  </div>
                  <button type="submit" name="setting_api" class="btn btn-primary mr-2">Submit</button>
                </form>
              <?php endif; ?>


          </div>
        </div>
      </div>
    </div>

  </div>
  <script>
    function openPage(pageName) {
      window.location = '/admin/setting?' + pageName;
    }

    var editor = CodeMirror.fromTextArea(document.getElementById('code1'), {
      mode: 'text/html',
      lineNumbers: true,
      extraKeys: { 'Alt-F': 'findPersistent' },
    });

    var editor = CodeMirror.fromTextArea(document.getElementById('code2'), {
      mode: 'text/html',
      lineNumbers: true,
      extraKeys: { 'Alt-F': 'findPersistent' },
    });

    var editor = CodeMirror.fromTextArea(document.getElementById('code3'), {
      mode: 'text/html',
      lineNumbers: true,
      extraKeys: { 'Alt-F': 'findPersistent' },
    });

  </script>
  <!-- content-wrapper ends -->
    <?php require('foot.php'); ?>
