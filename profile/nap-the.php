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
require('../TMQ_sys/function.php'); 
require('../TMQ_sys/head.php'); 
require('menu.php'); 
?>
<div class="c-layout-sidebar-content ">
				<!-- BEGIN: PAGE CONTENT -->
				<!-- BEGIN: CONTENT/SHOPS/SHOP-CUSTOMER-DASHBOARD-1 -->
				<div class="c-content-title-1">
					<h3 class="c-font-uppercase c-font-bold">Nạp thẻ tự động</h3>
					<div class="c-line-left"></div>
				</div>


<?php
if (isset($_POST['submit'])) {
    if (!isset($_POST['type']) || !isset($_POST['serial']) || !isset($_POST['pin'])) {
        $err = 'Bạn cần nhập đầy đủ thông tin';
    } 
	else {
		$type = $_POST['type'];
		$pin = $_POST['pin'];
		$serial = $_POST['serial'];
		$amount = $_POST['amount'];



        if ($type == '' || $serial == '' || $pin == '' || $amount == '') {
            $err = 'Bạn cần nhập đầy đủ thông tin';
        } else {
            $url = 'http://sys.napthenhanh.com/api/charging-wcb'; //url API gạch thẻ của hệ thống
            $info = explode(PHP_EOL,TMQ_setting()['api_napthe']);
        	$partner_id = $info[0]; //API key, lấy từ website napthenhanh.com
        	$partner_key = $info[1]; //API secret lấy từ website napthenhanh.com
		
            $tranid = time() . rand(10000, 99999);  /// Cái này có thể mà mã order của bạn, nó là duy nhất (enique) để phân biệt giao dịch.

            /// Tạo chữ ký
            $sign = md5($partner_id . $partner_key . $type . $pin . $serial . $amount . $tranid);

            $data = array();
            $data['partner_id'] = $partner_id;
            $data['type'] = $type;
            $data['pin'] = $pin;
            $data['serial'] = $serial;
            $data['amount'] = $amount;
            $data['tranid'] = $tranid;
            $data['sign'] = $sign;

            if (is_array($data)) {
                $dataPost = http_build_query($data);
            } else {
                $dataPost = $data;
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataPost);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 300); //THÊM DÒNG NÀY SẼ TĂNG THỜI GIAN GỬI THẺ ĐƯỢC ỔN ĐỊNH
            $resultRaw = curl_exec($ch);
            curl_close($ch);
            $obj = json_decode($resultRaw);
             
            
         
            try {
                if ($obj && isset($obj->status)) {

                     if ($obj->status == 2  && isset($obj->tranid)) {
                        //Gửi thẻ lên Server Napthenhanh.com  thành công.
						//Thực hiện lưu thông tin thẻ kèm $obj->tranid tại đây.
						// Hệ thống Server Napthenhanh.com sẽ gọi callback lại để trả kết quả thẻ nạp.
						$smtp = $db->prepare("INSERT INTO `TMQ_napthe` 
						(`username`, `serial`, `mathe`, `menhgia`, `loaithe`, `status`, `tran_id`, `date`)
						VALUES
						(?,?,?,?,?,?,?,?)
						");
						$data = array(TMQ_user()['username'],$serial,$pin,(int)$amount,$type,'Chờ',$obj->tranid,date("H:i:s d-m-Y"));
						$smtp->execute($data);
                        echo '<div class="alert alert-success alert-block"><button type="button" class="close" data-dismiss="alert">×</button>'.$obj->message.' .</div>';                    

                    } else {
						//Gửi thẻ lên Server Napthenhanh.com  thất bại.Thông báo cho khách nạp tại đây 
						  echo '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>'.$obj->message.' .</div>'; 
                    }
					
                } else {
                    /// Lỗi xử lý thẻ
                  echo '<div class="alert alert-danger alert-block"><button type="button" class="close" data-dismiss="alert">×</button>'.$obj->message.' .</div>'; 

                }
            } catch (\Exception $e) {
                echo $e->getMessage();
            }

        }
    }
}
?>


 <form method="POST" action="">
                <div class="form-group">
                    <label>Loại thẻ:</label>
                     <select class="form-control" name="type">
                        <option value="">-- Chọn loại thẻ --</option>
                        <option value="VIETTEL" <?php if($_POST['type'] == 'VIETTEL'){ echo "selected"; } ?>>Viettel</option>
                        <option value="MOBIFONE" <?php if($_POST['type'] == 'MOBIFONE'){ echo "selected"; } ?>>Mobifone</option>
                        <option value="VINAPHONE" <?php if($_POST['type'] == 'VINAPHONE'){ echo "selected"; } ?>>Vinaphone</option>
                        <option value="GATE" <?php if($_POST['type'] == 'GATE'){ echo "selected"; } ?>>Gate</option>
                        <option value="ZING" <?php if($_POST['type'] == 'ZING'){ echo "selected"; } ?>>Zing</option>
                        <option value="SCOIN" <?php if($_POST['type'] == 'SCOIN'){ echo "selected"; } ?>>Scoin</option>
                        <option value="VCOIN" <?php if($_POST['type'] == 'VCOIN'){ echo "selected"; } ?>>Vcoin</option>
                        <option value="BIT" <?php if($_POST['type'] == 'BIT'){ echo "selected"; } ?>>BIT</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Mệnh giá:</label>
                   <select class="form-control" name="amount">
                        <option value="">-- Chọn mệnh giá --</option>
                        <option value="10000"<?php if($_POST['amount'] == '10000'){ echo "selected"; } ?>>10,000đ</option>
                        <option value="20000"<?php if($_POST['amount'] == '20000'){ echo "selected"; } ?>>20,000đ</option>
                        <option value="30000"<?php if($_POST['amount'] == '30000'){ echo "selected"; } ?>>30,000đ</option>
                        <option value="50000"<?php if($_POST['amount'] == '50000'){ echo "selected"; } ?>>50,000đ</option>
                        <option value="100000"<?php if($_POST['amount'] == '100000'){ echo "selected"; } ?>>100,000đ</option>
                        <option value="200000"<?php if($_POST['amount'] == '200000'){ echo "selected"; } ?>>200,000đ</option>
                        <option value="300000"<?php if($_POST['amount'] == '300000'){ echo "selected"; } ?>>300,000đ</option>
                        <option value="500000"<?php if($_POST['amount'] == '500000'){ echo "selected"; } ?>>500,000đ</option>
                        <option value="1000000"<?php if($_POST['amount'] == '1000000'){ echo "selected"; } ?>>1,000,000đ</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Số seri:</label>
                    <input type="text" class="form-control" name="serial" value="<?=isset($serial) ? $serial : null;?>"/>
                </div>
                <div class="form-group">
                    <label>Mã thẻ:</label>
                    <input type="text" class="form-control" name="pin" value="<?=isset($pin) ? $pin : null;?>"/>
                </div>
                <div class="form-group">
                    <?php echo (isset($err)) ? '<div class="alert alert-danger" role="alert">' . $err . '</div>' : ''; ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block" name="submit">NẠP NGAY</button>
                </div>
            </form>



	<table class="table cart-table">
			<thead>
                            <tr>
					<th>Trạng thái</th>
					<th>Serial</th>
					<th>Mã thẻ</th>
					<th>Loại thẻ</th>
					<th>Mệnh giá</th>
					<th>Thời gian</th>
					 </tr>
				</thead>
				<tbody>
