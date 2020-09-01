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
require("../TMQ_sys/function.php");
//LẤY ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
//KIỂM TRA ID
if(!$id){ die('ID = null'); exit; }
//LẤY DATA
$data = $db->query("SELECT * FROM `TMQ_service` WHERE `id` = '$id'")->fetch();
$value = explode(PHP_EOL,$data['value']);
$value = count($value);
$name = strtolower(TMQ_xoadau($data['name']));

if($data['id'] == null){ die('Vòng quay không tồn tại'); }
require("../TMQ_sys/head.php");
?>

<div class="c-layout-page">
<link href="/assets/frontend/vongquay/style.css" rel="stylesheet" type="text/css" />
<style>
    .ui-autocomplete {
            max-height: 500px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .input-group-addon {
            background-color: #FAFAFA;
        }

        .input-group .input-group-btn > .btn, .input-group .input-group-addon {
            background-color: #FAFAFA;
        }

        .modal {
            text-align: center;
        }

        @media        screen and (min-width: 768px) {
            .modal:before {
                display: inline-block;
                vertical-align: middle;
                content: " ";
                height: 100%;
            }
        }

        @media (min-width: 992px) and (max-width: 1200px) {
            .c-layout-header-fixed.c-layout-header-topbar .c-layout-page {
                margin-top: 245px;
            }
        }

        @media        screen and (max-width: 767px) {
            .modal-dialog:before {
                margin-top: 75px;
                display: inline-block;
                vertical-align: middle;
                content: " ";
                height: 100%;
            }

            .modal-dialog {
                width: 100%;

            }

            .modal-content {
                margin-right: 20px;
            }
        }

        .modal-dialog {
            display: inline-block;
            text-align: left;


        }

        .mfp-wrap {
            z-index: 20000 !important;
        }

        .c-content-overlay .c-overlay-wrapper {
            z-index: 6;
        }

        .z7 {
            z-index: 7 !important;
        }
        
        
        
        
        
    .nickdaquay{position:fixed;
    z-index:9999;
    bottom:170px;
    right:0px;
    max-width: 15%;
    min-width: 120px;
    min-height: 120px;}
    .anhbymanh{position:fixed;
    z-index:9999;
    bottom:80px;
    left:0px;
    max-width: 29%;
    min-height: 20px;}
    .napthebymanh{position:fixed;
    z-index:9999;
    bottom:100px;
    right:0px;
    max-width: 15%;
    min-height: 40px;
    min-width: 100px;
    }
    .flex-list .item {
        width: 50%;
        padding: 0 30px;
    }
        .rotation {
        text-align: center;
    }
    section {
        padding: 30px 0;
    }
        .rotation .play-spin {
        width: 100%;
        position: relative;
        margin: 0 auto;
    }
    .rotation .play-spin .ani-zoom {
        position: absolute;
        display: block;
        width: 110px;
        z-index: 5;
        top: calc(50% - 70px);
        left: calc(50% - 55px);
    }
    .ani-zoom {
        -webkit-transition: all .2s linear;
        -moz-transition: all .2s linear;
        -ms-transition: all .2s linear;
        -o-transition: all .2s linear;
        transition: all .2s linear;
    }
    img {
        max-width: 100%;
    }
    img {
        vertical-align: middle;
    }
    img {
        border: 0;
    }
    .text-center {
        text-align: center;
    }
    li{
        list-style: none;
    }

    .form-notication-bottom {
    position: fixed;
    bottom: 20px;
    left: 10px;
    width: 330px;
    height: auto;
    background-color: #fff;
    border-radius: 40px;
    z-index: 1;
    box-shadow: 2px 2px 10px 2px hsla(0,0%,60%,.2);
    animation: example 8s infinite;
    max-width: calc(90% - 10px);
    overflow: hidden;
}


@keyframes    example{0%{bottom: -100px;}25%{bottom: 20px;} 50%{bottom: 20px;}100%{bottom: -100px;}}

li {
    list-style-type: none
}
.history {
    width: 40% !important;
}
@media    only screen and (max-width: 800px) {
    .c-content-client-logos-slider-1 .item {
        width: 90%;
    }
    
    #rotate-play {
        width: 100% !important;
        max-width: 100% !important;
    }
    .rotation .play-spin .ani-zoom img {
        width: 85% !important;
    }
    .history {
        width: 100% !important;
    }
}
.c-content-box.c-size-md{
    padding: 0
}
.pd50{
    padding-top: 50px;
}
.list-roll{
    margin-top: 30px;
    margin-bottom: 30px;
}

@media    screen and (min-width: 800px) {
    .list-roll-inner{
        width: 85%;
        margin-top: 30px;
        max-height: 400px;
        overflow-y: scroll;
        margin:0 auto;
    }
}

