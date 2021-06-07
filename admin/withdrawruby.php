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
              <h3 class="page-title"> Quản lý dịch vụ</h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Quản lý dịch vụ</li>
                </ol>
              </nav>
            </div>
<?php
    if(isset($_GET['del'])){
        $id = (int)$_GET['del'];
        $db->exec("DELETE FROM `TMQ_withdrawruby_form` WHERE `id` = '$id'");
        header("Location: /admin/withdrawruby");
    }
    if(isset($_GET['add'])){
        if(isset($_POST['add']))
        {
           $name = TMQ_check($_POST['name']);
           $text = TMQ_check($_POST['value']);
           $loai = TMQ_check($_POST['loai']);
           
           switch ($loai){
               case 1 : $loai = 'auto'; break;
               case 2 : $loai = 'form'; break;
               default : $loai = null; break;
           }
           //Kiếm tra dữ liệu
           $data = $db->query("SELECT `id` FROM `TMQ_withdrawruby_form` WHERE `name` = '$name'")->fetch();

           if (empty($name) || empty($loai) || empty($text)) {
             echo '<div class="alert alert-danger"><strong>Danger!</strong> Vui lòng nhập đủ thông tin.</div>'; 
           }elseif($data['id'] != null){
            echo '<div class="alert alert-danger"><strong>Danger!</strong> Form đã tồn tại trên hệ thống.</div>'; 
           }else{
            $db->exec("INSERT INTO `TMQ_withdrawruby_form` SET
                  `username` = '".TMQ_user()['username']."',
                  `name` = ".$db->quote($name).",
                  `value` = ".$db->quote($text).",
                  `loai` = ".$db->quote($loai).",
                  `date` = '".date("d-m-Y")."' 
                  ");
            echo '<div class="alert alert-success"><strong>Success!</strong> Thêm thành công.</div>'; 
           }
        }
?>
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Thêm Form</h4>
                    <form class="forms-sample" method="POST">
                        <div class="form-group">
                        <label>Tên:</label>
                        <input type="text" class="form-control" name="name" value="">
                      </div>
                      <div class="form-group">
                        <label>Loại:</label>
                        <select name="loai" class="form-control">
                            <option value="">Chọn</option>
                            <option value="1">Tự động gửi quà</option>
                            <option value="2">Nhập form thủ công</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Nội dung (VD: Name|input or select|value1,value2,value3</label>
                       <textarea style="font-size: 20px;" class="form-control" name="value" cols="30" rows="10">Test input|input
Test select|select|90 Kim cương|100 Kim cương|200 Kim Cương</textarea>
                      </div>
                      
                      <button type="submit" name="add" class="btn btn-primary mr-2">Thêm</button>

                    </form>
                  </div>
                </div>
              </div>
            </div>
<?php }
if(isset($_GET['edit']))
{
  $id = (int)$_GET['edit'];
  $check = $db->query("SELECT * FROM `TMQ_withdrawruby_form` WHERE `id` = '$id'")->fetch();
  
  
  if(isset($_POST['sedit']))
  {
      
      $name = TMQ_check($_POST['name']);
      $text = TMQ_check($_POST['value']);
      $loai = TMQ_check($_POST['loai']);
           
           switch ($loai){
               case 1 : $loai = 'auto'; break;
               case 2 : $loai = 'form'; break;
               default : $loai = null; break;
           }
      if(empty($name) || empty($text) || empty($loai))
      {
        echo '<div class="alert alert-danger"><strong>Danger!</strong> Vui lòng nhập đủ thông tin.</div>';
      }
      elseif($check['id'] == null)
      {
        echo '<div class="alert alert-danger"><strong>Danger!</strong> Form không tồn tại.</div>';
      }
      else
      {
        $db->exec("UPDATE `TMQ_withdrawruby_form` SET 
                  `name` = ".$db->quote($name).",
                  `value` = ".$db->quote($text).",
                  `loai` = ".$db->quote($loai)."
         WHERE `id` = '$id'
        ");
        echo '<div class="alert alert-success"><strong>Success!</strong> Sửa thành công.</div>';
        header("Location: /admin/withdrawruby");
      }  
  }
?>
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Sửa form #<?=$id;?></h4>
                    <form class="forms-sample" method="POST">
                        <div class="form-group">
                        <label>Tên:</label>
                        <input type="text" class="form-control" name="name" value="<?=$check['name'];?>">
                      </div>
                      <div class="form-group">
                        <label>Loại:</label>
                        <select name="loai" class="form-control">
                            <option value="">Chọn</option>
                            <option value="1" <?php if($check['loai'] == 'auto') echo "selected"; ?>>Tự động gửi quà</option>
                            <option value="2" <?php if($check['loai'] == 'form') echo "selected"; ?>>Nhập form thủ công</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Nội dung (VD: Name|input or select|value1,value2,value3</label>
                       <textarea style="font-size: 20px;" class="form-control" name="value" cols="30" rows="10"><?=$check['value'];?></textarea>
                      </div>
                      
                      <button type="submit" name="sedit" class="btn btn-primary mr-2">Sửa #<?=$id;?></button>

                    </form>
                  </div>
                </div>
              </div>
            </div>
<?php              
} 
?>            
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Danh sách - <button type="button" onclick="window.location = '?add';" class="btn btn-inverse-success btn-fw">Thêm form rút VP</button></h4>
                
                    <div class="table-responsive">
                      <table id="bootstrap-data-table" style="text-align:center;" class="table table-hover table-bordered table-contextual">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Người tạo</th>
                            <th>Tên form</th>
                            <th>Loại</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                          </tr>
                        </thead>
                        <tbody>
<?php
$wd_form = $db->query("SELECT * FROM `TMQ_withdrawruby_form`");
foreach($wd_form as $row){
?>
                          <tr>
                            <td><?=$row['id'];?></td>
                            <td><?=$row['username'];?></td>
                            <td><?=$row['name'];?></td>
                            <td><?=$row['loai'];?></td>
                            <td><?=$row['date'];?></td>
                            <td class="dropdown">
                            <button onclick="window.location='?edit=<?=$row['id'];?>'" class="btn btn-outline-warning btn-icon-text">
                            <i class="mdi mdi-pencil btn-icon-prepend"></i> Sửa</button>
                            <button onclick="window.location='?del=<?=$row['id'];?>'" class="btn btn-outline-danger btn-icon-text">
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