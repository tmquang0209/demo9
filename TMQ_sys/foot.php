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
?>
<div class="modal fade" id="noticeModal" role="dialog" style="display: none;" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
<h4 class="modal-title" style="font-weight: bold;text-transform: uppercase;color: #FF0000;text-align: center">Thông báo</h4>
</div>
<div class="modal-body" style="font-family: helvetica, arial, sans-serif;"><?=html_entity_decode(TMQ_setting()['thongbao']);?></div>
<div class="modal-footer">
<button type="button" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" data-dismiss="modal">Đóng</button>
</div>
</div>
</div>
</div>
<style type="text/css">
    @media  only screen and (min-width: 768px){
        .row-flex-safari .classWithPad {
            height: 389px;
            max-height: 360px;
        }
    }
</style>
<script>

            $(document).ready(function(){
                if ($.cookie('noticeModal') != '1') {

                    $('#noticeModal').modal('show')
                    //show popup here

                    var date = new Date();
                    var minutes = 60;
                    date.setTime(date.getTime() + (minutes * 60 * 1000));
                    $.cookie('noticeModal', '1', { expires: date}); }
            });
        </script>

</div>
<div class="modal fade" id="noticeModal" role="dialog" style="display: none;" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="loader" style="text-align: center"><img src="/assets/frontend/images/loader.gif" style="width: 50px;height: 50px;display: none"></div>
<div class="modal-content"><?=html_entity_decode(TMQ_setting()['thongbao']);?></div>
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
<script>
    $(document).ready(function () {
        $('.load-modal').each(function (index, elem) {
            $(elem).unbind().click(function (e) {
                e.preventDefault();
                e.preventDefault();
                var curModal = $('#LoadModal');
                curModal.find('.modal-content').html("<div class=\"loader\" style=\"text-align: center\"><img src=\"/assets/frontend/images/loader.gif\" style=\"width: 50px;height: 50px;\"></div>");
                curModal.modal('show').find('.modal-content').load($(elem).attr('rel'));
            });
        });
    });
</script>
<a name="footer"></a>
<?=TMQ_bbcode(TMQ_setting()['footer']);?>
 <!-- MODAL -->
      <div class="modal fade" id="modal-login" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×</button>
                <h4 class="modal-title" id="myModalLabel">
                    Đăng nhập/Đăng ký</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8" style="border-right: 1px dotted #C2C2C2;padding-right: 30px;">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#Login" data-toggle="tab">Đăng nhập</a></li>
                            <li><a href="#Registration" data-toggle="tab">Đăng ký</a></li>
                            <li><a href="#Forgetpassword" data-toggle="tab">Quên mật khẩu</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="Login">
                                <div class="form-horizontal">
                                    <div style="text-align:center;color:red;" id="result"></div>
                                    <input type="hidden" id="ajax" value="true" />
                                <div class="form-group">
                                    <label for="username" class="col-sm-3 control-label">
                                        Tài khoản</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="username" placeholder="Nhập tài khoản..." />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="col-sm-3 control-label">
                                        Mật khẩu</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu..." />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-9">
                                        <button type="submit" id="login" class="btn btn-primary btn-sm">
                                            Đăng nhập</button>
                                        <a href="#Forgetpassword" data-toggle="tab">Quên mật khẩu?</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="Registration">
                                <div class="form-horizontal">
                                    <div style="text-align:center;color:red;" id="result_1"></div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">
                                        Họ tên</label>
                                    <div class="col-sm-9">
                            <input type="text" id="name" class="form-control" placeholder="Nhập họ tên" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">
                                        Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" id="email" class="form-control" id="email" placeholder="Nhập email" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mobile" class="col-sm-3 control-label">
                                        SĐT</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="mobile" placeholder="Nhập số điện thoại" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">
                                        Tài khoản</label>
                                    <div class="col-sm-9">
                                                <input type="text" id="taikhoan" class="form-control" placeholder="Nhập tài khoản" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-sm-3 control-label">
                                        Mật khẩu</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="matkhau" placeholder="Nhập mật khẩu" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-sm-3 control-label">
                                        Nhập lại MK</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="re_password" placeholder="Nhập lại mật khẩu" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-9">
                                        <button type="button" id="signup" class="btn btn-primary btn-sm">
                                            Đăng ký</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="Forgetpassword">
                                <div class="form-horizontal">
                                    <div style="text-align:center;color:red;" id="result_2"></div>
                                <div class="form-group">
                                    <input type="hidden" id="ajax" value="true"/>
                                    <label for="username" class="col-sm-3 control-label">
                                        Tài khoản</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="fusername" placeholder="Nhập tài khoản..." />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">
                                        Email</label>
                                    <div class="col-sm-6">
                                    <input type="email" class="form-control" id="femail" placeholder="Email..." />
                                    </div>
                                    <div class="col-sm-2">
                                    <button type="submit" id="send_code" class="btn btn-success btn-sm">
                                            Gửi mã</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">
                                        Mã xác nhận</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="fcode" placeholder="Mã xác nhận..." />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">
                                        Mật khẩu mới</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="fnewpass" placeholder="New password..." />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">
                                        Nhập lại</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="frenew" placeholder="Re-new password..." />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                    </div>
                                    <div class="col-sm-9">
                                        <button type="submit" id="forgetpassword" class="btn btn-primary btn-sm">
                                            Submit</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="OR" class="hidden-xs">
                            OR</div>
                    </div>
                    <div class="col-md-4">
                        <div class="row text-center sign-with">
                            <div class="col-md-12">
                                <h3>
                                    Sign in with</h3>
                            </div>
                            <div class="col-md-12">
                                <div class="btn-group btn-group-justified">
                                    <a href="/login_facebook" class="btn btn-primary">Facebook</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--[if lt IE 9]>
