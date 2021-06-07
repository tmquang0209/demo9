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
              <h3 class="page-title"> Quản lý đơn rút items</h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Quản lý đơn rút items</li>
                </ol>
              </nav>
            </div>
<?php
if(isset($_GET['id']) && isset($_GET['value']))
{
  require("assets/php/note.php");
}
?>
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
                            <th>Username</th>
                            <th>Text</th>
                            <th>Package</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                          </tr>
                        </thead>
                        <tbody>
<?php
$stt = array(
    "Thành công" => "<span class=\"btn btn-success btn-md\">Đã duyệt</span>",
    "Hủy" => "<span class=\"btn btn-danger btn-md\">Hủy</span>",
    "Chờ" => "<span class=\"btn btn-warning btn-md\">Chờ</span>"
    );
$his_gift = $db->query("SELECT * FROM `TMQ_history_ruby`");
foreach($his_gift as $row){
?>
                          <tr>
                            <td><?=$row['id'];?></td>
                            <td><?=$row['username'];?></td>
                            <td><?=$row['text'];?></td>
                            <td><?=number_format($row['cash']);?></td>
                            <td><?=$row['loai'];?></td>
                            <td><?=$stt[$row['status']];?></td>
                            <td><?=$row['date'];?></td>
                            <td class="dropdown">
                           <p><button onclick="window.location = '?id=<?=$row['id'];?>&value=0';" class="btn btn-outline-success btn-icon-text">Duyệt</button></p>
<p> <button onclick="window.location = '?id=<?=$row['id'];?>&value=1';" class="btn btn-outline-danger btn-icon-text">Hủy</button></p>
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