<?php
$sotin1trang = 20;
if(isset($_GET['page'])){
 $page = intval($_GET['page']);
 }else{
 $page = 1;
 }
 $from = ($page - 1)* $sotin1trang;
if(isset($_POST['timkiem'])){
$get = $db->query("SELECT * FROM `TMQ_napthe` WHERE `username` = '".TMQ_user()['username']."' $start $end LIMIT $from,$sotin1trang");
}else{
$get = $db->query("SELECT * FROM `TMQ_napthe` WHERE `username` = '".TMQ_user()['username']."' LIMIT $from,$sotin1trang");
}
foreach($get as $nt){
?>				<tr>
<td><?=$nt['status'];?></td>
<td><?=$nt['serial'];?></td>
<td><?=$nt['mathe'];?></td>
<td><?=$nt['loaithe'];?></td>
<td><?=number_format($nt['menhgia']);?><sup>đ</sup></td>
<td><?=$nt['date'];?></td>
</tr>
<?php } ?>
				</tbody>
				</table>
	<?php 
$tong = $db->query("SELECT * FROM `TMQ_napthe` WHERE `username` = '".TMQ_user()['username']."'")->rowcount();

if ($tong > $sotin1trang){
echo '<center>' . TMQ_phantrang('?', $from, $tong, $sotin1trang) . '</center>';
} ?>

</div>	</div></div></div></div>
<?php require('../TMQ_sys/foot.php'); ?>