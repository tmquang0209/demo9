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

$id = (int)$_GET['id'];
$value = (int)$_GET['value'];

switch($value)
 {
     case 0 : $value = 'success'; $status = "Thành công"; break;
     case 1 : $value = 'cancel'; $status = "Hủy"; break;
     default: $value = null; $status = null; break;
 }
 $res = $db->query("select `id` from `TMQ_history_ruby` where `id` = '$id' and `status` = 'Chờ'limit 1")->fetch();
 if(!$res['id']) header("Location: /admin/service_history"); 

if(isset($_POST['submit'])){
 $note = TMQ_check($_POST['note']);
 
 if(empty($value) || empty($stauts) || empty($note))
 {
      echo '<div class="alert alert-danger"><strong>Danger!</strong> Vui lòng nhập đủ thông tin.</div>';
 }
 else
 {
     $db->exec("update `TMQ_history_ruby` set `status` = '$status' where `id` = '$id'");
 }
 
    }
?>
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Đơn rút item #<?=$id;?></h4>
                    <form class="forms-sample" method="POST">
                        <div class="row form-group">
                           
                        <label>Ghi chú đơn hàng</label>
                        <input type="text" class="form-control" placeholder="Nhập ghi chú đơn hàng" name="note" value="<?php echo $id; ?>">
                     
                      </div>
            

                      <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>

                    </form>
                  </div>
                </div>
              </div>
            </div>