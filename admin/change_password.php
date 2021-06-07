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

if(empty($_SESSION['id'])) header("Location: /");

if(isset($_POST['change'])){
    $old = TMQ_check($_POST['old_pass']);
    $new = TMQ_check($_POST['new_pass']);
    $re = TMQ_check($_POST['re_pass']);
    
    
    if(TMQ_mahoa($old) != TMQ_user()['password']){
        $err = "Password cũ không chính xác";
    }elseif($new != $re){
        $err = "2 mật khẩu không trùng nhau";
    }elseif($old == $new){
        $err = "Mật khẩu mới không được giống mật khẩu cũ";
    }else{
        $new = TMQ_mahoa($new);
        $db->exec("UPDATE `TMQ_user` SET `password_2` = ".$db->quote($new)." WHERE `id` = '".TMQ_user()['id']."'");
        header("Location: /admin/main");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Change Password|Admin Cpanel</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Change Password</h3>
                <div style="color:red;"><?=$err;?></div>
                <form method="POST">
                  <div class="form-group">
                    <label>Mật khẩu cũ *</label>
                    <input name="old_pass" type="text" class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>Mật khẩu mới *</label>
                    <input name="new_pass" type="text" class="form-control p_input">
                  </div>
                   <div class="form-group">
                    <label>Nhập lại mật khẩu mới *</label>
                    <input name="re_pass" type="text" class="form-control p_input">
                  </div>
                  
                  <div class="text-center">
                    <button name="change" type="submit" class="btn btn-primary btn-block enter-btn">Change</button>
                  </div>
                  </form>
                  <div class="d-flex">
                    <button onclick="window.location = '/';" class="btn btn-facebook mr-2 col">Về Shop</button>
                    <button onclick="window.location = '/admin/main';" class="btn btn-google col">Về Admin Cpanel</button>
                  </div>
                
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>