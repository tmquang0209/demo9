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
//xóa lệnh rút
if(isset($_POST['del'])){
    $id = (int)$_POST['id'];
    $check = $db->query("SELECT `id`,`username`,`amount` FROM `TMQ_withdraw` WHERE `username` = '".TMQ_user()['username']."' AND `id` = '$id'")->fetch();
    if($check['id'] != null){
        $db->exec("DELETE FROM `TMQ_withdraw` WHERE `id` = '$id'");
        $db->exec("UPDATE `TMQ_user` SET `cash` = `cash` + '".(int)$check['amount']."'");
        header("Loaction: /profile/withdraw");
    }
}
//thêm lệnh rút
if(isset($_POST['submit']) && $_POST["_token"] == $_SESSION['token'])
{
  $bank = TMQ_check($_POST['bank_account_id']);
  $amount = TMQ_check($_POST['amount']);
  $amount = str_replace(",",null,$amount);
  $amount = (int)abs($amount);
  $description = TMQ_check($_POST['description']);
  $captcha = isset($_POST['captcha']) ? TMQ_check($_POST['captcha']) : false;
  
  
  //get dữ liệu
  $get = $db->query("SELECT * FROM `TMQ_bank` WHERE `id` = ".$db->quote($bank)." AND `username` = '".TMQ_user()['username']."'")->fetch();
  //kiếm tra form
  if(empty($bank) || empty($amount) || empty($captcha)){
    $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Vui lòng nhập đủ thông tin.</div>';  
  }elseif($get['id'] == null){
    $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Thông tin ngân hàng/ví điện tử không tồn tại.</div>';  
  }elseif($amount < 100000){
    $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Số tiền rút tối thiểu 100.000<sup>đ</sup>.</div>';  
  }elseif($amount > 10000000){
    $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Số tiền rút tối đa là 10.000.000<sup>đ</sup>.</div>';  
  }elseif($amount > TMQ_user()['cash']){
     $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Số tiền không đủ để thực hiện giao dịch .</div>';  
  }elseif(!isset($_SESSION['captcha_code']) && $_SESSION['captcha_code'] != trim($captcha)){
    $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Captcha không chính xác.</div>';  
  }else{
    $err = '<div class="alert alert-success alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Đặt lệnh rút thành công.</div>';  
    //trừ tiền
    $db->exec("UPDATE `TMQ_user` SET `cash` = `cash` - $amount WHERE `id` = '".TMQ_user()['id']."'");
    //lịch sử giao dịch
    $db->exec("INSERT INTO `TMQ_withdraw`
    (`username`, `amount`, `bank`, `holder`, `number`, `branch`, `description`, `status`, `date`)
    VALUES
    ('".TMQ_user()['username']."','$amount','".$get['bank']."','".$get['holder']."','".$get['number']."','".$get['branch']."',".$db->quote($description).",'0','".date("H:i:s d-m-Y")."')
    ");
  }
}
$salt = "Iui8*&@IJsad".date("Y-m-d H:i:s");
$token = md5($salt.TMQ_random(20)); 
$_SESSION["token"] = $token;
?>
<div class="c-layout-sidebar-content ">


<div class="c-content-title-1">
<h3 class="c-font-uppercase c-font-bold">Rút tiền ra Ngân hàng - Ví</h3>
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
<label class="col-md-3 control-label">Ngân hàng:</label>
<div class="col-md-6">
<div class="input-group c-square">
<select class="form-control  c-square c-theme" name="bank_account_id" id="bank_account_id">
<option value="">Chọn tài khoản ngân hàng nhận tiền</option>
<?php 
$bank = $db->query("SELECT * FROM `TMQ_bank` WHERE `username` = '".TMQ_user()['username']."'");
foreach($bank as $bank){ ?>
<option value="<?=$bank['id'];?>"><?=$bank['number'].' - '.$bank['bank'];?></option>
<?php } ?>
</select>
<span class="input-group-btn">
<button class="btn btn-success c-font-dark load-modal" rel="/assets/ajax/bank">Thêm mới</button>
</span>
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
<table id="charge_recent" class="table table-striped table-custom-res">
<tbody>
<tr>
<th>Thời gian</th>
<th>ID</th>
<th>Chủ tài khoản</th>
<th>Số tài khoản/Tài khoản ví</th>
<th>Ngân hàng/Ví</th>
<th>Số tiền</th>
<th>Nội dung</th>
<th>Trạng thái</th>
<th>Thao tác</th>
</tr>
</tbody>
<?php
$status = array(
    0 => 'Chờ',
    1 => 'Bị hủy',
    2 => 'Thành công'
    );
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
$list_withdraw = $db->query("SELECT * FROM `TMQ_withdraw` WHERE `username` = '".TMQ_user()['username']."' LIMIT $from,$limit");
if($list_withdraw->rowCount()==0){
echo'<tr><td colspan="5">Không có dữ liệu</td></tr>';
}
foreach($list_withdraw as $row){
    $status = $status[$row['status']];
?>
<tr>
    <td><?=$row['date'];?></td>
    <td><?=$row['id'];?></td>
    <td><?=$row['holder'];?></td>
    <td><?=$row['number'];?></td>
    <td><?=$row['bank'];?></td>
    <td><?=number_format($row['amount']);?><sup>đ</sup></td>
    <td><?=$row['description'];?></td>
    <td><?=$status;?></td>
    <td><button type="button" class="btn btn-danger c-btn-square btn-xs delete_toggle" rel="<?=$row['id'];?>">Hủy</button></td>
</tr>
<?php } ?>
<tbody>
</tbody>
</table>
<div class="data_paginate paging_bootstrap paginations_custom" style="text-align: center">
    <?php
$tong = $db->query("SELECT `id` FROM `TMQ_withdraw` WHERE `username` = '" . TMQ_user() ['username'] . "'")->rowcount();
if ($tong > $limit)
{
    echo '<center>' . TMQ_phantrang('/profile/withdraw?', $from, $tong, $limit) . '</center>';
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
<form method="POST" action="/profile/withdraw" accept-charset="UTF-8" class="form-horizontal">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Xác nhận thao tác</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">
Bạn thực sự muốn hủy lệnh rút tiền?
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

            $('#bank_account_id').on('change', function (e) {

                var bank_account_id = this.value;
                if (bank_account_id != "") {
                    $.get('/assets/ajax/withdraw-load-info?id=' + bank_account_id,

                        function (data) {

                            $('.block-load-info').html(data);
                            $('#btn-confirm').prop("disabled", false); // Element(s) are now enabled.

                        })
                        .done(function () {
                        })
                        .fail(function () {
                            alert('Không tìm thấy thông tin tài khoản đã lưu');
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