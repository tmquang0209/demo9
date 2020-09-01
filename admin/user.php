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
require('../TMQ_sys/PHPExcel/user.php');
require('head.php');
if (TMQ_admin() != 9) 
{
header('Location: /');
}
?><script src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
 <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Quản lý thành viên </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Quản lý thành viên</li>
                </ol>
              </nav>
            </div>
            <div class="row">
<?php
//cộng tiền thành viên
if(isset($_POST['congtien'])):
    $cash = $db->query("SELECT `cash` FROM `TMQ_user` WHERE `id` = '".TMQ_check($_POST['congtien'])."'")->fetch();
    $cash = $cash['cash'];
  if(isset($_POST['cong'])){
      $amount = (int)$_POST['amount'];
      $description = TMQ_check(strip_tags($_POST['description']));
      $uid = (int)$_POST['congtien'];
      $data = $db->query("SELECT `id`,`username`,`cash` FROM `TMQ_user` WHERE `id` = '$uid'")->fetch();
      if($data['id'] != null){
          if($description != null){
              $before = $data['cash'];
              $after = $data['cash']+$amount;
      $db->exec("UPDATE `TMQ_user` SET `cash` = `cash` + '$amount' WHERE `id` = '$uid'");
      TMQ_history(null,$data['username'],$description,$amount,$before,$after,'congtien');
      header("Location: /admin/user");
          }
      }
      isset($_POST['cancel']) ? header("Location: /admin/user") : null ;
  }  
echo '<div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Cộng tiền cho #'.TMQ_check($_POST['congtien']).'</h4>
                    <form class="forms-sample" method="POST">
                      <div class="form-group">
                        <label>Số tiền</label>
                        <input type="number" class="form-control" placeholder="Nhập số tiền" onkeyup="change();" id="amount" name="amount" />
                        </div>
                        <script>
                        function change(){
        var amount = document.getElementById("amount").value|0;
        var fee = '.$cash.';
         amount += fee;
    document.getElementById("plus").innerHTML = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"<sup>đ</sup>";
      }
      </script>
                       <div class="form-group">
                        <label>Số tiền sau cộng</label>
                        <p class="form-control" id="plus"></p>
                        </div> 
                         <div class="form-group">
                        <label>Nội dung cộng tiền</label>
                        <input type="text" class="form-control" placeholder="Nhập nội dung nếu cần" name="description" />
                        </div>
                        <input type="hidden" name="congtien" value="'.TMQ_check($_POST['congtien']).'" />
                      <button type="submit" name="cong" class="btn btn-primary mr-2">Cộng</button>
                      <button class="btn btn-dark" type="submit" name="cancel">Hủy</button>
                    </form>
                  </div>
                </div>
              </div>
';  
endif;
//khóa/mở khóa tài khoản
if(isset($_POST['status'])):
    $stt = $db->query("SELECT `ban` FROM `TMQ_user` WHERE `id` = '".(int)$_POST['status']."'")->fetch();
    $stt = $stt['ban'];
    if($stt == 0){
        $db->exec("UPDATE `TMQ_user` SET `ban` = '1' WHERE `id` = '".(int)$_POST['status']."'");
    }elseif($stt == 1){
        $db->exec("UPDATE `TMQ_user` SET `ban` = '0' WHERE `id` = '".(int)$_POST['status']."'");
    }
endif;
//phân quyền thành viên
if(isset($_POST['phanquyen'])):
    $id = (int)$_POST['phanquyen'];
    $get_admin = $db->query("SELECT `id`,`admin` FROM `TMQ_user` WHERE `id` = '$id'")->fetch();
    $get_admin = $get_admin['admin'];
    if(isset($_POST['submit'])){
        $chucvu = (int)$_POST['chucvu'];
        if($db->query("SELECT `id` FROM `TMQ_user` WHERE `id` = '$id'")->rowCount() != 0){
            $db->exec("UPDATE `TMQ_user` SET `admin` = '$chucvu' WHERE `id` = '$id'");
        }
    }
    isset($_POST['cancel']) ? header("Location: /admin/user") : null ;
    ?>
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Phân quyền cho #<?=$id;?></h4>
                    <form class="forms-sample" method="POST">
                      <div class="form-group">
                        <label>Chức vụ</label>
                        <select class="form-control" name="chucvu">
                            <option value="0" <?php if($get_admin == 0){ echo 'selected'; } ?>>Thành viên <?=$get_admin;?></option>
                            <option value="1" <?php if($get_admin == 1){ echo 'selected'; } ?>>Cộng tác viên</option>
                            <option value="9" <?php if($get_admin == 9){ echo 'selected'; } ?>>Quản trị viên</option>
                        </select>
                        </div>
                        <input type="hidden" name="phanquyen" value="<?=$id;?>" />
                      <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                      <button class="btn btn-dark" type="submit" name="cancel">Hủy</button>
                    </form>
                  </div>
                </div>
              </div>    
