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
require ('../TMQ_sys/function.php');
require ('head.php');
if (TMQ_admin() != 9 && TMQ_admin() != 1)
{
    header('Location: /');
}
?>
         <!-- partial -->
                <div class="main-panel">
                  <div class="content-wrapper">
                    <div class="page-header">
                      <h3 class="page-title"> Quản lý tin tức</h3>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                          <li class="breadcrumb-item active" aria-current="page">Quản lý tin tức</li>
                        </ol>
                      </nav>
                    </div>
<?php
if (isset($_POST['del']))
{
    if (isset($_POST['confirm']))
    {
        $id = (int)$_POST['del'];
        $db->exec("DELETE FROM `TMQ_tintuc` WHERE `id` = '$id'");
        header('Location: /admin/tintuc');
    }
    isset($_POST['cancel']) ? header("Location: /admin/tintuc") : false;
    echo '<div class="row">
                      <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="card-title">XÁC NHẬN XÓA #' . (int)$_POST['del'] . '</h4>
                            <form class="forms-sample" method="POST">
                              <div class="form-group">
                                <h1 style="color:red;">Sau khi xóa sẽ không thể khôi phục lại!</h1>
                                </div>
                                <input type="hidden" name="del" value="' . (int)$_POST['del'] . '" />
                              <button type="submit" name="confirm" class="btn btn-primary mr-2">Xóa</button>
                              <button class="btn btn-dark" type="submit" name="cancel">Hủy</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    ';
}

