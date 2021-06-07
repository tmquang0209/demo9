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
if (TMQ_admin() != 9 && TMQ_admin() != 1) 
{
header('Location: /');
}
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$get = $db->query("SELECT `name`,`id`,`image` FROM `TMQ_chuyenmuc` WHERE `id` = '$id' AND `loai` = '1' AND `status` = 'on'")->fetch();
if($get['id'] == null){ $get['name'] = 'Không tồn tại'; }
?>
  <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Đăng tài khoản </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Forms</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Đăng tài khoản</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Đăng tài khoản</h4>
                    <p class="card-description"> Đăng tài khoản </p>
<?php
if(isset($_POST['submit'])){
     $taikhoan = TMQ_check($_POST['taikhoan']);
     $password = TMQ_check($_POST['password']);
     $cash = (int)abs($_POST['cash']);
     $infomation = TMQ_check($_POST['information']);
     $img = TMQ_check($_POST['image']);
     if(!$img){$img = $get['image'];}
     $check = $db->query("SELECT `id` FROM `TMQ_baiviet` WHERE `taikhoan` = '$taikhoan' AND `trangthai` = 'on'")->rowCount();
    if(empty($taikhoan) || empty($password) || empty($cash)){
        echo '<div class="alert alert-danger"><strong>Danger!</strong> Vui lòng nhập đủ thông tin.</div>';
    }elseif($check != 0){
        echo '<div class="alert alert-danger"><strong>Danger!</strong> Tài khoản đã tồn tại trên hệ thống.</div>';
    }else{
      //lấy dữ liệu filter
    $get_fil = $db->query("SELECT `filter` FROM `TMQ_filter` WHERE `id_cm` = '$id'");
    foreach ($get_fil as $fil) {
     $fil = explode(PHP_EOL,$fil['filter']);
    $data .= $fil[0].':'.$_POST[TMQ_xoadau($fil[0])]."\n";
    } 
     $db->exec("INSERT INTO `TMQ_baiviet` 
      (`username`, `taikhoan`, `matkhau`, `cash`, `loai`, `thongtin`, `trangthai`, `search`, `img`, `date`) 
      VALUES 
      ('".TMQ_user()['username']."',".$db->quote($taikhoan).",".$db->quote($password).",".$db->quote($cash).",".$db->quote($id).",".$db->quote($infomation).",'on',".$db->quote($data).",".$db->quote($img).",'".date('H:i:s d-m-Y')."')
        ");
        echo '<div class="alert alert-success"><strong>Success!</strong> Tài khoản đã được đăng thành công.</div>';
  }
}
?>
                    <form class="forms-sample" method="POST">
                       <div class="row form-group">
                                <div class="col-3">
                                    <label class=" form-control-label">Tài khoản</label>
                                    <div class="input-group">
                        <input type="text" class="form-control" name="taikhoan" placeholder="Nhập tài khoản ...">
                                    </div>
                                  </div>
                                <div class="col-3">
                        <label>Mật khẩu</label>
                        <input type="text" class="form-control" name="password" placeholder="Nhập mật khẩu">
                      </div>
                       <div class="col-3">
                        <label>Giá tiền</label>
                        <input type="number" class="form-control" name="cash" placeholder="Nhập giá tiền ...">
                      </div>
                      <style>
                          input[type=text]:disabled {
                             background: #2A3038;
                            }
                      </style>
                       <div class="col-3">
                        <label for="">Loại nick</label>
                       <input type="text" class="form-control" name="loai" value="<?=$get['name'];?>" disabled>
                      </div>
                      </div>
 <?php 
$get_filter = $db->query("SELECT `filter` FROM `TMQ_filter` WHERE `id_cm` = '$id'");
$dem =$db->query("SELECT `filter` FROM `TMQ_filter` WHERE `id_cm` = '$id'")->rowCount();
//for($j = 0;$j < $dem;$j++){ if($j % 4 == 0){echo '<div class="row form-group">';} }
$j = 1; $e = 0;
 foreach($get_filter as $row){
     $j+=3; $e++;
     $filter = explode(PHP_EOL,$row['filter']);
     if($j % 4 == 0){ 
         if($j != 4){ echo '</div>'; } 
         echo'<div class="row form-group">';
     }
 if($filter[1] == 'select'){ ?>
      <div class="col-3">
                    <label><?=$filter[0];?></label>
                        <select class="form-control" name="<?=TMQ_xoadau($filter[0]);?>">
                          <?php for($i = 2; $i < count($filter);$i++){ ?>
                          <option value="<?=$filter[$i];?>"><?=$filter[$i];?></option>
                          <?php } ?>
                        </select>
                    </div>   
     <?php  } 
     if($filter[1] == 'input'){ ?>
      <div class="col-3">
                        <label for=""><?=$filter[0];?></label>
                       <input type="text" class="form-control" name="<?=TMQ_xoadau($filter[0]);?>" placeholder="Nhập <?=$filter[0];?>...">
               </div> 
<?php } 
if($e == $dem){ echo "</div>"; } 
 }
?>
                <div class="form-group">
                        <label for="">Nổi bật</label>
                        <textarea class="form-control" name="information" rows="4"></textarea>
                      </div>
                <div class="form-group">
                        <label for="">Hình ảnh</label>
                        <textarea class="form-control" name="image" rows="4"></textarea>
                      </div>
               
                     
                      <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                    
                    </form>
                  </div>
                </div>
        </div>
            
                </div>
              </div>
             
          <!-- content-wrapper ends -->
<?php
require('foot.php');
?>