@media    screen and (min-width: 1600px) {
    .list-roll-inner{
        width: 85%;
        margin-top: 30px;
        max-height: 600px;
        overflow-y: scroll;
        margin:0 auto;
    }
}
.btn-top{
    display: flex;
    justify-content: center;
    margin-bottom: 30px
}
.btn-top .btn{
    margin-left: 15px;
    margin-right: 15px;
    padding: 6px 20px;
}
.btn-top span{
    font-size: 25px;
}
@media    screen and (max-width: 640px) {
    .btn-top span{
        font-size: 17px;
    }
}
</style>
<div class="c-content-title-1 pd50">
<h3 class="c-center c-font-uppercase c-font-bold"><?=$data['name'];?></h3>
<div class="c-line-center c-theme-bg"></div>
</div>
<div class="col-lg-6 col-md-12">
<div class="c-content-box c-size-md c-bg-white">

<div class="c-content-client-logos-slider-1  c-bordered" data-slider="owl">
<div class="row row-flex-safari game-list" style="display: flex; flex-wrap: wrap">
<div class="item item-left">
<section class="rotation">
<div class="play-spin">
<a class="ani-zoom" id="start-played1"><img src="/assets/frontend/vongquay/quay.png" alt="Play Center"></a>
<img style="width: 80%;max-width: 80%;opacity: 1;" src="<?=$data['image'];?>" alt="Play" id="rotate-play">
</div>
<div class="text-center">
<h3 class="num-play">Giá mỗi lượt quay là <span><?=number_format($data['cash']);?><sup>đ</sup></span>.</h3>
<li><a style="" class="ani-zoom btn-img deposit-btn disabled" href="/nap-the" style="width:60%" data-toggle="modal" data-target="#modalBuy"><img src="assets/frontend/vongquay/image/mualuot.png" alt=""></a></li>
</div>
</section>
</div>
</div>
<div class="table-body scrollbar-inner">
<table class="table table-bordered">
<tbody></tbody>
</table>
</div>
</div>

</div>
</div>
<div class="col-lg-6 col-md-12 list-roll">
<div class="btn-top">
<a href="#" class="thele btn btn-success m-btn m-btn--custom m-btn--icon m-btn--pill">
<span>
<i class="la la-cloud-upload"></i>
<span>Thể Lệ</span>
</span>
</a>
<a href="/profile/withdrawruby" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--pill">
<span>
<i class="la la-cloud-upload"></i>
<span>Rút VP</span>
</span>
</a>
<a href="/rubywheel/logacc/1281" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--pill">
<span>
<i class="la la-cloud-upload"></i>
<span>Lịch sử quay</span>
</span>
</a>
</div>
<div class="modal fade" id="theleModal" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
<h4 class="modal-title" style="font-weight: bold;text-transform: uppercase;color: #FF0000;text-align: center">Thể Lệ</h4>
</div>
 <div class="modal-body" style="font-family: helvetica, arial, sans-serif;">
</div>
<div class="modal-footer">
<button type="button" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" data-dismiss="modal">Đóng</button>
</div>
</div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".thele").on("click", function(){
            $("#theleModal").modal('show');
        })
        $(".uytin").on("click", function(){
            $("#uytinModal").modal('show');
        })
    });
</script>
<div class="modal fade" id="uytinModal" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
<h4 class="modal-title" style="font-weight: bold;text-transform: uppercase;color: #FF0000;text-align: center">Uy Tín</h4>
</div>
<div class="modal-body" style="font-family: helvetica, arial, sans-serif;">
</div>
<div class="modal-footer">
<button type="button" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" data-dismiss="modal">Đóng</button>
</div>
</div>
</div>
</div>
<div class="c-content-title-1" style="margin: 0 auto">
<h3 class="c-center c-font-uppercase c-font-bold">LƯỢT QUAY GẦN ĐÂY</h3>
</div>
<div class="list-roll-inner">
<table cellpadding="10" class="table table-striped">
<tbody>
<tr>
<th>Tài khoản</th>
<th>Giải thưởng</th>
<th>Thời gian</th>
</tr>
</tbody>
<tbody>
<?php 
$log = $db->query("SELECT * FROM `TMQ_history` WHERE `buyer` = '".TMQ_user()['username']."' AND `loai` = '$name'");
foreach ($log as $row) {
?>
<tr>
<td><?=substr($row['buyer'],0,-3)."***";?></td>
<th><?=$row['infomation'];?></th>
<th><?=date("H:i:s d-m-Y",$row['time']);?></th>
</tr>
<?php } ?>


