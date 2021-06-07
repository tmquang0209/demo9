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
require('TMQ_sys/function.php');
if (isset($_POST['ajax']) == 'true') {
    $username = TMQ_check($_POST['taikhoan']);
    $password = TMQ_check($_POST['matkhau']);
    $check = $db->query("SELECT id,username,password FROM `TMQ_user` WHERE `username` = " . $db->quote($username) . " LIMIT 1")->fetch();
    if (empty($username) || empty($password)) {
        $err = 'Vui lòng nhập đủ thông tin!';
    } elseif ($check['id'] == null) {
        $err = 'Tài khoản không tồn tại!';
    } elseif ($check['password'] != TMQ_mahoa($password)) {
        $err = 'Mật khẩu không chính xác!';
    } else {
        $err = 'Đăng nhập thành công';
        $_SESSION['id'] = $check['id'];
        if ($_GET['redirectTo']) {
            echo '<script>location.href = "' . $_GET['redirectTo'] . '"</script>';
        }
        echo '<script>window.location="/";</script>';
    }
    print $err;
} else {
    require("TMQ_sys/head.php");
    isset($_SESSION['id']) ? header("Location: /") : null;
    if (isset($_POST['login'])) {
        $taikhoan = TMQ_check($_POST['taikhoan']);
        $matkhau = TMQ_check($_POST['matkhau']);
        $check = $db->query("SELECT `id`,`username`,`password` FROM `TMQ_user` WHERE `username` = " . $db->quote($taikhoan) . " LIMIT 1")->fetch();

        if (!empty($taikhoan) || !empty($matkhau)) {
            if ($check['username'] != null) {
                if ($check['password'] == TMQ_mahoa($matkhau)) {
                    $err = 'Đăng nhập thành công';
                    $_SESSION['id'] = $check['id'];

                    if ($_GET['redirectTo']) {
                        exit('<script>location.href = "' . $_GET['redirectTo'] . '"</script>');
                    };
                    header("Location: /");
                } else {
                    $err = 'Mật khẩu không chính xác.';
                }
            } else {
                $err = 'Tài khoản không tồn tại.';
            }
        } else {
            $err = 'Vui lòng nhập đủ thông tin.';
        }
    } else {
        $err = '';
    }
    ?>

    <div class="c-layout-page">

        <div class="login-box">

            <div class="login-box-body box-custom">
                <p class="login-box-msg">Đăng nhập hệ thống</p>
                <span class="help-block" style="text-align: center;color: #dd4b39">
<strong><?= $err; ?></strong>
</span>
                <form method="POST">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="taikhoan" value=""
                               placeholder="Tài khoản của Web">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="matkhau" placeholder="Mật khẩu">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="checkbox icheck">
                                <label style="color: #666">
                                    <input type="checkbox" name="remember" id="remember"> Ghi nhớ
                                </label>
                            </div>
                        </div>

                        <div class="col-xs-6" style="text-align: right">
                            <a href="/password/reset"
                               style="color: #666;margin-top: 10px;margin-bottom: 10px;display: block;font-style: italic;">Quên
                                mật khẩu?</a><br>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-xs-12">
                            <button type="submit" name="login" class="btn btn-primary btn-block btn-flat"
                                    style="margin: 0 auto;">Đăng nhập
                            </button>
                        </div>

                    </div>
                </form>
                <div class="social-auth-links text-center">
                    <p style="margin-top: 5px">- HOẶC -</p>

                    <a href="/login_facebook" class="btn  btn-social btn-facebook btn-flat d-inline-block"><i
                                class="fa fa-facebook"></i>Login FB</a>
                    <a href="/signup" class="btn  btn-social btn-google btn-flat d-inline-block"><i
                                class="icon-key icons"></i>Tạo tài
                        khoản</a>
                </div>

            </div>

        </div>

        <style>
            .login-box, .register-box {
                width: 400px;
                margin: 7% auto;

                padding: 20px;;
            }


            @media (max-width: 767px) {
                .login-box, .register-box {
                    width: 100%;
                }

            }

            .login-box-msg, .register-box-msg {
                margin: 0;
                text-align: center;
                padding: 0 20px 20px 20px;
                text-align: center;
                font-size: 20px;;
                font-weight: bold;
            }

            .box-custom {
                border: 1px solid #cccccc;
                padding: 20px;

                color: #666;
            }
        </style>

    </div>
    <?php require("TMQ_sys/foot.php");
} ?>
