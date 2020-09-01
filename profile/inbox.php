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
<h3 class="c-font-uppercase c-font-bold">Tin nhắn - thông báo</h3>
<div class="c-line-left"></div>
</div>
<table class="table table-hover table-custom-res">
<tbody>
<tr>
<th>Thời gian</th>
<th>Nội dung</th>
<th>Người gửi</th>
</tr>
</tbody>
<tbody>
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
    $data = $db->query("SELECT * FROM `TMQ_inbox` WHERE `username` = '" . TMQ_user() ['username'] . "' LIMIT $from,$limit");
foreach ($data as $row)
{
?>
    <tr>
        <td><?=$row['date']; ?></td>
        <td><?=html_entity_decode($row['text']); ?></td>
        <td><?=$row['from']; ?></td>
    </tr>
    <?php
}
?>
</tbody>
</table>

<div class="data_paginate paging_bootstrap paginations_custom" style="text-align: center">
<?php
$tong = $db->query("SELECT `id` FROM `TMQ_inbox` WHERE `username` = '" . TMQ_user() ['username'] . "'")
    ->rowcount();
if ($tong > $sotin1trang)
{
    echo '<center>' . TMQ_phantrang('/profile/inbox?', $from, $tong, $limit) . '</center>';
} ?>
</div>
</div>
</div>
</div>
<?php
require ("../TMQ_sys/foot.php");
?>