</tbody>
</table>
</div>
</div>
<div class="modal fade" id="noticeModal" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
<h4 class="modal-title" style="font-weight: bold;text-transform: uppercase;color: #FF0000;text-align: center">Thông báo</h4>
</div>
<div class="modal-body content-popup" style="font-family: helvetica, arial, sans-serif;">
TMQ
</div>
<div class="modal-footer">
<a href="/profile/withdrawruby" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--pill">Rút quà</a>
<button type="button" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" data-dismiss="modal">Đóng</button>
</div>
</div>
</div>
</div>
<style type="text/css">
        #start-played1{
            cursor: pointer;
        }
        .c-content-client-logos-slider-1 .item{
            width: 85%;
        }
    </style>
<input type="hidden" id="numgift" value="<?=$value;?>">
<script type="text/javascript">
    $(document).ready(function(e){
    var numrollbyorder = 0;
    var roll_check = true;
    var num_loop = 4;
    var angle_gift = '';
    var num_gift = $("#numgift").val();
    var gift_detail = '';
    var num_roll_remain = 0;
    var angles = 0;
    //Click nút quay
    $('body').delegate('#start-played1', 'click', function(){
        if(roll_check){
            roll_check = false;
            $.ajax({
                url: '/rubywheel-roll',
                datatype:'json',
                data:{
                   type : 'vongquay',
                   id : <?=$id;?>
                },
                type: 'post',
                success: function (data) {
                    data = JSON.parse(data);
                    if(data.status=='ERROR'){
                        roll_check = true;
                        $('#rotate-play').css({"transform": "rotate(0deg)"});
                        $('.content-popup').text(data.msg);
                        $('#noticeModal').modal('show');
                        return;
                    }
                    if(data.status=='LOGIN'){
                        location.href='/login';
                        return;
                    }
                    numrollbyorder = parseInt(data.numrollbyorder) + 1;
                    gift_detail = data.msg;
                    num_roll_remain = gift_detail.num_roll_remain;
                    $('#rotate-play').css({"transform": "rotate(0deg)"});
                    angles = 0;
                    angle_gift = gift_detail.pos*(360/num_gift);
                    loop();
                },
                error: function(){
                    $('.content-popup').text('Có lỗi xảy ra. Vui lòng thử lại!');
                    $('#noticeModal').modal('show');
                }
            })
        }
    });

    function loop() {
        $('#rotate-play').css({"transform": "rotate("+angles+"deg)"});
        
        if((parseInt(angles)-10)<=-(((num_loop*360)+angle_gift))){
            angles = parseInt(angles) - 2;
        }else{
            angles = parseInt(angles) - 10;
        }
        
        if(angles >= -((num_loop*360)+angle_gift)){
            requestAnimationFrame(loop);
        }else{
            roll_check = true;
                    
            $("#btnWithdraw").show();
            if(gift_detail.locale == 1)
            {
                $("#btnWithdraw").hide();
            }
            else
            {
                if(gift_detail.input_auto == 0)
                {
                    $("#btnWithdraw").html("Rút thưởng");
                    $("#btnWithdraw").attr('href','/profile/withdrawruby/<?=$id;?>');
                }
                else
                {
                    $("#btnWithdraw").hide();
                }
                
            }
            $('.content-popup').text('Kết quả: '+gift_detail.name);
            $('#noticeModal').modal('show');
            $('.num-play span').text(num_roll_remain);
            if(num_roll_remain==0){
                $('.deposit-btn').show();
            }else{
                $('.deposit-btn').hide();
            }
        }
    }
});

    $('body').delegate('.reLoad','click',function(){
        location.reload();
    })
</script>


</div>
<div class="modal fade" id="noticeModal" role="dialog" style="display: none;" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="loader" style="text-align: center"><img src="/assets/frontend/images/loader.gif" style="width: 50px;height: 50px;display: none"></div>
<div class="modal-content">
&lt;p style=&quot;text-align:center&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;https://shopmeowdgame.vn/upload/userfiles/images/meowww/hot.gif&quot; /&gt;CH&amp;Agrave;O MỪNG BẠN ĐẾN VỚI SHOP B&amp;Aacute;N NICK&amp;nbsp;&lt;img alt=&quot;&quot; src=&quot;https://shopmeowdgame.vn/upload/userfiles/images/meowww/hot.gif&quot; /&gt;&lt;/p&gt;
&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;Cập nhật Tự Động C&amp;aacute;c Dịch Vụ của NPH Garena: &lt;a href=&quot;/mo-ruong-may-man&quot;&gt;Click Xem Ngay&lt;/a&gt;&lt;/strong&gt;&lt;/p&gt;
&lt;p style=&quot;text-align:center&quot;&gt;&amp;nbsp;&lt;/p&gt;
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


<?php
require("../TMQ_sys/foot.php");
?>