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
if (isset($_POST['change'])):
    $old_password = TMQ_check($_POST['old_password']);
    $password = TMQ_check($_POST['password']);
    $password_confirmation = TMQ_check($_POST['password_confirmation']);

    if (!empty($old_password) || !empty($password) || !empty($password_confirmation))
    {
        if ($password == $password_confirmation)
        {
            if ($old_password != $password)
            {
                if (strlen($password) >= 6)
                {
                    if(TMQ_mahoa($old_password) == TMQ_user()['password'])
                    {
                    $db->exec("UPDATE `TMQ_user` SET `password` = " . $db->quote( TMQ_mahoa($password) ) . " WHERE `id` = '" . TMQ_user() ['id'] . "'");
                    $err = '<div class="alert alert-success alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Mật khẩu được đổi thành công.</div>';
                    }
                    else
                    {
                    $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Mật khẩu cũ không đúng.</div>';
                    }
                }
                else
                {
                    $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Mật khẩu mới phải tối thiểu 6 kí tự.</div>';
                }
            }
            else
            {
                $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Mật khẩu mới phải khác mật khẩu cũ.</div>';
            }
        }
        else
        {
            $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Hai mật khẩu mới không giống nhau.</div>';
        }
    }
    else
    {
        $err = '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>Vui lòng nhập đủ thông tin</div>';
    }
    else:
        $err = '';
    endif;
?>
 <div class="c-layout-sidebar-content ">


<div class="c-content-title-1">
<h3 class="c-font-uppercase c-font-bold">Đổi mật khẩu</h3>
<div class="c-line-left"></div>
</div>
<?=$err; ?>
<form method="POST" accept-charset="UTF-8" class="form-horizontal form-charge">
<div class="form-group">
<label class="col-md-3 control-label">Mật khẩu cũ:</label>
<div class="col-md-6">
<input class="form-control c-square c-theme " name="old_password" type="password" maxlength="32" required placeholder="Mật khẩu hiện tại">
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Mật khẩu mới:</label>
<div class="col-md-6">
<input class="form-control c-square c-theme " name="password" type="password" maxlength="32" required placeholder="Mật khẩu mới">
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Xác nhận:</label>
<div class="col-md-6">
<input class="form-control c-square c-theme " name="password_confirmation" type="password" maxlength="32" required placeholder="Xác nhận mật khẩu mới">
</div>
</div>
<div class="form-group c-margin-t-40">
<div class="col-md-offset-3 col-md-6">
<button name="change" type="submit" class="btn btn-submit c-theme-btn c-btn-square c-btn-uppercase c-btn-bold btn-block" data-loading-text="<i class='fa fa-spinner fa-spin '></i>">Đổi mật khẩu
</button>
<script>
                            $(".form-charge").submit(function(){
                                $('.btn-submit').button('loading');
                            });
                        </script>
</div>
</div>
</form>
</div>
</div>


</div>
<?php
    require ("../TMQ_sys/foot.php");
?>