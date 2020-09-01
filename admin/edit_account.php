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

require ('../TMQ_sys/function.php');
require ('head.php');

if (TMQ_admin() != 9 && TMQ_admin() != 1)
{
    header('Location: /');
}

$id = (int)$_GET['id'];

//data
$data = $db->query("SELECT * FROM `TMQ_baiviet` WHERE `id` = '$id' AND `username` = '" . TMQ_user() ['username'] . "'")->fetch();

if ($data['id'] == null || $data['trangthai'] == 'off')
{
    header("Location: /admin/main");
}

$cm = $db->query("SELECT `name` FROM `TMQ_chuyenmuc` WHERE `id` = '" . $data['loai'] . "'")->fetch();

$fil = $db->query("SELECT `filter` FROM `TMQ_filter` WHERE `id_cm` = '" . $data['loai'] . "'");
$filter = $db->query("SELECT `filter` FROM `TMQ_filter` WHERE `id_cm` = '" . $data['loai'] . "'");


if(isset($_POST["submit"]))
{
     $taikhoan = TMQ_check($_POST['taikhoan']);
     $matkhau = TMQ_check($_POST['password']);
     $cash = (int)abs($_POST['cash']);
     $loai = $cm['name'];
     $thongtin = TMQ_check($_POST['thongtin']);
     $img = TMQ_check($_POST['image']);
    foreach($fil as $row)
    {
        $f_name = explode(PHP_EOL,$row['filter']);
        $name = TMQ_xoadau($f_name[0]);
        $name1 = $f_name[0];
        $result .= $name1.":".$_POST[$name]."\n";
        
        if(trim($_POST[$name]) == null){ $giatri = null; }else{ $giatri = $result; }
    
    }
    
    if(empty($taikhoan) || empty($matkhau) || empty($cash) || empty($giatri) || empty($thongtin))
    {
        $err = "Vui lòng nhập đủ thông tin";
    }
    elseif($data['username'] != TMQ_user()['username'])
    {
        $err = "Tài khoản này không phải của bạn";  
    }elseif($data['trangthai'] == 'off'){
        $err = "Nick này đã bán nên không thể sửa";
    }else{
        $err = "Sửa thành công";
        $db->exec("UPDATE `TMQ_baiviet` SET
        `taikhoan`= '$taikhoan',
        `matkhau` = '$matkhau',
        `cash` = '$cash',
        `thongtin` = '$thongtin',
        `search` = '$result',
        `img` = '$img'
        WHERE `id`= $id 
        ");
    }
}
?>


  <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Sửa tài khoản #<?=$id; ?></h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Sửa tài khoản #<?=$id; ?></li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Sửa tài khoản #<?=$id; ?></h4>
                    <p class="card-description"><?=$err;?></p>
                
                    <form class="forms-sample" method="POST">
                       <div class="row form-group">
                                <div class="col-3">
                                    <label class=" form-control-label">Tài khoản</label>
                                    <div class="input-group">
                        <input type="text" class="form-control" name="taikhoan" placeholder="Nhập tài khoản ..." value="<?=$data['taikhoan']; ?>">
                                    </div>
                                  </div>
                                <div class="col-3">
                        <label>Mật khẩu</label>
                        <input type="text" class="form-control" name="password" placeholder="Nhập mật khẩu" value="<?=$data['matkhau']; ?>">
                      </div>
                       <div class="col-3">
                        <label>Giá tiền</label>
                        <input type="number" class="form-control" name="cash" placeholder="Nhập giá tiền ..." value="<?=$data['cash']; ?>">
                      </div>
                
                      <style>
                          input[type=text]:disabled {
                             background: #2A3038;
                            }
                      </style>
                       <div class="col-3">
                        <label for="">Loại nick</label>
                       <input type="text" class="form-control" name="loai" value="<?=$cm['name']; ?>" disabled>
                      </div>
                      </div>
<?php
$dem = $db->query("SELECT `filter` FROM `TMQ_filter` WHERE `id_cm` = '" . $data['loai'] . "'")->rowCount();
$j = 1;
$dulieu = explode(PHP_EOL, $data['search']);
foreach ($filter as $key => $row)
{
    $j += 3;
    $search = explode(":", $dulieu[$key]);
    $filter = explode(PHP_EOL, $row['filter']);
    if ($j % 4 == 0)
    {
        if ($j != 4)
        {
            echo '</div>';
        }
        echo '<div class="row form-group">';
    }
    if ($filter[1] == 'select')
    {
       
        echo "<div class=\"col-3\">
                    <label>" . $filter[0] . "</label>
                        <select class=\"form-control\" name=\"" . TMQ_xoadau($filter[0]) . "\">\n";
        for ($i = 2;$i < count($filter);$i++)
        {
             if(trim($filter[$i]) == trim($search[1])){ $select = "selected"; }else{ $select = null; }
            echo "<option value=\"" . trim($filter[$i]) . "\" $select>" . $filter[$i] . "</option>\n";
        }
        echo "</select>
                    </div>";
    }
    if ($filter[1] == 'input')
    {
        if($filter[0] == $search[0]){ $value = $search[1]; }else{ $value = null; }
        echo "<div class=\"col-3\">
                        <label for=\"\">" . $filter[0] . "</label>
                       <input type=\"text\" class=\"form-control\" name=\"" . TMQ_xoadau($filter[0]) . "\" value=\"$value\" placeholder=\"Nhập " . $filter[0] . "...\">
               </div> ";
    }
    if ($key == $dem)
    {
        echo "</div>";
    }
}
?>      </div>
                <div class="form-group">
                        <label for="">Nổi bật</label>
                        <textarea class="form-control" name="thongtin" rows="4"><?=$data['thongtin']; ?></textarea>
                      </div>
                <div class="form-group">
                        <label for="">Hình ảnh</label>
                        <textarea class="form-control" name="image" rows="4"><?=$data['img']; ?></textarea>
                      </div>
               
                     
                      <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                    
                    </form>
                  </div>
                </div>
        </div>
            
                </div>
              </div>
             
          <!-- content-wrapper ends -->

<?php require_once ("foot.php"); ?>