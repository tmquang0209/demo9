<?php
/*
* Code được thực hiện bởi Trần Minh Quang
* SDT: 0397847805 - Email: tmquang0209@gmail.com
* Vui lòng không xóa dòng này để tôn trọng tác giả
*/
session_start();
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
if (version_compare(PHP_VERSION, '7.0', '<')) {
    die('<div style="text-align: center; font-size: xx-large"><strong>ERROR!</strong><br>Your needs PHP 7.0 or higher</div>');
}
if (!file_exists("database.sql")) {
    die('<div style="text-align: center; font-size: xx-large"><strong>ERROR!</strong><br>The file database not exisits</div>');
}
if (isset($_POST['s_step1'])) {
    $key = $_POST['key'];
//    $check = curl($key);
    $check = 3;
    if (empty($key)) {
        $err = "<div style='color:red;'>Please fill out the information</div>";
    } elseif ($check == 0) {
        $err = "<div style='color:red;'>License is not valid</div>";
    } elseif ($check == 1) {
        $err = "<div style='color:red;'>The domain is incorrect</div>";
    } elseif ($check == 2) {
        $err = "<div style='color:red;'>The license has expired</div>";
    } else {
        $_SESSION['key'] = $key;
        header("Location: ?step=2");
    }
}
if (isset($_POST['s_step2'])) {
    $host = $_POST['host'];
    $user = $_POST['user'];
    $name = $_POST['name'];
    $pass = $_POST['pass'];
    $file = file("database.sql");
    if (empty($host) || empty($user) || empty($name) || empty($pass)) {
        $err = "<div style='color:red;'>Please fill out the information</div>";
    } elseif (db_connect($host, $user, $name, $pass) === false) {
        $err = "<div style='color:red;'>Connection to database failed</div>";
    } else {
        $_SESSION['host'] = $host;
        $_SESSION['user'] = $user;
        $_SESSION['name'] = $name;
        $_SESSION['pass'] = $pass;
        upload_sql($file);
        create_file_database($host, $user, $name, $pass);
        header("Location: ?step=3");
        $_SESSION['connect'] = true;
    }
}
if (isset($_POST['s_step3'])) {
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $nphone = $_POST['nphone'];
    $uname = $_POST['uname'];
    $pword = $_POST['pword'];
    $referral_code = strtoupper(TMQ_random(6));

    $date = date('H:i:s d-m-Y');
    if (!empty($fname) || !empty($email) || !empty($phone) || !empty($uname) || !empty($pword)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            db_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['name'], $_SESSION['pass']);
            $db->exec("INSERT INTO TMQ_user (`name`, `username`, `password`, `password_2`, `phone`, `email`, `cash`, `ban`, `admin`, `login`, `referral_code`, `date`) VALUES ('$fname','$uname','" . ma_hoa($pword) . "','" . ma_hoa($pword) . "','$nphone','$email','0','0','9','0','$referral_code','" . date("H:i:s d-m-Y") . "')");
            die('<h1>Shop installation success.</h1>
        <p>Your login information:</p>
        <p><b>Username: </b>' . $uname . '</p>
        <p><b>Password: </b>' . $pword . '</p>
        <p><b>Password admin: </b>' . $pword . '</p>
        <p><a href="?finish">Return to home page</a></p>
        ');
        } else {
            $err = '<div style="color:red;">Email address is not valid.</div>';
        }
    } else {
        $err = '<div style="color:red;">Please fill out the infomation.</div>';
    }
}
if (isset($_GET['finish'])) {
    unlink('install.php');
    unlink('database.sql');
    unlink('error_log');
    header("Location: /");
}
$err = isset($err) ? $err : null;
?>
  <!DOCTYPE html>
  <html>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <style>
      * {
          box-sizing: border-box;
      }

      body {
          background-color: #f1f1f1;
      }

      #regForm {
          background-color: #ffffff;
          margin: 100px auto;
          font-family: Raleway;
          padding: 40px;
          width: 70%;
          min-width: 300px;
      }

      h1 {
          text-align: center;
      }

      input {
          padding: 10px;
          width: 100%;
          font-size: 17px;
          font-family: Raleway;
          border: 1px solid #aaaaaa;
      }

      /* Mark input boxes that gets an error on validation: */
      input.invalid {
          background-color: #ffdddd;
      }

      /* Hide all steps by default: */
      .tab {
          display: none;
      }

      button {
          background-color: #4CAF50;
          color: #ffffff;
          border: none;
          padding: 10px 20px;
          font-size: 17px;
          font-family: Raleway;
          cursor: pointer;
      }

      button:hover {
          opacity: 0.8;
      }

      #prevBtn {
          background-color: #bbbbbb;
      }

      /* Make circles that indicate the steps of the form: */
      .step {
          height: 15px;
          width: 15px;
          margin: 0 2px;
          background-color: #bbbbbb;
          border: none;
          border-radius: 50%;
          display: inline-block;
          opacity: 0.5;
      }

      .step.active {
          opacity: 1;
      }

      /* Mark the steps that are finished and valid: */
      .step.finish {
          background-color: #4CAF50;
      }
  </style>
  <body>
  <form id="regForm" method="POST">
      <?php
      if ($step == 1) {
          echo '<div class="tab">
       <h1>Activation code:</h1>
      
    <p><input placeholder="Code..." name="key"></p>' . $err . '
  </div>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="submit" id="nextBtn" name="s_step1">Next</button>
    </div>
  </div>';
      } elseif ($step == 2) {
          echo '
  <!-- One "tab" for each step in the form: -->
  <div class="tab">
       <h1>Database configuration:</h1>
       Localhost:
    <p><input placeholder="Host name..."  name="host"></p>
    Username:
    <p><input placeholder="User name..."  name="user"></p>
    Database:
    <p><input placeholder="Database name..."  name="name"></p>
    Password:
    <p><input placeholder="Password..."  name="pass"></p>' . $err . '
  </div>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="submit" id="nextBtn" name="s_step2">Next</button>
    </div>
  </div>
  ';
      } elseif ($step == 3) {
          echo '<div class="tab"><h1>Create account admin</h1>
    FullName:
    <p><input placeholder="Full name" name="fname"></p>
    Email:    
    <p><input placeholder="email" name="email"></p>
    Number phone
    <p><input placeholder="Number phone" name="nphone"></p>
    Username:
    <p><input placeholder="Username" name="uname"></p>
    Password:
    <p><input placeholder="Password" name="pword"></p>' . $err . '
  </div>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="submit" id="nextBtn" name="s_step3">Submit</button>
    </div>
  </div>
';
      }
      ?>
  </form>

  <script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
      // This function will display the specified tab of the form...
      var x = document.getElementsByClassName('tab');
      x[n].style.display = 'block';
      //... and fix the Previous/Next buttons:
      if (n == 0) {
        document.getElementById('prevBtn').style.display = 'none';
      } else {
        document.getElementById('prevBtn').style.display = 'inline';
      }
      if (n == (x.length - 1)) {
        document.getElementById('nextBtn').innerHTML = 'Submit';
      } else {
        document.getElementById('nextBtn').innerHTML = 'Next';
      }
      //... and run a function that will display the correct step indicator:
      fixStepIndicator(n);
    }

    function nextPrev(n) {
      // This function will figure out which tab to display
      var x = document.getElementsByClassName('tab');
      // Exit the function if any field in the current tab is invalid:
      if (n == 1 && !validateForm()) return false;
      // Hide the current tab:
      x[currentTab].style.display = 'none';
      // Increase or decrease the current tab by 1:
      currentTab = currentTab + n;
      // if you have reached the end of the form...
      if (currentTab >= x.length) {
        // ... the form gets submitted:
        document.getElementById('regForm').submit();
        return false;
      }
      // Otherwise, display the correct tab:
      showTab(currentTab);
    }

    function validateForm() {
      // This function deals with validation of the form fields
      var x, y, i, valid = true;
      x = document.getElementsByClassName('tab');
      y = x[currentTab].getElementsByTagName('input');
      // A loop that checks every input field in the current tab:
      for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].value == '') {
          // add an "invalid" class to the field:
          y[i].className += ' invalid';
          // and set the current valid status to false
          valid = false;
        }
      }
      // If the valid status is true, mark the step as finished and valid:
      if (valid) {
        document.getElementsByClassName('step')[currentTab].className += ' finish';
      }
      return valid; // return the valid status
    }

    function fixStepIndicator(n) {
      // This function removes the "active" class of all steps...
      var i, x = document.getElementsByClassName('step');
      for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(' active', '');
      }
      //... and adds the "active" class on the current step:
      x[n].className += ' active';
    }
  </script>

  </body>
  </html>
