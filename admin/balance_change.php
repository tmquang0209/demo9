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
              <h3 class="page-title"> Quản lý số dư </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Quản lý số dư</li>
                </ol>
              </nav>
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
                            <th>Username</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>First</th>
                            <th>Later</th>
                            <th>Type</th>
                            <th>Date</th>
                          </tr>
                        </thead>
                        <tbody>
<?php
$account = $db->query("SELECT * FROM `TMQ_history`");   
foreach($account as $row){
?>
                          <tr>
                            <td><?=$row['id'];?></td>
                            <td><?=$row['buyer'];?></td>
                            <td><?=$row['infomation'];?></td>
                            <td><?=$row['cash'];?></td>
                            <td><?=number_format($row['original']);?><sup>đ</sup></td>
                            <td><?=number_format($row['sodu']);?><sup>đ</sup></td>
                            <td><?=$row['loai'];?></td>
                            <td><?=date("H:i:s d-m-Y",$row['time']);?></td>
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