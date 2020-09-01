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
        $db->exec("DELETE FROM `TMQ_service` WHERE `id` = '$id'");
        header("Location: /admin/coupon");
    }
    if(isset($_GET['add'])){
        require("assets/php/add_service.php");
    }
    if(isset($_GET['edit']))
    {
        require("assets/php/edit_service.php");
    }
    if(isset($_GET['status']))
    {
        $id = (int)$_GET['status'];
        $check = $db->query("SELECT `status` FROM `TMQ_service` WHERE `id` = '$id'")->fetch();
        if($check['status'] == 'off'){
        $db->exec("UPDATE `TMQ_service` SET `status` = 'on' WHERE `id` = '$id'");
        }else{
        $db->exec("UPDATE `TMQ_service` SET `status` = 'off' WHERE `id` = '$id'");    
        }
        header("Location: /admin/service");
    }
?>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Danh sách - <button type="button" onclick="window.location = '?add';" class="btn btn-inverse-success btn-fw">Thêm dịch vụ</button> - <button type="button" onclick="window.location = '/admin/withdrawruby?add';" class="btn btn-inverse-success btn-fw">Thêm form rút VP</button></h4>
                
                    <div class="table-responsive">
                      <table id="bootstrap-data-table" style="text-align:center;" class="table table-hover table-bordered table-contextual">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Người tạo</th>
                            <th>Tên dịch vụ</th>
                            <th>Giá tiền</th>
                            <th>Loại</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                          </tr>
                        </thead>
                        <tbody>
<?php
$stt = array(
    "on" => "<span class=\"btn btn-success btn-md\">Hoạt động</span>",
    "off" => "<span class=\"btn btn-danger btn-md\">Bảo trì</span>",
    );
$service = $db->query("SELECT * FROM `TMQ_service`");
foreach($service as $row){
?>
                          <tr>
                            <td><?=$row['id'];?></td>
                            <td><?=$row['username'];?></td>
                            <td><?=$row['name'];?></td>
                            <td><?=number_format($row['cash']);?><sup>đ</sup></td>
                            <td><?=$row['loai'];?></td>
                            <td><?=$stt[$row['status']];?></td>
                            <td><?=$row['date'];?></td>
                            <td class="dropdown">
                           <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuIconButton6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-pencil"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton6">
                            <h6 class="dropdown-header">Thao tác</h6>
                            <a class="dropdown-item" href="?edit=<?=$row['id'];?>">Sửa</a>
                            <a class="dropdown-item" href="?del=<?=$row['id'];?>">Xóa</a>
                            <a class="dropdown-item" href="?status=<?=$row['id'];?>">Trạng thái</a>
                            </div>
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