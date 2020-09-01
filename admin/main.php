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
if (TMQ_admin() == 9 || TMQ_admin() == 1) 
{
    //tổng số tài khoản
    $total_acc = $db->query("SELECT `id` FROM `TMQ_baiviet`")->rowCount();
    $total_acc = number_format($total_acc);
    //đã bán
    $daban = $db->query("SELECT `id` FROM `TMQ_baiviet` WHERE `trangthai` = 'off'")->rowCount();
    $daban = number_format($daban);
    //doanh thu
    $doanhthu = $db->query("SELECT SUM(cash) FROM `TMQ_baiviet` WHERE `trangthai` = 'off'")->fetchColumn();
    $doanhthu = number_format($doanhthu);
    //doanh thu bán nick hoonm nay
    $time = "`date` LIKE '%".date("d-m-Y")."%'";
    $today = $db->query("SELECT SUM(cash) FROM `TMQ_baiviet` WHERE `trangthai` = 'off' AND $time")->fetchColumn();
    $today = number_format($today);
    //số tài khoản đăng hôm nay
    $last_time = date("d-m-Y",mktime(0,0,0,date("m")  , date("d")-1, date("Y")));
    $upacc_last = $db->query("SELECT `id` FROM `TMQ_baiviet` WHERE `date` LIKE '%$last_time%'")->rowCount();
    $upacc_today = $db->query("SELECT `id` FROM `TMQ_baiviet` WHERE $time")->rowCount();
    $upacc_today = number_format($upacc_today);
    $per_upacc_today = $upacc_today-$upacc_last;
    if($per_upacc_today > 0){
       $per_upacc_today = "+".$upacc_today-$upacc_last; 
       $status = 'success';
    }else{
        $status = 'danger';
    }

?>
 <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card corona-gradient-card">
                  <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                      <div class="col-4 col-sm-3 col-xl-2">
                        <img src="assets/images/dashboard/Group126@2x.png" class="gradient-corona-img img-fluid" alt="">
                      </div>
                      <div class="col-5 col-sm-7 col-xl-8 p-0">
                        <h4 class="mb-1 mb-sm-0">Developed by TMQ</h4>
                        <p class="mb-0 font-weight-normal d-none d-sm-block">Dịch vụ website giá rẻ!</p>
                      </div>
                      <div class="col-3 col-sm-2 col-xl-2 pl-0 text-center">
                        <span>
                          <a href="https://www.facebook.com/tmq.dz.pro" target="_blank" class="btn btn-outline-light btn-rounded get-started-btn">Liên hệ ngay</a>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?=$total_acc;?><sup>Acc</sup></h3>
                         
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Tổng số tài khoản</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?=$doanhthu;?><sup>đ</sup></h3>
                          <p class="text-success ml-2 mb-0 font-weight-medium">+11%</p>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Tổng số doanh thu bán nick</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?=$daban;?></h3>
                        
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-danger">
                          <span class="mdi mdi-arrow-bottom-left icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Tài khoản đã bán</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?=$today;?></h3>
                          
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Doanh thu bán nick hôm nay</h6>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
                 <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?=$upacc_today;?><sup>Acc</sup></h3>
                          <p class="text-<?=$status;?> ml-2 mb-0 font-weight-medium"><?=$per_upacc_today;?>%</p>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Số acc đăng hôm nay</h6>
                  </div>
                </div>
              </div>
            </div>
            <!----row 2---> 
            
            
            
<?php
$name_cate = $db->query("SELECT `name`,`id` FROM `TMQ_chuyenmuc` WHERE `loai` = '1'");
foreach($name_cate as $key => $row){
$tongso_account = $db->query("SELECT `id` FROM `TMQ_baiviet` WHERE `loai` = '".$row['id']."'")->rowCount();
$daban_account = $db->query("SELECT `id` FROM `TMQ_baiviet` WHERE `loai` = '".$row['id']."' AND `trangthai` = 'off'")->rowCount();
$doanhthu_account = $db->query("SELECT SUM(cash) FROM `TMQ_baiviet` WHERE `loai` = '".$row['id']."' AND `trangthai` = 'off' LIMIT 1")->fetchColumn();
$doanhthu_account = isset($doanhthu_account) ? number_format($doanhthu_account) : 0;
$my_account = $db->query("SELECT `id` FROM `TMQ_baiviet` WHERE `loai` = '".$row['id']."' AND `username` = '".TMQ_user()['username']."'")->rowCount();
?>
            <p><?=$row['name'];?></p>
                      <div class="row">
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?=$tongso_account;?><sup>Acc</sup></h3>
                         
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Tổng số tài khoản</h6>
                  </div>
                </div>
              </div>
              
              
              
               <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?=$daban_account;?><sup>Acc</sup></h3>
                         
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Đã bán</h6>
                  </div>
                </div>
              </div>


             <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?=$doanhthu_account;?><sup>đ</sup></h3>
                         
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Doanh thu</h6>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?=$my_account;?><sup>Acc</sup></h3>
                         
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Đã đăng</h6>
                  </div>
                </div>
              </div>


            </div>
            <?php } ?>  
          </div>
          
          
          
          <!-- content-wrapper ends -->
        
<?php
}
require_once("foot.php");