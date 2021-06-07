<?php

if (!function_exists('upload_file')) {
    function upload_file($type, $file): array
    {
        // Kiểm tra có dữ liệu fileupload trong $_FILES không
        // Nếu không có thì dừng
        if (!isset($file)) {
            return [
                'success' => false,
                'message' => 'Dữ liệu không đúng cấu trúc'
            ];
        }

        // Kiểm tra dữ liệu có bị lỗi không
        if ($file["fileupload"]['error'] != 0) {
            return [
                'success' => false,
                'message' => 'Dữ liệu upload bị lỗi'
            ];
        }

        // Đã có dữ liệu upload, thực hiện xử lý file upload
        $ext = explode('.', $file['name']);
        $ext = $ext[count($ext) - 1];
        $fileName = md5($file["name"] . time()) . '.' . $ext;
        //Thư mục bạn sẽ lưu file upload
        $target_dir = dirname(__DIR__) . "/upload/{$type}/";
        //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)

        $target_file = $target_dir . $fileName;

        $allowUpload = true;

        //Lấy phần mở rộng của file (jpg, png, ...)
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        // Cỡ lớn nhất được upload (bytes)
        $maxfilesize = 800000;

        ////Những loại file được phép upload
        $allowtypes = array('jpg', 'png', 'jpeg', 'gif');


        //Kiểm tra xem có phải là ảnh bằng hàm getimagesize
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $allowUpload = true;
        } else {
            $allowUpload = false;
        }


        // Kiểm tra nếu file đã tồn tại thì không cho phép ghi đè
        // Bạn có thể phát triển code để lưu thành một tên file khác
        if (file_exists($target_file)) {
            $allowUpload = false;
        }
        // Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
        if ($file["size"] > $maxfilesize) {
            $allowUpload = false;
        }


        // Kiểm tra kiểu file
        if (!in_array($imageFileType, $allowtypes)) {
            $allowUpload = false;
        }


        if ($allowUpload) {
            // Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return [
                    'success' => true,
                    'message' => ' Đã upload thành công.',
                    'file_name' => $fileName
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi upload file.'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Không upload được file, có thể do file lớn, kiểu file không đúng ...'
            ];
        }

    }
}


if (!function_exists('get_upload_url')) {
    function get_upload_url($type, $name)
    {
        if (filter_var($name, FILTER_VALIDATE_URL)) return $name;
        return 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/upload/{$type}/{$name}";
    }
}
