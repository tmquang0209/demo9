<?php
	require $_SERVER['DOCUMENT_ROOT']."Classes/PHPExcel.php";
	$data = [];
	$user = $db->query("SELECT * FROM `TMQ_user`");
	foreach($user as $key => $row){
	    $data[$key] = [$row['id'],$row['username'],$row['name'],$row['phone'],$row['email'],$row['cash'],$row['ban'],$row['referral_code'],$row['date']];
	}
	//Khởi tạo đối tượng
	$excel = new PHPExcel();
	//Chọn trang cần ghi (là số từ 0->n)
	$excel->setActiveSheetIndex(0);
	//Tạo tiêu đề cho trang. (có thể không cần)
	$excel->getActiveSheet()->setTitle('Tài khoản');

	//Xét chiều rộng cho từng, nếu muốn set height thì dùng setRowHeight()
	$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
	$excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	$excel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
	$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	//Xét in đậm cho khoảng cột
	$excel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
	//Tạo tiêu đề cho từng cột
	//Vị trí có dạng như sau:
	/**
	 * |A1|B1|C1|..|n1|
	 * |A2|B2|C2|..|n1|
	 * |..|..|..|..|..|
	 * |An|Bn|Cn|..|nn|
	 */
	$excel->getActiveSheet()->setCellValue('A1', 'ID');
	$excel->getActiveSheet()->setCellValue('B1', 'Username');
	$excel->getActiveSheet()->setCellValue('C1', 'Name');
	$excel->getActiveSheet()->setCellValue('D1', 'Phone');
	$excel->getActiveSheet()->setCellValue('E1', 'Email');
	$excel->getActiveSheet()->setCellValue('F1', 'Cash');
	$excel->getActiveSheet()->setCellValue('G1', 'Ban');
	$excel->getActiveSheet()->setCellValue('H1', 'Referral Code');
	$excel->getActiveSheet()->setCellValue('I1', 'Date');
	// thực hiện thêm dữ liệu vào từng ô bằng vòng lặp
	// dòng bắt đầu = 2
	$numRow = 2;
	foreach($data as $row){
		$excel->getActiveSheet()->setCellValue('A'.$numRow, $row[0]);
		$excel->getActiveSheet()->setCellValue('B'.$numRow, $row[1]);
		$excel->getActiveSheet()->setCellValue('C'.$numRow, $row[2]);
		$excel->getActiveSheet()->setCellValue('D'.$numRow, $row[3]);
		$excel->getActiveSheet()->setCellValue('E'.$numRow, $row[4]);
		$excel->getActiveSheet()->setCellValue('F'.$numRow, $row[5]);
		$excel->getActiveSheet()->setCellValue('G'.$numRow, $row[6]);
		$excel->getActiveSheet()->setCellValue('H'.$numRow, $row[7]);
		$excel->getActiveSheet()->setCellValue('I'.$numRow, $row[8]);
		$numRow++;
	}
	// Khởi tạo đối tượng PHPExcel_IOFactory để thực hiện ghi file
	// ở đây mình lưu file dưới dạng excel2007
	PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('TMQ_user.xlsx');