<?php
function curl($key)
{
    $param = array('key' => $key, 'domain' => $_SERVER['HTTP_HOST']);
    $url = 'https://tmquang.xyz/check_key.php';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, count($param));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function db_connect($db_host, $db_name, $db_user, $db_pass)
{
    global $db;
// Set options
    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
// Create a new PDO instanace
    try {
        $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass, $options);
    } // Catch any errors
    catch (PDOException $e) {
        return "false";
        exit();
    }
}

function upload_sql($file)
{
    global $db;
    $query = '';
    foreach ($file as $line) {
        $query .= $line;
    }
    $db->exec($query);
}

function create_file_database($db_host, $db_name, $db_user, $db_pass)
{
    $f_data = fopen('TMQ_sys/database.php', 'w');
    $text = '<?php
/*
$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
$$ NAME CODE: SHOP BÁN TỰ ĐỘNG ĐA CHỨC NĂNG             $$
$$ DEVELOPER: TRẦN MINH QUANG (TMQ)                     $$
$$ CONTACT: 0397847805 - tmquang0209@gmail.com          $$
$$ CREATE: 06/2020                                      $$
$$ VUI LÒNG KHÔNG XÓA BẢN QUYỀN ĐỂ TÔN TRỌNG TÁC GIẢ    $$
$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
*/    
ob_start();
session_start();
error_reporting(0);
date_default_timezone_set("Asia/Ho_Chi_Minh");
// Set options
$options = array(
PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);
// Create a new PDO instanace
try {
$db = new PDO("mysql:host=' . $db_host . ';dbname=' . $db_name . '","' . $db_user . '", "' . $db_pass . '", $options);
}
// Catch any errors
catch (PDOException $e) {
echo $e->getMessage();
exit();
}
  ?>  ';
    fwrite($f_data, $text);
    fclose($f_data);
}

function ma_hoa($txt)
{
    return sha1(md5(md5(md5(md5(md5($txt))))));
}

function TMQ_random($length)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $size = strlen($chars);
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[rand(0, $size - 1)];
    }
    return $str;
}

?>