<![endif]-->
<script src="/assets/frontend/theme/assets/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/jquery.easing.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/reveal-animate/wow.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/demos/default/js/scripts/reveal-animate/reveal-animate.js" type="text/javascript"></script>

<script src="/assets/frontend/theme/assets/global/plugins/magnific/magnific.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/smooth-scroll/jquery.smooth-scroll.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/js-cookie/js.cookie.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/base/js/components.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/base/js/app.js" type="text/javascript"></script>
<script src="/assets/frontend/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script>
  $(document).ready(function () {
        App.init(); // init core
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })


    $(".menu-main-mobile a").click(function () {

        if ($(this).closest("li").hasClass("c-open")) {
            $(this).closest("li").removeClass("c-open");
        }
        else {
            $(this).closest("li").addClass("c-open");
        }
    });
    
 $('.launch-modal').on('click', function(e){
		e.preventDefault();
		$( '#' + $(this).data('modal-id') ).modal();
	    });
	    
	    
	//đăng nhập
		$("#login").on("click", function(){

		 $.ajax({
                    url : "/login",
                    type : "post",
                    dataType:"text",
                    data : {
                        ajax : $('#ajax').val(),
                        taikhoan : $('#username').val(), //Đọc tài khoản
                        matkhau : $('#password').val() // Đọc mật khẩu
                    },
                    success : function (result){
                        $('#result').html(result); // Lấy thông tin trả về

                    }
                });

	});
	//đăng ký
	$("#signup").on("click", function(){

		 $.ajax({
                    url : "/signup",
                    type : "post",
                    dataType:"text",
                    data : {
                        ajax : $('#ajax').val(),
                        taikhoan : $('#taikhoan').val(), //Đọc tài khoản
                        matkhau : $('#matkhau').val(), // Đọc mật khẩu
                        re_pass : $('#re_password').val(),
                        name : $('#name').val(),
                        email : $('#email').val(),
                        phone : $('#mobile').val(),
                    },
                    success : function (result){
                        $('#result_1').html(result); // Lấy thông tin trả về

                    }
                });

	});
	//quên mật khẩu
		$("#forgetpassword").on("click", function(){
    document.getElementById("result_2").innerHTML = "Vui lòng chờ...";
		 $.ajax({
                    url : "/forgetpassword.php",
                    type : "post",
                    dataType:"text",
                    data : {
                        ajax : $('#ajax').val(),
                        taikhoan : $('#fusername').val(), //Đọc tài khoản
                        email : $('#femail').val(), // Đọc mật khẩu
                        code : $('#fcode').val(),
                        newpass : $('#fnewpass').val(),
                        renew : $('#frenew').val()
                    },
                    success : function (result){
                        $('#result_2').html(result); // Lấy thông tin trả về
                    }
                   
                });

	});
		//send mã kích hoạt
		$("#send_code").on("click", function(){
    document.getElementById("result_2").innerHTML = "Vui lòng chờ...";
		 $.ajax({
                    url : "/send_code",
                    type : "post",
                    dataType:"text",
                    data : { email : $('#femail').val(), taikhoan : $('#fusername').val() },
                    success : function (result){
                        $('#result_2').html(result); // Lấy thông tin trả về
                    }
                });

	});
    console.log('%cThông tin chủ sở hữu:', 'color:red;font-size:40px');
    console.log('%cChủ sở hữu: Trần Minh Quang','font-size:30px');
    console.log('%cLiên hệ: 0397847805 / tmquang0209@gmail.com' ,'font-size:30px');
    console.warn('%cVui lòng không xóa để tôn trọng tác giả!!!','font-size:40px')
</script>


<script src="/assets/frontend/theme/assets/plugins/moment.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/demos/default/js/scripts/pages/datepicker.js" type="text/javascript"></script>
<script src="/assets/frontend/plugins/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js" type="text/javascript"></script>
<script src="/assets/frontend/js/common.js" type="text/javascript"></script>

<div id="fb-root"></div>
<div class="fb-customerchat" attribution=setup_tool page_id="2244640205777806" logged_in_greeting="Chào bạn, mình có thể hỗ trợ được gì cho bạn ạ." logged_out_greeting="Chào bạn, mình có thể hỗ trợ được gì cho bạn ạ.">
</div>
</body>
</html>