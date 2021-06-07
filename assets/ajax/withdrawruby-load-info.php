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
require ("../../TMQ_sys/function.php");
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

$show = $db->query("SELECT * FROM `TMQ_withdrawruby_form` WHERE `id` = '$id'")->fetch();

$sodu = $db->query("SELECT `cash` FROM `TMQ_service_trans` WHERE `loai` = '" . TMQ_xoadau($show['name']) . "' LIMIT 1")->fetch();

$sodu = $sodu['cash'];

if ($show['id'] == null)
{
    die();
    exit();
}

?>

 <div class="form-group">
<label class="col-md-3 control-label">Loại:</label>
<div class="col-md-6">
<p id="type" class="form-control c-square c-theme c-theme-static m-b-0"><?=$show['name']; ?></p>
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Số dư:</label>
<div class="col-md-6">
<p id="stk" class="form-control c-square c-theme c-theme-static m-b-0"><?=number_format($sodu); ?></p>
</div>
</div>

<?php
$form = explode(PHP_EOL, $show['value']);
foreach ($form as $row)
{
    $form = explode("|", $row);

    if ($form[1] == 'select')
    {
?>
<div class="form-group">
<label class="col-md-3 control-label"><?=$form[0]; ?>:</label>
<div class="col-md-6">
<select class="form-control  c-square c-theme" name="<?=TMQ_xoadau($form[0]); ?>" id="<?=TMQ_xoadau($form[0]); ?>">
<?php
        for ($i = 2;$i <= count($form) - 1;++$i)
        {
?>
<option value="<?=(int)$form[$i]; ?>"><?=$form[$i]; ?></option>
<?php
        }
?>
</select>
</div>
</div>
<?php

    }
    else
    {
        echo "<div class=\"form-group\">
<label class=\"col-md-3 control-label\">" . $form[0] . ":</label>
<div class=\"col-md-6\">
<input class=\"form-control c-square c-theme\" name=\"" . TMQ_xoadau($form[0]) . "\" type=\"text\" placeholder=\"\">
</div>
</div>";
    }

}
?>
<div class="form-group">
<label class="col-md-3 control-label"><b>Mã bảo vệ:</b></label>
<div class="col-md-6">
<div class="input-group">
<span class="input-group-addon" style="padding: 0px;">
<img src="/captcha" height="30px" id="imgcaptcha" onclick="document.getElementById('imgcaptcha').src ='/captcha?'+Math.random();document.getElementById('captcha').focus();">
</span>
<input type="text" class="form-control c-square" id="captcha" name="captcha" placeholder="" maxlength="3" autocomplete="off" required="">
</div>
</div>
</div>
<script>
    jQuery(document).ready(function () {

        $('.price').mask('000,000,000,000,000', {reverse: true});
        $('.price').focus();
    });

</script>
