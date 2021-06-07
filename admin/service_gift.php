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
              <h3 class="page-title"> Quản lý quà tặng</h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Quản lý quà tặng</li>
                </ol>
              </nav>
            </div>
<?php
    if(isset($_GET['del'])){
        $id = (int)$_GET['del'];
        $db->exec("DELETE FROM `TMQ_service_gift` WHERE `id` = '$id'");
        header("Location: /admin/service_gift");
    }
    if(isset($_GET['add'])){
        if(isset($_POST['add']))
        {
            
            
            $loai = TMQ_check($_POST['loai']);
            $text = TMQ_check($_POST['text']);
            
            $check = $db->query("SELECT `id` FROM `TMQ_withdrawruby_form` WHERE `name` LIKE '%$loai%' LIMIT 1")->fetch();
            $check = $check['id'];
            
            if(empty($loai) || empty($text))
            {
                 echo '<div class="alert alert-danger"><strong>Danger!</strong> Vui lòng nhập đủ thông tin.</div>'; 
            }
            elseif($check === null)
            {
                 echo '<div class="alert alert-danger"><strong>Danger!</strong> Loại không tồn tại.</div>'; 
            }
            else
            {
                $text = explode(PHP_EOL,$text);
               
               foreach($text as $key => $res)
               {
                  $db->exec("INSERT INTO `TMQ_service_gift` 
                  (`username`,`text`,`loai`,`date`)
                  VALUES
                  ('".TMQ_user()['username']."',".$db->quote($text[$key]).",".$db->quote($loai).",'".date("H:i:s d-m-Y")."')
                  ");
               }
                 echo '<div class="alert alert-success"><strong>Success!</strong> Thêm thành công.</div>'; 
            }
        }
?>
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Thêm VP</h4>
                    <form class="forms-sample" method="POST">
                      <div class="form-group">
                        <label>Loại:</label>
                        <select name="loai" class="form-control">
                            <option value="">Chọn</option>
                            <?php
                            $get = $db->query("SELECT * FROM `TMQ_withdrawruby_form` WHERE `loai` = 'auto'");
                            foreach($get as $rs)
                            {
                                echo "<option value=\"".TMQ_xoadau($rs['name'])."\">".$rs['name']."</option>";
                            }
                            ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Danh sách quà: (Mỗi value cách nhau bởi dấu |, Mỗi VP 1 dòng)</label>
                       <textarea style="font-size: 20px;" class="form-control" name="text" cols="30" rows="10"></textarea>
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
  $check = $db->query("SELECT * FROM `TMQ_service_gift` WHERE `id` = '$id'")->fetch();
  if(isset($_POST['sedit']))
  {
      
     $loai = TMQ_check($_POST['loai']);
     $text = TMQ_check($_POST['text']);
     
      if(empty($loai) || empty($loai))
      {
        echo '<div class="alert alert-danger"><strong>Danger!</strong> Vui lòng nhập đủ thông tin.</div>';
      }
      elseif($check['id'] == null)
      {
        echo '<div class="alert alert-danger"><strong>Danger!</strong> VP không tồn tại.</div>';
      }
      else
      {
        $db->exec("UPDATE `TMQ_service_gift` SET 
          `username` = '".TMQ_user()['username']."',
         `text` = ".$db->quote($text).",
         `loai` = ".$db->quote($loai)."
         WHERE `id` = '$id'
        ");
        echo '<div class="alert alert-success"><strong>Success!</strong> Sửa thành công.</div>';
        header("Location: /admin/service_gift");
      }  
  }
?>
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Sửa dịch vụ #<?=$id;?></h4>
                    <form class="forms-sample" method="POST">
                      
                      <div class="form-group">
                        <label>Loại</label>
                        <select name="loai" class="form-control">
                         <?php
                            $get = $db->query("SELECT * FROM `TMQ_withdrawruby_form` WHERE `loai` = 'auto'");
                            foreach($get as $rs)
                            {
                                if(TMQ_xoadau($rs['name']) == $check['loai']) $select = "selected"; else $select = null;
                                echo "<option value=\"".TMQ_xoadau($rs['name'])."\" $select>".$rs['name']."</option>";
                            }
                            ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Thông tin VP</label>
                       <textarea style="color: white; font-size: 20px;" class="form-control" name="text" cols="30" rows="1"><?=$check['text'];?></textarea>
                      
                      </div>
                      
                      <button type="submit" name="sedit" class="btn btn-primary mr-2">Sửa</button>

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
                    <h4 class="card-title">Danh sách - <button type="button" onclick="window.location = '?add';" class="btn btn-inverse-success btn-fw">Thêm quà tặng</button></h4>
                
                    <div class="table-responsive">
                      <table id="bootstrap-data-table" style="text-align:center;" class="table table-hover table-bordered table-contextual">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Người tạo</th>
                            <th>Thông tin</th>
                            <th>Loại</th>
                            <th>Thời gian</th>
                            <th>Thao tác</th>
                          </tr>
                        </thead>
                        <tbody>
<?php
$gift = $db->query("SELECT * FROM `TMQ_service_gift`");
foreach($gift as $row){
?>
                          <tr>
                            <td><?=$row['id'];?></td>
                            <td><?=$row['username'];?></td>
                            <td><?=$row['text'];?></td>
                            <td><?=$row['loai'];?></td>
                            <td><?=$row['date'];?></td>
                            <td class="dropdown">
                            <button onclick="window.location='?edit=<?=$row['id'];?>'" class="btn btn-outline-warning btn-icon-text">
                            <i class="mdi mdi-pencil btn-icon-prepend"></i> Sửa</button> <br /> <br />
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