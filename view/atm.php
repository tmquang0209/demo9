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
?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
<h4 class="modal-title">Nạp tiền từ ATM hoặc Ví điện tử</h4>
</div>
<div class="modal-body">
<div class="c-content-tab-4 c-opt-3" role="tabpanel">
<div class="text-center" style="text-transform: uppercase;margin: 20px 0;"><a href="/huong-dan-mua-nick-bang-atm-tai-nickvn" style="color: #f31700 !important;font-size: 15px">Hướng dẫn chi tiết nạp tiền từ ATM - VÍ Tại đây</a></div>
<ul class="nav nav-justified" role="tablist">
<li role="presentation" class="active">
<a href="#bank" role="tab" data-toggle="tab" class="c-font-16"  aria-expanded="true">ATM</a>
</li>
<li role="presentation" class="">
<a href="#wallet" role="tab" data-toggle="tab" class="c-font-16" aria-expanded="false">Ví điện tử</a>
</li>
</ul>
<div class="tab-content">
<div role="tabpanel" class="tab-pane fade active in" id="bank">
<ul class="c-tab-items p-t-0 p-b-0 p-l-5 p-r-5">
<li class="c-font-dark">

<table cellpadding="10" class="table table-striped">
<tbody>
<tr>
<th>Chủ tài khoản</th>
<th>Ngân hàng</th>
<th>Số tài khoản</th>
<th>Chi nhánh</th>
</tr>
<?php
$atm = explode(PHP_EOL,TMQ_setting()['atm']);
foreach($atm as $bank){
    $data = explode("|",$bank);
?>
<tr>
<td><?=$data[0];?></td>
<th><?=$data[1];?></th>
<th><?=$data[2];?></th>
<th><?=$data[3];?></th>
</tr>
<?php
}
?>
</tbody>
</table>
</li>
</ul>
<div class="tut-charge" style="background-color: #ffffff;padding-top: 15px">
<p>Nội dung thanh toán: <strong>Nap Tien <?=TMQ_user()['username'];?></strong> hoặc <strong>Nap Tien ID <?=TMQ_user()['id'];?></strong></p>
<p>Chuyển xong chụp lại lịch sử giao dịch chuyển tiền thanh c&ocirc;ng gửi v&agrave;o mục <strong>H&Atilde;Y CH&Aacute;T VỚI CH&Uacute;NG T&Ocirc;I </strong>hoặc<strong>&nbsp;</strong>&nbsp;<strong>fanpage</strong> :&nbsp;<strong><a href="https://www.facebook.com/game.cskh/">CSKH - Tr&ugrave;m C&aacute;c Game Online</a></strong>&nbsp;hoặc Hotline&nbsp;<strong><?=TMQ_setting()['phone'];?></strong>&nbsp;để được xử l&yacute;.</p>
</div>
</div>
<div role="tabpanel" class="tab-pane fade" id="wallet">
<ul class="c-tab-items p-t-0 p-b-0 p-l-5 p-r-5">
<li class="c-font-dark">

<table cellpadding="10" class="table table-striped">
<tbody>
<?php 
$wallet = explode(PHP_EOL,TMQ_setting()['wallet']);
foreach($wallet as $vi){
    $info = explode("|",$vi);
?>
<tr>
<td><strong><?=$info[0];?>:</strong></td>
<td><strong><?=$info[1];?></strong></td>
</tr>
<?php
}
?>
</tbody>
</table>
</li>
</ul>
<div class="tut-charge" style="background-color: #ffffff;padding-top: 15px">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</div>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" data-dismiss="modal">Đóng</button>
</div>
</form>
