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


//xóa lệnh

if(isset($_POST['del']))
{
    $id = (int)$_POST['id'];
    $data = $db->query("SELECT `username`,`id`,`text`,`cash`,`loai`,`status` FROM `TMQ_history_ruby` WHERE `id` = '$id'")->fetch();
    
    if($data['id'] != null)
    {
        if($data['username'] == TMQ_user()['username'])
        {
            if($data['status'] == 'Chờ')
            {
                $db->exec("UPDATE `TMQ_service_trans` SET `cash` = `cash` + '".$data['cash']."' WHERE `loai` = '".$data['loai']."' AND `username` = '".$data['username']."'");
                $db->exec("UPDATE `TMQ_history_ruby` SET `status` = 'Hủy' WHERE `id` = '$id'");
            }
        }
    }
     header("Location: /profile/withdrawruby");
}





//thêm lệnh rút
if(isset($_POST['submit']))
{
  $item = (int)$_POST['items'];
  $captcha = isset($_POST['captcha']) ? TMQ_check($_POST['captcha']) : false;
  $form = $db->query("SELECT `name`,`value` FROM `TMQ_withdrawruby_form` WHERE `id` = '$item'")->fetch();
  $form_name = TMQ_xoadau($form['name']);
  $form = explode(PHP_EOL,$form['value']);
  for($i=0;$i<count($form);$i++){
   $form[$i] = explode("|",$form[$i]);
   $name = TMQ_xoadau($form[$i][0]);
   if(!strip_tags($_POST[$name])) $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Vui lòng nhập đủ thông tin.</div>';
   if($form[$i][1] == 'select'){ 
       $cash = (int)abs(strip_tags($_POST[$name]));
       $check_form = $db->query("SELECT `id` FROM `TMQ_withdrawruby_form` WHERE `value` LIKE '%".strip_tags($_POST[$name])."%'")->fetch();
       //Check cash
       $check_cash = $db->query("SELECT `id`,`cash` FROM `TMQ_service_trans` WHERE `loai` = '$form_name'")->fetch();
       if($check_cash['cash'] < $cash){ $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Số dư không đủ</div>'; $cash_saugd = 0;}else{ $cash_saugd = $check_cash['cash'] - $cash;}
       if(!$check_form['id']) $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Lỗi hệ thống.</div>';
       
   }else{
       $dulieu[$i] = strip_tags($_POST[$name]);
       $t[$i] = $form[$i][0].":";
   }
   $data .= $t[$i].$dulieu[$i]."\n";
   }
   if(empty($item) || empty($captcha)){
        $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Vui lòng nhập đủ thông tin.</div>';  
   }elseif($cash_saugd == 0){
         $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Số dư không đủ để thực hiện giao dịch.</div>';  
   }else{
       
       //lưu lịch sử
       $db->exec("INSERT INTO `TMQ_history_ruby` 
       (`username`,`text`,`cash`,`loai`,`status`,`date`)
       VALUES
       ('".TMQ_user()['username']."', ".$db->quote($data).",'".(int)$cash."','$form_name','Chờ','".date("H:i:s d-m-Y")."')
       ");
       //trừ số dư
       $db->exec("UPDATE `TMQ_service_trans` SET `cash` = '$cash_saugd' WHERE `username` = '".TMQ_user()['username']."' AND `loai` = '$form_name'");
     
      $err = '<div class="alert alert-success alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Tạo đơn thành công.</div>'; 
   }
  
}
$salt = "Iui8*&@IJsad".date("Y-m-d H:i:s");
$token = md5($salt.TMQ_random(20)); 
$_SESSION["token"] = $token;
?>
<div class="c-layout-sidebar-content ">


<div class="c-content-title-1">
<h3 class="c-font-uppercase c-font-bold">Rút vật phẩm vòng quay</h3>
<div class="c-line-left"></div>
</div>
<div class="text-center">
<center>
<h2 class="c-font-bold c-font-28">ID: <?=TMQ_user()['id'];?></h2>
<h2 class="c-font-bold c-font-28"><?=TMQ_hide_email(TMQ_user()['email']);?></h2>
<h2 class="c-font-22"><?=TMQ_position(TMQ_user()['id']);?></h2>
<h2 class="c-font-22"></h2>
<h2 class="c-font-22 c-font-red"><?=number_format(TMQ_user()['cash']);?>đ</h2>
</center>
</div>
<?=$err;?>
<form class="form-horizontal" method="POST">
    <input type="hidden" name="_token" value="<?=$token;?>"/>
<div class="form-group">
<label class="col-md-3 control-label">Chọn loại VP:</label>
<div class="col-md-6">
<div class="input-group c-square">
<select style="width:400px;" class="form-control  c-square c-theme" name="items" id="items">
<option value="">Chọn ngay</option>
<?php 
$items = $db->query("SELECT * FROM `TMQ_service_trans` WHERE `username` = '".TMQ_user()['username']."'");
foreach($items as $item){ 
$rut = $db->query("SELECT `id`,`name` FROM `TMQ_withdrawruby_form` WHERE `name` LIKE '%".$item['loai']."%'")->fetch();
?>
<option value="<?=$rut['id'];?>"><?=$rut['name'].' - còn '.number_format($item['cash']);?></option>
<?php } ?>
</select>
</div>
</div>
</div>
<div class="block-load-info">
</div>
<div class="form-group c-margin-t-40">
<div class="col-md-offset-3 col-md-6">
<button type="submit" id="btn-confirm" name="submit" disabled class="btn c-theme-btn c-btn-square c-btn-uppercase c-btn-bold btn-block">Thực hiện</button>
</div>
</div>
</form>
<div class="" style="margin: 35px 0px;border: 1px solid #cccccc;padding: 15px">
</div>
<?php
$limit = 10;
if (isset($_GET["page"]))
{
    $page = $_GET["page"];
    settype($page, "int");
}
else
{
    $page = 1;
}
$from = ($page - 1) * $limit;
?>
<table id="charge_recent" class="table table-striped table-custom-res">
<tbody>
<tr>
<th>Thời gian</th>
<th>ID</th>
<?php
$th = $db->query("SELECT * FROM `TMQ_history_ruby`")->fetch();
$th = explode(PHP_EOL,$th['text']);
for($i = 0;$i < count($th)-1;$i++){
 $tr = explode(":",$th[$i]);
 echo "<th>".$tr[0]."</th>";
}
?>
<th>Cash</th>
<th>Trạng thái</th>
<th>Ghi chú</th>
<th>Thao tác</th>
</tr>
</tbody>
<?php
$history_ruby = $db->query("SELECT * FROM `TMQ_history_ruby` WHERE `username` = '".TMQ_user()['username']."' LIMIT $from,$limit");
if($history_ruby->rowCount()==0){
echo'<tr><td colspan="5">Không có dữ liệu</td></tr>';
}

foreach($history_ruby as $row){
?>
<tr>
    <td><?=$row['date'];?></td>
    <td><?=$row['id'];?></td>
<?php
for($i=0;$i<count($th)-1;$i++){
    $tr = explode(":",$th[$i]);
 echo "<td>".$tr[1]."</td>";
}
?>
<td><?=$row['cash'];?></td>
<td><?=$row['status'];?></td>
<td><?=$row['note'];?></td>   
<td>
    <?php
    if($row['status'] == 'Chờ') echo"<button type=\"button\" class=\"btn btn-danger c-btn-square btn-xs delete_toggle\" rel=\"".$row['id']."\">Hủy</button>";?>
    
    </td>
</tr>
<?php } ?>
<tbody>
</tbody>
</table>
<div class="data_paginate paging_bootstrap paginations_custom" style="text-align: center">
<?php
$tong = $db->query("SELECT `id` FROM `TMQ_history_ruby` WHERE `username` = '" . TMQ_user() ['username'] . "'")->rowcount();
if ($tong > $limit)
{
    echo '<center>' . TMQ_phantrang('/profile/withdrawruby?', $from, $tong, $limit) . '</center>';
} ?>
</div>
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
<form method="POST" accept-charset="UTF-8" class="form-horizontal">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Xác nhận thao tác</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">
Bạn thực sự muốn hủy lệnh rút vật phẩm?
</div>
<div class="modal-footer">
<input type="hidden" name="id" class="id" value="" />
<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
<button type="submit" name="del" class="btn btn-danger m-btn m-btn--custom">Xác nhận</button>
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

            $('#items').on('change', function (e) {

                var items = this.value;
                if (items != "") {
                    $.get('/assets/ajax/withdrawruby-load-info?id=' + items,

                        function (data) {

                            $('.block-load-info').html(data);
                            $('#btn-confirm').prop("disabled", false); // Element(s) are now enabled.

                        })
                        .done(function () {
                        })
                        .fail(function () {
                            alert('Không có dữ liệu.');
                        })
                }
                else {
                    $('.block-load-info').html("");
                    $('#btn-confirm').prop("disabled", true); // Element(s) are now enabled.
                }

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

</div>
<?php
require("../TMQ_sys/foot.php");
?>