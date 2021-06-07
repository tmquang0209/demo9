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
require ("../TMQ_sys/function.php");
require ("../TMQ_sys/head.php");
require ("menu.php");
?>
<div class="c-layout-sidebar-content ">

<div class="c-content-title-1">
<h3 class="c-font-uppercase c-font-bold">Tài khoản ngân hàng</h3>
<div class="c-line-left"></div>
</div>
<?php
//add bank
if(isset($_POST['add_bank'])){
  $bank_id = TMQ_check($_POST['bank_id']);
  $holder_name = TMQ_check($_POST['holder_name']);
  $account_number = (int)$_POST['account_number'];
  $brand = TMQ_check($_POST['brand']);
  $check = $db->query("SELECT `id` FROM `TMQ_bank` WHERE 
  `username` = '".TMQ_user()['username']."' 
  AND 
  `holder` = ".$db->quote($holder_name)." 
  AND 
  `bank` = ".$db->quote($bank_id)." 
  AND 
  `number` = ".$db->quote($account_number)." 
  AND 
  `branch` = ".$db->quote($brand)."
  AND `loai` = '0'")->fetch();
  if(empty($bank_id) || empty(($holder_name)) || empty($account_number) || empty($brand)){
    echo '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Vui lòng nhập đủ thông tin.</div>';
  }elseif($check['id'] != null){
    echo '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Tài khoản đã trùng.</div>';
  }else{
    echo '<div class="alert alert-success alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Thêm thành công.</div>';
    $db->exec("INSERT INTO `TMQ_bank`
    (`username`, `bank`, `holder`, `number`, `branch`, `loai`, `date`) 
    VALUES 
    ('".TMQ_user()['username']."',".$db->quote($bank_id).",".$db->quote($holder_name).",".$db->quote($account_number).",".$db->quote($brand).",0,'".date("H:i:s d-m-Y")."')
     ");
  }
}

//add ví
if(isset($_POST['add_vi'])){
  $bank_id = TMQ_check($_POST['bank_id']);
  $account_vi = (int)$_POST['account_vi'];
  $re_account_vi = (int)$_POST['account_vi_confirmation'];
  $check = $db->query("SELECT `id` FROM `TMQ_bank` 
  WHERE 
  `username` = '".TMQ_user()['username']."' 
  AND 
  `bank` = ".$db->quote($bank_id)." 
  AND 
  `number` = ".$db->quote($account_number)." 
  AND 
  `loai` = '1'")->fetch();
  if(empty($bank_id) || empty($account_vi) || empty($re_account_vi)){
    echo '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Vui lòng nhập đủ thông tin.</div>';
  }elseif($check['id'] != null){
    echo '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Tài khoản đã trùng.</div>';
  }elseif($account_vi != $re_account_vi){
    echo '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Thông tin không giống nhau.</div>';
  }else{
    echo '<div class="alert alert-success alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Thêm thành công.</div>';
    $db->exec("INSERT INTO `TMQ_bank`
    (`username`, `bank`, `number`, `loai`, `date`) 
    VALUES 
    ('".TMQ_user()['username']."',".$db->quote($bank_id).",".$db->quote($account_vi).",'1','".date("H:i:s d-m-Y")."')
     ");
  }
}

//xóa 
if(isset($_POST['del'])){
    $id = (int)$_POST['id'];
    $check = $db->query("SELECT `id` FROM `TMQ_bank` WHERE `username` = '".TMQ_user()['username']."' AND `id` = '$id'")->fetch();
    if($check['id'] != null){
    $db->exec("DELETE FROM `TMQ_bank` WHERE `id` = '$id'");
    }
}
?>
<button rel="/assets/ajax/bank" class="btn c-btn-blue c-btn-square ajax m-b-20 load-modal">Thêm tài khoản</button>
<table class="table table-hover table-custom-res">
<tbody>
<tr>
<th>#</th>
<th>Chủ tài khoản</th>
<th>Số tài khoản/Tài khoản ví</th>
<th>Ngân hàng/Ví</th>
<th>Thao tác</th>
</tr>
<?php
$data = $db->query("SELECT * FROM `TMQ_bank` WHERE `username` = '".TMQ_user()['username']."'");
foreach($data as $row)
{
?>
<tr>
<th><?=$row['id'];?></th>
<td><b class="tooltips"><?=$row['holder'];?></b></td>
<td><?=(int)$row['number'];?></td>
<td><?=$row['bank'];?></td>
<td><button type="button" class="btn btn-danger c-btn-square btn-xs delete_toggle" rel="<?=$row['id'];?>">Xóa</button></td>
</tr>
<?php
}
?>
</tbody>
</table>

</div>
</div>
</div>

<div class="modal fade" id="LoadModal" role="dialog" style="display: none;" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="loader" style="text-align: center"><img src="/assets/frontend/images/loader.gif" style="width: 50px;height: 50px;display: none"></div>
<div class="modal-content">
</div>
</div>
</div>

<div class="modal fade" id="deleteModal">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" action="/profile/bank" accept-charset="UTF-8" class="form-horizontal">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Xác nhận thao tác</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">
Bạn thực sự muốn xóa?
</div>
<div class="modal-footer">
<input type="hidden" name="id" class="id" value="" />
<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
<button type="submit" name="del" class="btn btn-danger m-btn m-btn--custom">Xóa</button>
</div>
</form>
</div>
</div>
</div>
<script>
        $(document).ready(function () {
            $('.load-modal').each(function (index, elem) {
                $(elem).unbind().click(function (e) {

                    e.preventDefault();
                    var curModal = $('#LoadModal');
                    curModal.find('.modal-content').html("<div class=\"loader\" style=\"text-align: center\"><img src=\"/assets/frontend/images/loader.gif\" style=\"width: 50px;height: 50px;\"></div>");
                    curModal.modal('show').find('.modal-content').load($(elem).attr('rel'));
                });
            });



            //delete button
            $('.delete_toggle').each(function (index, elem) {
                $(elem).click(function (e) {

                    e.preventDefault();
                    $('#deleteModal .id').attr('value', $(elem).attr('rel'));
                    $('#deleteModal').modal('toggle');
                });
            });
        });


    </script>
<?php
require("../TMQ_sys/foot.php");
?>