<?php endif; 
//gửi thông báo thành viên
if(isset($_POST['inbox'])):
    $id = (int)$_POST['inbox'];
    $data = $db->query("SELECT `id`,`username` FROM `TMQ_user` WHERE `id` = '$id'")->fetch();
    if(isset($_POST['submit'])){
        $noidung = TMQ_check($_POST['noidung']);
        if($data['id'] != null){
            if(!empty($noidung)){
           $db->exec("
            INSERT INTO `TMQ_inbox`
            (`username`,`text`,`from`,`date`)
            VALUES
            ('".$data['username']."','$noidung','".TMQ_user()['username']."','".date("H:i:s d-m-Y")."')
            ");
            $err = '<div class="alert alert-success"><strong>Success!</strong> Gửi inbox thành công.</div>';
            }else{
                $err = '<div class="alert alert-danger"><strong>Danger!</strong> Vui lòng nhập đủ thông tin.</div>';
            }
        }else{
            $err = '<div class="alert alert-danger"><strong>Danger!</strong> Người dùng không tồn tại.</div>';
        }
    }else{
        $err = '';
    }
    isset($_POST['cancel']) ? header("Location: /admin/user") : null ;
    ?>
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Gửi thông báo cho #<?=$id;?></h4>
                    <?=$err;?>
                    <form class="forms-sample" method="POST">
                      <div class="form-group">
                        <label>Nội dung</label>
                        <textarea rows="10" name="noidung" id="noidung" class="form-control"></textarea>
                        </div>
                        <input type="hidden" name="inbox" value="<?=$id;?>" />
                      <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                      <button class="btn btn-dark" type="submit" name="cancel">Hủy</button>
                    </form>
                  </div>
                </div>
              </div>    
<?php endif; 
//reset password
if(isset($_POST['reset_password'])):
    $id = (int)$_POST['reset_password'];
    $data = $db->query("SELECT `id`,`username` FROM `TMQ_user` WHERE `id` = '$id'")->fetch();
    if(isset($_POST['submit'])){
        $password = TMQ_check($_POST['password']);
        $password = TMQ_mahoa($password);
        $loai = (int)$_POST['loai'];
        
        switch($loai){
            case 1: $text = "password"; break;
            case 2: $text = "password_2"; break;
            default: $text = null; break;
        }
        if($data['id'] != null){
            if(!empty($password) || !empty($text)){
           $db->exec("UPDATE `TMQ_user` SET `$text` = ".$db->quote($password)." WHERE `id` = '$id'");
            $err = '<div class="alert alert-success"><strong>Success!</strong> Reset password thành công.</div>';
            }else{
                $err = '<div class="alert alert-danger"><strong>Danger!</strong> Vui lòng nhập đủ thông tin.</div>';
            }
        }else{
            $err = '<div class="alert alert-danger"><strong>Danger!</strong> Người dùng không tồn tại.</div>';
        }
    }else{
        $err = '';
    }
    isset($_POST['cancel']) ? header("Location: /admin/user") : null ;
    ?>
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Khôi phục mật khẩu #<?=$id;?></h4>
                    <?=$err;?>
                    <form class="forms-sample" method="POST">
                      <div class="form-group">
                        <label>Nhập mật khẩu</label>
                        <input type="text" name="password" class="form-control" />
                        </div>
                    <div class="form-group">
                        <label>Loại mật khẩu</label>
                        <select name="loai" class="form-control">
                            <option value="1">User</option>
                            <option value="2">Admin/CTV</option>
                        </select>
                        </div>    
                        <input type="hidden" name="reset_password" value="<?=$id;?>" />
                      <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                      <button class="btn btn-dark" type="submit" name="cancel">Hủy</button>
                    </form>
                  </div>
                </div>
              </div>    
<?php endif; ?>
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Danh sách - <a href="/user-excel" style="color:red;">Xuất Excel</a></h4>
                
                    <div class="table-responsive">
                      <table id="bootstrap-data-table" style="text-align:center;" class="table table-hover table-bordered table-contextual">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Thông tin người dùng</th>
                            <th>Chức vụ</th>
                            <th>Số dư</th>
                            <th>Trạng thái</th>
                            <th>Ngày tham gia</th>
                            <th>Thao tác</th>
                          </tr>
                        </thead>
                        <tbody>
<?php
$status = array(
    '0' => '<label class="badge badge-success">Hoạt động</label>',
    '1' => '<label class="badge badge-danger">Bị khóa</label>'
    );
$user = $db->query("SELECT * FROM `TMQ_user`");
foreach($user as $row){
?>
                          <tr>
                            <td><?=$row['id'];?></td>
                            <td>
                                <p>Họ tên: <?=$row['name'];?></p>
                                <p>Tài khoản: <?=$row['username'];?></p>
                                <p>Phone: <?=$row['phone'];?></p>
                                <p>Email: <?=$row['email'];?></p>
                            </td>
                            <td><?=TMQ_position($row['id']);?></td>
                            <td><?=number_format($row['cash']);?><sup>đ</sup></td>
                            <td><?=$status[$row['ban']];?></td>
                            <td><?=$row['date'];?></td>
                            <td class="dropdown">
                            <form method="POST"> 
                            <p><button type="submit" name="congtien" value="<?=$row['id'];?>" class="btn btn-outline-secondary btn-icon-text">
                            <i class="mdi mdi-cash btn-icon-append"></i> Cộng tiền </button></p>
                            <p><button type="submit" name="status" value="<?=$row['id'];?>" class="btn btn-outline-success btn-icon-text">
                            <i class="mdi mdi-reload btn-icon-prepend"></i> Trạng thái </button></p>
                            <p> <button type="submit" name="phanquyen" value="<?=$row['id'];?>" class="btn btn-outline-primary btn-icon-text">
                            <i class="mdi mdi-account-key btn-icon-prepend"></i> Phân quyền</button></p>
                            <p> <button type="submit" name="inbox" value="<?=$row['id'];?>" class="btn btn-outline-warning btn-icon-text">
                            <i class="mdi mdi-message-text-outline"></i> Gửi inbox</button></p>
                             <p> <button type="submit" name="reset_password" value="<?=$row['id'];?>" class="btn btn-outline-danger btn-icon-text">
                            <i class="mdi mdi-reload"></i> Reset password</button></p>
                            </form>
                            </td>
                          </tr>
<?php } ?>                         
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
<script> CKEDITOR.replace( 'noidung' );</script>
          <!-- content-wrapper ends -->
<?php
require('foot.php');
?>