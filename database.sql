-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 29, 2020 at 01:12 PM
-- Server version: 5.7.28-log
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ozetiysl_demo9`
--

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_baiviet`
--

CREATE TABLE `TMQ_baiviet` (
  `id` bigint(20) NOT NULL,
  `username` text CHARACTER SET utf8 NOT NULL,
  `taikhoan` text CHARACTER SET utf8 NOT NULL,
  `matkhau` text CHARACTER SET utf8 NOT NULL,
  `cash` int(11) NOT NULL,
  `loai` int(11) NOT NULL,
  `thongtin` text CHARACTER SET utf8,
  `trangthai` text CHARACTER SET utf8 NOT NULL,
  `search` text CHARACTER SET utf8,
  `img` text CHARACTER SET utf8,
  `date` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_bank`
--

CREATE TABLE `TMQ_bank` (
  `id` bigint(20) NOT NULL,
  `username` text CHARACTER SET utf8 NOT NULL,
  `bank` text CHARACTER SET utf8 NOT NULL,
  `holder` text CHARACTER SET utf8,
  `number` text CHARACTER SET utf8 NOT NULL,
  `branch` text CHARACTER SET utf8,
  `loai` int(11) NOT NULL,
  `date` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_chuyenmuc`
--

CREATE TABLE `TMQ_chuyenmuc` (
  `id` bigint(20) NOT NULL,
  `name` text CHARACTER SET utf8,
  `image` text CHARACTER SET utf8,
  `notification` text CHARACTER SET utf8,
  `loai` int(11) DEFAULT NULL,
  `id_cmm` int(11) DEFAULT NULL,
  `status` text CHARACTER SET utf8,
  `date` text CHARACTER SET utf8
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_coupon`
--

CREATE TABLE `TMQ_coupon` (
  `id` bigint(20) NOT NULL,
  `username` text CHARACTER SET utf8 NOT NULL,
  `code` text CHARACTER SET utf8 NOT NULL,
  `amount` int(11) NOT NULL,
  `solan` int(11) DEFAULT NULL,
  `date` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_filter`
--

CREATE TABLE `TMQ_filter` (
  `id` int(11) NOT NULL,
  `id_cm` int(11) NOT NULL,
  `filter` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_history`
--

CREATE TABLE `TMQ_history` (
  `id` bigint(20) NOT NULL,
  `buyer` text CHARACTER SET utf8 NOT NULL,
  `seller` text CHARACTER SET utf8 NOT NULL,
  `infomation` text CHARACTER SET utf8 NOT NULL,
  `cash` int(11) NOT NULL,
  `original` int(11) DEFAULT NULL,
  `sodu` int(11) NOT NULL,
  `loai` text CHARACTER SET utf8 NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_history_gift`
--

CREATE TABLE `TMQ_history_gift` (
  `id` bigint(20) NOT NULL,
  `username` text CHARACTER SET utf8 NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `loai` text CHARACTER SET utf8 NOT NULL,
  `service` text CHARACTER SET utf8 NOT NULL,
  `date` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_history_ruby`
--

CREATE TABLE `TMQ_history_ruby` (
  `id` bigint(20) NOT NULL,
  `username` text CHARACTER SET utf8 NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `cash` int(11) DEFAULT NULL,
  `loai` text CHARACTER SET utf8 NOT NULL,
  `status` text CHARACTER SET utf8 NOT NULL,
  `note` text CHARACTER SET utf8,
  `date` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_inbox`
--

CREATE TABLE `TMQ_inbox` (
  `id` int(11) NOT NULL,
  `username` text CHARACTER SET utf8 NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `from` text CHARACTER SET utf8 NOT NULL,
  `date` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_key`
--

CREATE TABLE `TMQ_key` (
  `id` int(11) NOT NULL,
  `email` text CHARACTER SET utf8 NOT NULL,
  `key` text CHARACTER SET utf8 NOT NULL,
  `date` text CHARACTER SET utf8 NOT NULL,
  `loai` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_license`
--

CREATE TABLE `TMQ_license` (
  `id` int(11) NOT NULL,
  `key` text CHARACTER SET utf8 NOT NULL,
  `expiry_date` int(11) NOT NULL,
  `secret_code` text CHARACTER SET utf8 NOT NULL,
  `status` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_napthe`
--

CREATE TABLE `TMQ_napthe` (
  `id` bigint(20) NOT NULL,
  `username` text CHARACTER SET utf8 NOT NULL,
  `serial` varchar(20) NOT NULL,
  `mathe` varchar(20) NOT NULL,
  `menhgia` int(11) NOT NULL,
  `loaithe` text CHARACTER SET utf8 NOT NULL,
  `status` text CHARACTER SET utf8 NOT NULL,
  `tran_id` text CHARACTER SET utf8 NOT NULL,
  `date` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_noibat`
--

CREATE TABLE `TMQ_noibat` (
  `id` int(11) NOT NULL,
  `name` text CHARACTER SET utf8 NOT NULL,
  `image` text CHARACTER SET utf8 NOT NULL,
  `url` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_service`
--

CREATE TABLE `TMQ_service` (
  `id` int(11) NOT NULL,
  `username` text CHARACTER SET utf8 NOT NULL,
  `name` text CHARACTER SET utf8 NOT NULL,
  `image_thumb` text CHARACTER SET utf8 NOT NULL,
  `image` text CHARACTER SET utf8 NOT NULL,
  `value` text CHARACTER SET utf8 NOT NULL,
  `cash` int(11) NOT NULL,
  `loai` text CHARACTER SET utf8 NOT NULL,
  `status` text CHARACTER SET utf8 NOT NULL,
  `date` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_service_gift`
--

CREATE TABLE `TMQ_service_gift` (
  `id` bigint(20) NOT NULL,
  `username` text CHARACTER SET utf8 NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `loai` text CHARACTER SET utf8 NOT NULL,
  `date` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_service_trans`
--

CREATE TABLE `TMQ_service_trans` (
  `id` bigint(20) NOT NULL,
  `username` text CHARACTER SET utf8 NOT NULL,
  `cash` int(11) NOT NULL,
  `loai` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_setting`
--

CREATE TABLE `TMQ_setting` (
  `id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8,
  `thongbao` text CHARACTER SET utf8 NOT NULL,
  `phone` text CHARACTER SET utf8,
  `email` text CHARACTER SET utf8,
  `logo` text CHARACTER SET utf8,
  `facebook` text CHARACTER SET utf8,
  `youtube` text CHARACTER SET utf8,
  `baotri` text CHARACTER SET utf8,
  `send_mail` text CHARACTER SET utf8 NOT NULL,
  `limit_page` int(11) NOT NULL,
  `banner` text CHARACTER SET utf8,
  `header` text CHARACTER SET utf8,
  `footer` text CHARACTER SET utf8,
  `bank` text,
  `atm` text CHARACTER SET utf8,
  `wallet` text CHARACTER SET utf8,
  `api_napthe` text CHARACTER SET utf8,
  `api_login` text CHARACTER SET utf8
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TMQ_setting`
--

INSERT INTO `TMQ_setting` (`id`, `title`, `thongbao`, `phone`, `email`, `logo`, `facebook`, `youtube`, `baotri`, `send_mail`, `limit_page`, `banner`, `header`, `footer`, `bank`, `atm`, `wallet`, `api_napthe`, `api_login`) VALUES
(1, 'Developer By TMQ', '&lt;p&gt;Thông báo test&lt;/p&gt;', '0397847805', 'tmquang0209@gmail.com', 'https://demo9.tmquang.monster/images/logo.png', 'https://www.facebook.com/tmq.dz.pro', 'https://www.youtube.com/channel/UCN1sk_YoebdKPwzt9MnMp9Q', 'on', 'tmqsendmail@gmail.com\nquangdz123\n465', 32, 'https://nick.vn/storage/images/NrHIh37vUI_1585564506.jpg\r\nhttps://nick.vn/storage/images/NrHIh37vUI_1585564506.jpg\r\nhttps://nick.vn/storage/images/NrHIh37vUI_1585564506.jpg\r\nhttps://nick.vn/storage/images/NrHIh37vUI_1585564506.jpg\r\nhttps://nick.vn/storage/images/NrHIh37vUI_1585564506.jpg', '<li class=\"c-menu-type-classic\"><a rel=\"\" href=\"/\" class=\"c-link dropdown-toggle \">Trang chủ</a></li><li class=\"c-menu-type-classic\"><a rel=\"\" href=\"/mua-the\" class=\"c-link dropdown-toggle \">Mua thẻ</a></li><li class=\"c-menu-type-classic\"><a rel=\"\" href=\"#\" class=\"c-link dropdown-toggle \">Dịch vụ<span class=\"c-arrow c-toggler\"></span></a>\r\n<ul id=\"children-of-733\" class=\"dropdown-menu c-menu-type-classic c-pull-left \">\r\n<li class=\"c-menu-type-classic\"><a rel=\"\" href=\"/dich-vu\" class=\"\">Dịch Vụ Game</a></li><li class=\"c-menu-type-classic\"><a rel=\"\" href=\"/vong-quay-may-man\" class=\"\">Vòng Quay May Mắn</a></li><li class=\"c-menu-type-classic\"><a rel=\"\" href=\"/mo-ruong-may-man\" class=\"\">Mở rương may mắn</a></li></ul>\r\n</li><li class=\"c-menu-type-classic\"><a rel=\"\" href=\"/mo-ruong-may-man\" class=\"c-link dropdown-toggle \">Mở rương</a></li><li class=\"c-menu-type-classic\"><a rel=\"\" href=\"#\" class=\"c-link dropdown-toggle \">Nạp tiền<span class=\"c-arrow c-toggler\"></span></a>\r\n<ul id=\"children-of-41\" class=\"dropdown-menu c-menu-type-classic c-pull-left \">\r\n\"c-menu-type-classic\"><a rel=\"\" href=\"/nap-the\" class=\"\">Nạp thẻ tự động</a></li><li class=\"c-menu-type-classic\"><a rel=\"/atm\" href=\"/atm\" class=\"load-modal\">Nạp tiền từ ATM/Ví điện tử</a></li></ul>\r\n</li><li class=\"c-menu-type-classic\"><a rel=\"\" href=\"#\" class=\"c-link dropdown-toggle \">Tin tức<span class=\"c-arrow c-toggler\"></span></a>\r\n<ul id=\"children-of-42\" class=\"dropdown-menu c-menu-type-classic c-pull-left \">\r\n<li class=\"c-menu-type-classic\"><a rel=\"\" href=\"/blog\" class=\"\">Blog</a></li><li class=\"c-menu-type-classic\"><a rel=\"\" href=\"/uy-tin-cua-shop\" class=\"\">UY TÍN CỦA SHOP</a></li><li class=\"c-menu-type-classic\"><a rel=\"\" href=\"/danh-sach-gdv-group\" class=\"\">Danh Sách GDV group</a></li><li class=\"c-menu-type-classic\"><a rel=\"\" href=\"/dich-vu-game\" class=\"\">Dịch Vụ Game</a></li></ul>', '<footer class=\"c-layout-footer c-layout-footer-3 c-bg-dark\">\r\n<div class=\"c-prefooter\">\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-4\">\r\n<div class=\"c-container c-first\">\r\n\r\n<p><span style=\"color:#ffffff\"><span style=\"font-size:22px\"><strong>VỀ </strong></span></span><span style=\"color:#16a085\"><span style=\"font-size:22px\"><strong>{domain_strtoupper}</strong></span></span></p>\r\n<p><span style=\"color:#bdc3c7\">Chuyên mua bán nick các game... an toàn. Tin cậy nhanh chóng. Giao dịch tự động 24/24</span></p>\r\n<ul>\r\n<li><a href=\"/gioi-thieu\"><span style=\"color:#ffffff\">Giới thiệu</span></a></li>\r\n<li><a href=\"/huong-dan-mua-tai-khoan\"><span style=\"color:#ffffff\">Hướng Dẫn Mua Tài Khoản</span></a></li>\r\n<li><a href=\"/huong-dan-nick-mua-tra-gop\"><span style=\"color:#ffffff\">Hướng Dẫn Mua Nick Trả Góp</span></a></li>\r\n<li><a href=\"/tuyen-dai-ly-cung-cap-nick-tai-nickvn\"><span style=\"color:#ffffff\">Tuyển Đại Lý cung cấp nick tại Nick.vn</span></a></li>\r\n<li><a href=\"/lien-he-gop-y\"><span style=\"color:#ffffff\">Liên hệ/góp ý</span></a></li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class=\"col-md-4\">\r\n<div class=\"c-container c-last\">\r\n\r\n\r\n\r\n<h2><span style=\"font-size:22px\"><span style=\"color:#ffffff\"><strong>CHÚNG TÔI Ở ĐÂY</strong></span></span></h2>\r\n<h3><span style=\"color:#bdc3c7\"><span style=\"font-size:16px\">Chúng tôi làm việc một cách chuyên nghiệp, uy tín, nhanh chóng và luôn đặt quyền lợi của bạn lên hàng đầu.</span></span></h3>\r\n<p> </p>\r\n<p><span style=\"color:#ffffff\"><i class=\"fa fa-phone\"></i> <strong>Hotline:</strong> <strong>{phone}</strong></span></p>\r\n<p><span style=\"color:#ffffff\"><i class=\"fa fa-times\"></i> <strong>Thời gian làm việc 8h-11h30 & 13h30-22h</strong></span></p>\r\n</div>\r\n</div>\r\n<div class=\"col-md-4\">\r\n<div id=\"fb-root\"></div>\r\n<div class=\"fb-page\" data-href=\"\" data-tabs=\"timeline\" data-height=\"270\" data-small-header=\"false\" data-adapt-container-width=\"true\" data-hide-cover=\"false\" data-show-facepile=\"true\">\r\n<blockquote cite=\"\" class=\"fb-xfbml-parse-ignore\"><a href=\"\">{domain_strtoupper}</a>\r\n</blockquote>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n  <div class=\"c-postfooter\" style=\"margin-top: -70px\">\r\n        <div class=\"container\">\r\n            <div class=\"row\">\r\n                <div class=\"col-md-6 col-sm-12 c-col\">\r\n                    <p class=\"c-copyright c-font-grey\">{year} © Developed by <a style=\"color: #32c5d2 !important\" href=\"https://www.facebook.com/tmq.dz.pro\">TMQ</a>\r\n                        <span class=\"c-font-grey-3\"> </span>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</footer>', 'Vietcombank\nTechcombank\nTPBank\nViettinbank\n---\nAzpro\nTSR\nMomo', 'Chủ tài khoản 1|Tên ngân hàng 1|Số tài khoản 1|Chi Nhánh 1\r\nChủ tài khoản 2|Tên ngân hàng 2|Số tài khoản 2|Chi Nhánh 2\r\nChủ tài khoản 3|Tên ngân hàng 3|Số tài khoản 3|Chi Nhánh 3\r\nChủ tài khoản 4|Tên ngân hàng 4|Số tài khoản 4|Chi Nhánh 4', 'Momo|0397847805', '808\n97df34859c39547bec87b23e6f906325', '288516005643692\ne6ae9c89839e12ea9fbe23bf706944d9');

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_tintuc`
--

CREATE TABLE `TMQ_tintuc` (
  `id` int(11) NOT NULL,
  `username` text CHARACTER SET utf8 NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `image` text CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
  `text` text CHARACTER SET utf8 NOT NULL,
  `date` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_transfer`
--

CREATE TABLE `TMQ_transfer` (
  `id` int(11) NOT NULL,
  `transfer` text CHARACTER SET utf8 NOT NULL,
  `receiver` text CHARACTER SET utf8 NOT NULL,
  `amount` int(11) NOT NULL,
  `description` text CHARACTER SET utf8,
  `date` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_user`
--

CREATE TABLE `TMQ_user` (
  `id` bigint(20) NOT NULL,
  `name` text CHARACTER SET utf8 NOT NULL,
  `username` text CHARACTER SET utf8 NOT NULL,
  `password` text CHARACTER SET utf8,
  `password_2` text CHARACTER SET utf8,
  `phone` text CHARACTER SET utf8,
  `email` text CHARACTER SET utf8 NOT NULL,
  `cash` int(11) NOT NULL,
  `ban` int(11) NOT NULL,
  `admin` int(11) NOT NULL,
  `login` int(11) DEFAULT NULL,
  `referral_code` text CHARACTER SET utf8,
  `date` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_withdraw`
--

CREATE TABLE `TMQ_withdraw` (
  `id` int(11) NOT NULL,
  `username` text CHARACTER SET utf8 NOT NULL,
  `amount` int(11) NOT NULL,
  `bank` text CHARACTER SET utf8 NOT NULL,
  `holder` text CHARACTER SET utf8,
  `number` text CHARACTER SET utf8 NOT NULL,
  `branch` text CHARACTER SET utf8,
  `description` text CHARACTER SET utf8,
  `status` int(11) NOT NULL,
  `date` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TMQ_withdrawruby_form`
--

CREATE TABLE `TMQ_withdrawruby_form` (
  `id` int(11) NOT NULL,
  `username` text CHARACTER SET utf8 NOT NULL,
  `name` text CHARACTER SET utf8 NOT NULL,
  `value` text CHARACTER SET utf8,
  `loai` text CHARACTER SET utf8 NOT NULL,
  `date` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `TMQ_baiviet`
--
ALTER TABLE `TMQ_baiviet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_bank`
--
ALTER TABLE `TMQ_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_chuyenmuc`
--
ALTER TABLE `TMQ_chuyenmuc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_coupon`
--
ALTER TABLE `TMQ_coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_filter`
--
ALTER TABLE `TMQ_filter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_history`
--
ALTER TABLE `TMQ_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_history_gift`
--
ALTER TABLE `TMQ_history_gift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_history_ruby`
--
ALTER TABLE `TMQ_history_ruby`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_inbox`
--
ALTER TABLE `TMQ_inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_key`
--
ALTER TABLE `TMQ_key`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_license`
--
ALTER TABLE `TMQ_license`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_napthe`
--
ALTER TABLE `TMQ_napthe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_noibat`
--
ALTER TABLE `TMQ_noibat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_service`
--
ALTER TABLE `TMQ_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_service_gift`
--
ALTER TABLE `TMQ_service_gift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_service_trans`
--
ALTER TABLE `TMQ_service_trans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_setting`
--
ALTER TABLE `TMQ_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_tintuc`
--
ALTER TABLE `TMQ_tintuc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_transfer`
--
ALTER TABLE `TMQ_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_user`
--
ALTER TABLE `TMQ_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_withdraw`
--
ALTER TABLE `TMQ_withdraw`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TMQ_withdrawruby_form`
--
ALTER TABLE `TMQ_withdrawruby_form`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `TMQ_baiviet`
--
ALTER TABLE `TMQ_baiviet`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_bank`
--
ALTER TABLE `TMQ_bank`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_chuyenmuc`
--
ALTER TABLE `TMQ_chuyenmuc`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_coupon`
--
ALTER TABLE `TMQ_coupon`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_filter`
--
ALTER TABLE `TMQ_filter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_history`
--
ALTER TABLE `TMQ_history`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_history_gift`
--
ALTER TABLE `TMQ_history_gift`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_history_ruby`
--
ALTER TABLE `TMQ_history_ruby`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_inbox`
--
ALTER TABLE `TMQ_inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_key`
--
ALTER TABLE `TMQ_key`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_license`
--
ALTER TABLE `TMQ_license`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_napthe`
--
ALTER TABLE `TMQ_napthe`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_noibat`
--
ALTER TABLE `TMQ_noibat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_service`
--
ALTER TABLE `TMQ_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_service_gift`
--
ALTER TABLE `TMQ_service_gift`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_service_trans`
--
ALTER TABLE `TMQ_service_trans`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_setting`
--
ALTER TABLE `TMQ_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `TMQ_tintuc`
--
ALTER TABLE `TMQ_tintuc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_transfer`
--
ALTER TABLE `TMQ_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_user`
--
ALTER TABLE `TMQ_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_withdraw`
--
ALTER TABLE `TMQ_withdraw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TMQ_withdrawruby_form`
--
ALTER TABLE `TMQ_withdrawruby_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
