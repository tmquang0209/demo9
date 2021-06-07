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

if(isset($_POST['add'])){
  $name = TMQ_check($_POST['name']);
  $image = TMQ_check($_POST['image']);
  $img_thumb = TMQ_check($_POST['img_thumb']);
  $amount = (int)abs($_POST['amount']);
  $loai = TMQ_check($_POST['loai']);
  $dulieu = "";
for ($i = 1;$i <= 8;$i++)
{

    if (empty($_POST['tyle_'.$i]) || empty($_POST['name_wheel_'.$i]))
    {
        $dulieu = 'null';
    }
    else
    {
        $dulieu .= $_POST['tyle_'.$i].'|'.$i.'|'.$_POST['name_wheel_'.$i].'|'.$_POST['form_name_'.$i]."\n";
       
    }
}      
     
      if(empty($name) || empty($img_thumb) || empty($image) || empty($amount) || empty($loai) || empty($dulieu))
      {
       echo '<div class="alert alert-danger"><strong>Danger!</strong> Vui lòng nhập đủ thông tin.</div>'; 
      }
      else
      {
        $db->exec("INSERT INTO `TMQ_service` (`username`,`name`,`image_thumb`,`image`,`cash`,`loai`,`value`,`status`,`date`) VALUES ('".TMQ_user()['username']."','$name','$img_thumb','$image','$amount','$loai','$dulieu','on','".date("d-m-Y")."')");
        echo '<div class="alert alert-success"><strong>Success!</strong> Thêm thành công.</div>';
         header("Location: /admin/service");
      }  

    }
?>
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Thêm dịch vụ</h4>
                    <form class="forms-sample" method="POST">
                        <div class="row form-group">
                            <div class="col-4">
                        <label>Tên dịch vụ</label>
                        <input type="text" class="form-control" placeholder="Nhập tên dịch vụ" name="name" value="<?php if(!empty($_POST['name'])){ echo $_POST["name"];}?>">
                      </div>
                      <div class="col-4">
                        <label>Ảnh đại diện</label>
                        <input type="text" class="form-control" placeholder="Xuất hiện ở trang chủ" name="img_thumb" value="<?php if(!empty($_POST['img_thumb'])){ echo $_POST["img_thumb"];}?>">
                      </div>
                      <div class="col-4">
                        <label>Ảnh vòng quay</label>
                        <input type="text" class="form-control" placeholder="Url ảnh vòng quay" name="image" value="<?php if(!empty($_POST['image'])){ echo $_POST["image"];}?>">
                      </div></div>
                      <div class="row form-group">
                          <div class="col-6">
                        <label>Giá tiền</label>
                        <input type="number" class="form-control" placeholder="Nhập số tiền" name="amount" value="<?php if(!empty($_POST['amount'])){ echo $_POST["amount"];}?>">
                      </div>
                      <div class="col-6">
                        <label>Loại</label>
                        <select name="loai" class="form-control">
                          <option value="vongquay">Vòng quay</option>
                        </select>
                      </div></div>
<?php
for($i = 1 ; $i <= 8 ;$i++){
?>
<div class="row form-group">
<div class="col-4">
<label class=" form-control-label">Tỷ lệ <?=$i;?></label>
<div class="input-group">
<input type="number" class="form-control" name="tyle_<?=$i;?>" placeholder="Nhập tỷ lệ <?=$i;?>..." value="<?php if(!empty($_POST['tyle_'.$i])){ echo $_POST["tyle_".$i];}?>">
</div>
</div>

<div class="col-4">
<label>Tên giải thưởng <?=$i;?></label>
<input type="text" class="form-control" name="name_wheel_<?=$i;?>" placeholder="Nhập tên giải thưởng <?=$i;?>" value="<?php if(!empty($_POST['name_wheel_'.$i])){ echo $_POST["name_wheel_".$i];}?>">
</div>
<div class="col-4">
<label for="">Form rút VP</label>
<select class="form-control" name="form_name_<?=$i;?>">
<?php
$get_form = $db->query("SELECT `id`,`name` FROM `TMQ_withdrawruby_form`");
foreach($get_form as $get){
    echo "<option value=\"".TMQ_xoadau($get['name'])."\">".$get['name']."</option> ";
}
?>
</select>
</div>
</div>
<?php } ?>
<p><small>Ô chúc bạn may mắn đặt ở cuối, từ ô thứ 2 sẽ nhập từ trên xuống</small></p>

                      <button type="submit" name="add" class="btn btn-primary mr-2">Thêm</button>

                    </form>
                  </div>
                </div>
              </div>
            </div>