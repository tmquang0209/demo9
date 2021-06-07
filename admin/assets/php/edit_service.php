<?php 
$id = (int)$_GET['edit'];
$check = $db->query("SELECT * FROM `TMQ_service` WHERE `id` = '$id'")->fetch();
$value = explode(PHP_EOL,$check['value']);
  if(isset($_POST['sedit']))
  {
      
      $name = TMQ_check($_POST['name']);
      $image = TMQ_check($_POST['image']);
      $img_thumb = TMQ_check($_POST['img_thumb']);
      $loai = TMQ_check($_POST['loai']);
      $amount = (int)abs($_POST['amount']);
      
for ($i = 1;$i <= 8;$i++)
{

    if (empty($_POST['tyle_' . $i]) || empty($_POST['name_wheel_' . $i]))
    {
        $dulieu = null;
    }
    else
    {
        $data[$i] = $_POST['tyle_' . $i] . '|' . $i . '|' . $_POST['name_wheel_' . $i] . '|' . $_POST['form_name_' . $i];
        if ($i < 8)
        {
            $dulieu .= $data[$i] . "\n";
        }
        else
        {
            $dulieu .= $data[$i];
        }
    }
}
      echo $dulieu;
      if(empty($name) || empty($img_thumb) || empty($image) || empty($amount) || empty($loai) || empty($dulieu))
      {
        echo '<div class="alert alert-danger"><strong>Danger!</strong> Vui lòng nhập đủ thông tin.</div>';
      }
      elseif($check['id'] == null)
      {
        echo '<div class="alert alert-danger"><strong>Danger!</strong> Vòng quay không tồn tại.</div>';
      }
      else
      {
        $db->exec("UPDATE `TMQ_service` SET 
          `username` = '".TMQ_user()['username']."',
          `name` = ".$db->quote($name).",
          `image_thumb` = ".$db->quote($img_thumb).",
          `image` = ".$db->quote($image).",
          `cash` = ".$db->quote($amount).",
          `loai` = ".$db->quote($loai).",
          `value` = ".$db->quote($dulieu).",
          `date` = '".date("d-m-Y")."'
         WHERE `id` = '$id'
        ");
        echo '<div class="alert alert-success"><strong>Success!</strong> Sửa thành công.</div>';
        header("Location: /admin/service");
      }  
  }
?>
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Sửa dịch vụ #<?=$id;?></h4>
                    <form class="forms-sample" method="POST">
                        <div class="row form-group">
                            <div class="col-4">
                        <label>Tên dịch vụ</label>
                        <input type="text" class="form-control" placeholder="Nhập tên dịch vụ" name="name" value="<?=$check['name'];?>">
                      </div>
                      <div class="col-4">
                        <label>Ảnh đại diện</label>
                        <input type="text" class="form-control" placeholder="Xuất hiện ở trang chủ" name="img_thumb" value="<?=$check['image_thumb'];?>">
                      </div>
                      <div class="col-4">
                        <label>Ảnh vòng quay</label>
                        <input type="text" class="form-control" placeholder="Url ảnh vòng quay" name="image" value="<?=$check['image'];?>">
                      </div></div>
                      <div class="row form-group">
                          <div class="col-6">
                        <label>Giá tiền</label>
                        <input type="number" class="form-control" placeholder="Nhập số tiền" name="amount" value="<?=$check['cash'];?>">
                      </div>
                      <div class="col-6">
                        <label>Loại</label>
                        <select name="loai" class="form-control">
                          <option value="vongquay">Vòng quay</option>
                        </select>
                      </div></div>
                    <?php
for($i = 1 ; $i <= 8 ;$i++){
$value[$i-1] = explode("|",$value[$i-1]);

?>
<div class="row form-group">
<div class="col-4">
<label class=" form-control-label">Tỷ lệ <?=$i;?></label>
<div class="input-group">
<input type="number" class="form-control" name="tyle_<?=$i;?>" placeholder="Nhập tỷ lệ <?=$i;?>..." value="<?=$value[$i-1][0];?>">
</div>
</div>

<div class="col-4">
<label>Tên giải thưởng <?=$i;?></label>
<input type="text" class="form-control" name="name_wheel_<?=$i;?>" placeholder="Nhập tên giải thưởng <?=$i;?>" value="<?=$value[$i-1][2];?>">
</div>
<div class="col-4">
<label for="">Form rút VP</label>
<select class="form-control" name="form_name_<?=$i;?>">
<?php
$get_form = $db->query("SELECT `id`,`name` FROM `TMQ_withdrawruby_form`");
foreach($get_form as $get){ ?>
    <option value="<?=TMQ_xoadau($get['name']);?>" <?php if(TMQ_xoadau($get['name']) == $value[$i-1][3])echo "selected";?>><?=$get['name'];?></option> 
<?php } ?>
</select>
</div>
</div>
<?php } ?>
<p><small>Ô chúc bạn may mắn đặt ở cuối, từ ô thứ 2 sẽ nhập từ trên xuống</small></p>

                      <button type="submit" name="sedit" class="btn btn-primary mr-2">Sửa</button>

                    </form>
                  </div>
                </div>
              </div>
            </div>