if(isset($_GET['edit'])){
    $id = isset($_GET['edit']) ? (int)$_GET['edit'] : null;
    if(!$id){ header("Location: /admin/tintuc"); }
    $data = $db->query("SELECT * FROM `TMQ_tintuc` WHERE `id` = '$id' LIMIT 1")->fetch();
    if(isset($_POST['submit'])){
        $title = TMQ_check($_POST['title']);
        $image = TMQ_check($_POST['thumbnail']);
        $text = trim($_POST['text']);
        $gioithieu = TMQ_check($_POST['description']); 
        if(empty($title) || empty($image) || empty($text) || empty($gioithieu)){
            $err = 'Vui lòng nhập dủ thông tin';
        }else{
            $db->exec("update `TMQ_tintuc` set 
            `username` = '".TMQ_user()['username']."', 
            `title` = ".$db->quote($title).",
            `text` = ".$db->quote($text).",
            `image` = ".$db->quote($image).",
            `description` = ".$db->quote($gioithieu).",
            `date` = '".date("d-m-Y")."' 
            where `id` = '$id'");
            header("Location: tintuc");
        }
    }
?>
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Sửa bài viết #<?=$id;?></h4>
                    <?=$err;?>
                    <form class="forms-sample" method="POST">
                        <div class="row">
                        <label>Tiêu đề</label>
                        <input type="text" class="form-control" placeholder="Nhập tiêu đề bài viết" name="title" value="<?=$data['title'];?>">
                      </div>
                       <div class="row">
                        <label>Giới thiệu ngắn</label>
                        <input type="text" class="form-control" placeholder="Nhập giới thiệu bài viết" name="description" value="<?=$data['description'];?>">
                      </div>
                      <div class="row">
                        <label>Hình ảnh</label>
                        <input type="text" class="form-control" placeholder="Nhập link ảnh đại demo" name="thumbnail" value="<?=$data['image'];?>">
                      </div>
                      <div class="row">
                        <label>Nội dung</label>
                       <div class="col-12">
                        <textarea class="form-control" name="text" id="text" rows="10"><?php if(!isset($_POST['text'])) echo $data['text']; else echo $text;?></textarea>
                      </div></div><p></p>
                      <button type="submit" name="submit" class="btn btn-primary mr-2">Sửa</button>

                    </form>
                  </div>
                </div>
              </div>
            </div>
<?php            
}
if(isset($_GET['add'])){
    if(isset($_POST['add'])){
        $title = TMQ_check($_POST['title']);
        $image = TMQ_check($_POST['thumbnail']);
        $text = trim($_POST['text']);
        $text = str_replace("<script>",null,$text);
        $text = str_replace("</script>",null,$text);
        $gioithieu = TMQ_check($_POST['description']); 
         if(empty($title) || empty($image) || empty($text) || empty($gioithieu)){
            $err = 'Vui lòng nhập dủ thông tin';
        }else{
            $db->exec("insert into `TMQ_tintuc` set 
            `username` = '".TMQ_user()['username']."', 
            `title` = ".$db->quote($title).",
            `text` = ".$db->quote($text).",
            `image` = ".$db->quote($image).",
            `description` = ".$db->quote($gioithieu).",
            `date` = '".date("d-m-Y")."' 
            ");
            header("Location: tintuc");
        }
    }
?>
<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Đăng bài viết</h4>
                    <?=$err;?>
                    <form class="forms-sample" method="POST">
                        <div class="row">
                        <label>Tiêu đề</label>
                        <input type="text" class="form-control" placeholder="Nhập tiêu đề bài viết" name="title" value="<?=isset($_POST['title']) ? $title : null; ?>">
                      </div>
                       <div class="row">
                        <label>Giới thiệu ngắn</label>
                        <input type="text" class="form-control" placeholder="Nhập giới thiệu bài viết" name="description" value="<?=isset($_POST['description']) ? $gioithieu : null;?>">
                      </div>
                      <div class="row">
                        <label>Hình ảnh</label>
                        <input type="text" class="form-control" placeholder="Nhập link ảnh đại demo" name="thumbnail" value="<?=isset($_POST['thumbnail']) ? $image : null;?>">
                      </div>
                      <div class="row">
                        <label>Nội dung</label>
                       <div class="col-12">
                        <textarea class="form-control" name="text" id="text" rows="10"><?=isset($_POST['text']) ? $text : null;?></textarea>
                      </div></div><p></p>
                      <button type="submit" name="add" class="btn btn-primary mr-2">Xuất bản</button>

                    </form>
                  </div>
                </div>
              </div>
            </div>
<?php
}
?>            
                    <div class="row">
                      <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="card-title">Danh sách - <a href="?add" style="color:yellow;">Đăng bài</a></h4>
                        
                            <div class="table-responsive">
                              <table id="bootstrap-data-table" style="text-align:center;" class="table table-hover table-bordered table-contextual">
                                <thead>
                                  <tr>
                                    <th>ID</th>
                                    <th>Người đăng</th>
                                    <th>Tiêu đề</th>
                                    <th>Nội dung</th>
                                    <th>Ngày đăng</th>
                                    <th>Thao tác</th>
                                  </tr>
                                </thead>
                                <tbody>
<?php
$baidang = $db->query("SELECT * FROM `TMQ_tintuc`");
foreach ($baidang as $row)
{
?>
                                  <tr>
                                    <td><?=$row['id']; ?></td>
                                    <td> <?=$row['username']; ?></td>
                                    <td><?=$row['title']; ?></td>
                                    <td><?php echo html_entity_decode(TMQ_cut($row['text'], 25)); ?></td>
                                    <td><?=$row['date'];?></td>
                                    <td> <p><button onclick="window.location='?edit=<?=$row['id'];?>'" class="btn btn-outline-secondary btn-icon-text">
                                    <form method="POST"> 
                                   
                                    <i class="mdi mdi-file-check btn-icon-append"></i> Sửa </button></p>
                                    <p> <button type="submit" name="del" value="<?=$row['id']; ?>" class="btn btn-outline-danger btn-icon-text">
                                    <i class="mdi mdi-delete btn-icon-prepend"></i> Xóa</button></p>
                                    </form>
                                    </td>
                                  </tr>
<?php
} ?>                         
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <script src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
  <script>
   CKEDITOR.replace( 'text' );
  </script>
 <!-- content-wrapper ends -->
<?php require ('foot.php'); ?>
