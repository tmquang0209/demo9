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
 require("../../TMQ_sys/function.php");
 $data = explode("---",TMQ_setting()['bank']);
 $bank = explode(PHP_EOL,$data[0]);
 $vi = explode(PHP_EOL,$data[1]);
?>
 <div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
<h4 class="modal-title">Thêm ngân hàng/Ví</h4>
</div>
<div class="modal-body">
<div class="c-content-tab-4 c-opt-3" role="tabpanel">
<ul class="nav nav-justified" role="tablist">
<li role="presentation" class="active">
<a href="#payment" role="tab" data-toggle="tab" class="c-font-16">Ngân hàng</a>
</li>
<li role="presentation">
<a href="#info" role="tab" data-toggle="tab" class="c-font-16">Ví điện tử</a>
</li>
</ul>
<div class="tab-content">
<div role="tabpanel" class="tab-pane fade in active" id="payment">
<form class="form-horizontal" method="POST" action="/profile/bank">
<input type="hidden" name="bank_type" value="0">
<div class="modal-body">
<div class="form-group m-t-10">
<label class="col-md-3 control-label"><b>Ngân hàng:</b></label>
<div class="col-md-6">
<select name="bank_id" class="form-control c-square c-theme">
<option value="">Chọn ngân hàng</option>
<?php
for($i = 0; $i < count($bank)-1; $i++){
echo '<option value="'.$bank[$i].'">'.$bank[$i].'</option>';    
}
?>
</select>
</div>
</div>
<div class="form-group m-t-10">
<label class="col-md-3 control-label"><b>Chủ tài khoản:</b></label>
<div class="col-md-6">
<input class="form-control c-square c-theme" type="text" name="holder_name" placeholder="Chủ tài khoản" required="" autofocus="">
</div>
</div>
<div class="form-group m-t-10">
<label class="col-md-3 control-label"><b>Số tài khoản:</b></label>
<div class="col-md-6">
<input class="form-control c-square c-theme" type="text" name="account_number" placeholder="Số tài khoản" required="" autofocus="">
</div>
</div>
<div class="form-group m-t-10">
<label class="col-md-3 control-label"><b>Chi nhánh:</b></label>
<div class="col-md-6">
<input class="form-control c-square c-theme" type="text" name="brand" placeholder="Chi nhánh" required="">
</div>
</div>
<div class="alert alert-success c-font-dark">
<b>Các thông tin trên bạn vui lòng cung cấp chính xác để không xảy ra lỗi khi xử lý yêu cầu rút tiền của bạn. Nếu bạn nhập sai thông tin ngân hàng sẽ hoàn trả lại tiền và không hoàn phí rút tiền.</b><br>
</div>
</div>
<div class="modal-footer">
<button type="submit" name="add_bank" class="btn c-theme-btn c-btn-square c-btn-uppercase c-btn-bold"  id="d3" style="">Thêm ngân hàng</button>
<button type="button" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" data-dismiss="modal">Đóng</button>
</div>
</form>
</div>
<div role="tabpanel" class="tab-pane fade" id="info">
<form class="form-horizontal" method="POST" action="/profile/bank">
<input type="hidden" name="bank_type" value="1">
<div class="modal-body">
<div class="form-group m-t-10">
<label class="col-md-3 control-label"><b>Ví:</b></label>
<div class="col-md-6">
<select name="bank_id" class="form-control c-square c-theme">
<option value="">Ví điện tử:</option>
<?php
for($i = 1; $i < count($vi); $i++){
echo '<option value="'.$vi[$i].'">'.$vi[$i].'</option>';    
}
?>
</select>
</div>
</div>
<div class="form-group m-t-10">
<label class="col-md-3 control-label"><b>Tài khoản ví:</b></label>
<div class="col-md-6">
<input class="form-control c-square c-theme" type="text" name="account_vi" placeholder="Tài khoản ví" required="" >
</div>
</div>
<div class="form-group m-t-10">
<label class="col-md-3 control-label"><b>Nhập lại tài khoản ví:</b></label>
<div class="col-md-6">
<input class="form-control c-square c-theme" type="text" name="account_vi_confirmation" placeholder="Nhập lại tài khoản ví" required="">
</div>
</div>
<div class="alert alert-success c-font-dark">
<b>Rút về các ví điện tử. Tất cả thông tin gồm tên tài khoản hoặc số điện thoại hoặc email tài khoản ở ví đó.</b><br>
</div>
</div>
<div class="modal-footer">
<button type="submit" name="add_vi" class="btn c-theme-btn c-btn-square c-btn-uppercase c-btn-bold"  id="d3" style="">Thêm ví điện tử</button>
<button type="button" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" data-dismiss="modal">Đóng</button>
</div>
</form>
</div>
</div>
</div>
<div style="clear: both"></div>
</div>
<script>
    $(document).ready(function () {
        $('.load-modal').each(function (index, elem) {
            $(elem).unbind().click(function (e) {
                e.preventDefault();
                e.preventDefault();
                var curModal= $('#LoadModal');
                curModal.find('.modal-content').html("<div class=\"loader\" style=\"text-align: center\"><img src=\"/assets/frontend/images/loader.gif\" style=\"width: 50px;height: 50px;\"></div>");
                curModal.modal('show').find('.modal-content').load($(elem).attr('rel'));
            });
        });
    });
</script>