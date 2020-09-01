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
if (TMQ_admin() != 9) 
{
header('Location: /');
}
?>
 <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Quản lý coupon </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Quản lý coupon</li>
                </ol>
              </nav>
            </div>
<?php
    if(isset($_GET['del'])){
        $id = (int)$_GET['del'];
        $db->exec("DELETE FROM `TMQ_coupon` WHERE `id` = '$id'");
        header("Location: /admin/coupon");
    }
    if(isset($_POST['add'])){
      $code = TMQ_check($_POST['code']);
      $amount = (int)abs($_POST['amount']);
      $solan = (int)abs($_POST['solan']);
      $soluong = isset($_POST['soluong']) ? (int)abs($_POST['soluong']) : 1;
      //check
      $check = $db->query("SELECT `id`  FROM `TMQ_coupon` WHERE `code` = '$code'")->fetch();
      $limit = $db->query("SELECT `id` FROM `TMQ_coupon`")->rowCount();
      
      
      if(empty($amount) || empty($solan)){
          echo '<div class="alert alert-danger"><strong>Danger!</strong> Vui lòng nhập đủ thông tin.</div>'; 
      }elseif($solan == 0){
           echo '<div class="alert alert-danger"><strong>Danger!</strong> Số lần phải lớn hơn 0</div>';
      }elseif($check['id'] != null){
            echo '<div class="alert alert-danger"><strong>Danger!</strong> Mã đã tồn tại.</div>';
      }elseif($limit >= 2000){
           echo '<div class="alert alert-danger"><strong>Danger!</strong> Đã đạt giới hạn mã mất rồi.</div>';
      }elseif($amount == 0){
            echo '<div class="alert alert-danger"><strong>Danger!</strong> Số tiền không hợp lệ.</div>';
      }elseif(strlen($code) != 6 && !empty($code)){
            echo '<div class="alert alert-danger"><strong>Danger!</strong> Độ dài mã là 6 ký tự.</div>';
      }else{
            echo '<div class="alert alert-success"><strong>Success!</strong> Thêm thành công.</div>';
            if(empty($code)){
            for($i = 0;$i < $soluong;$i++){
                $code = strtoupper(TMQ_random(6));
                $db->exec("INSERT INTO `TMQ_coupon`
                (`username`, `code`, `amount`, `solan`, `date`)
                VALUES 
                ('".TMQ_user()['username']."',".$db->quote($code).",".$db->quote($amount).",".$db->quote($solan).",'".date("H:i:s d-m-Y")."');
                ");
            }
            }else{
                 $db->exec("INSERT INTO `TMQ_coupon`
                (`username`, `code`, `amount`, `solan`, `date`)
                VALUES 
                ('".TMQ_user()['username']."',".$db->quote($code).",".$db->quote($amount).",".$db->quote($solan).",'".date("H:i:s d-m-Y")."');
                ");
            }
      }
    }
     
?>
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Thêm coupon</h4>
                    <form class="forms-sample" method="POST">
                        <div class="form-group">
                        <label>Mã coupon</label>
                        <input type="text" class="form-control" placeholder="Bỏ trống để tạo random" name="code">
                      </div>
                      <div class="form-group">
                        <label>Số tiền</label>
                        <input type="number" class="form-control" placeholder="Nhập số tiền" name="amount">
                      </div>
                      <div class="form-group">
                        <label>Số lượng mã</label>
                        <input type="number" class="form-control" placeholder="Nhập số lượng" name="soluong">
                      </div>
                      <div class="form-group">
                        <label>Số lần dùng</label>
                        <input type="number" class="form-control" placeholder="Nhập số lần dùng" name="solan">
                      </div>
                      
                      <button type="submit" name="add" class="btn btn-primary mr-2">Thêm</button>

                    </form>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Danh sách</h4>
                
                    <div class="table-responsive">
                      <table id="bootstrap-data-table" style="text-align:center;" class="table table-hover table-bordered table-contextual">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Người tạo</th>
                            <th>Tên mã</th>
                            <th>Số tiền</th>
                            <th>Số lần dùng</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                          </tr>
                        </thead>
                        <tbody>
<?php
$coupon = $db->query("SELECT * FROM `TMQ_coupon`");
foreach($coupon as $row){
?>
                          <tr>
                            <td><?=$row['id'];?></td>
                            <td><?=$row['username'];?></td>
                            <td><?=$row['code'];?></td>
                            <td><?=number_format($row['amount']);?><sup>đ</sup></td>
                            <td><?=number_format($row['solan']);?></td>
                            <td><?=$row['date'];?></td>
                            <td class="dropdown"><button onclick="window.location='?del=<?=$row['id'];?>'" class="btn btn-outline-danger btn-icon-text">
                            <i class="mdi mdi-delete btn-icon-prepend"></i> Xóa</button>
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

          <!-- content-wrapper ends -->
<?php
require('foot.php');
?>