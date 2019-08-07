<?php 
    session_start();
    require_once '../config/index.php';

function showArray($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

    $email = '';
    $password = '';
    $errors = [];
    $users = [];
if (isset($_POST['submit'])) {

    if(!mb_strlen($_POST['email'])) {
        $errors[] = 'Please enter your email address';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter valid email address';
    } else {
        $email = trim($_POST['email']);
    }
    if(!mb_strlen($_POST['password'])) {
        $errors[] = 'Please enter your password';
    } else if (mb_strlen($_POST['password']) <8 ) {
        $errors[] = 'Your password should be more than 8 symbols';
    } else {
        $password = trim($_POST['password']);
    }

    if (!count($errors)) {
        $sql = "SELECT
            `id`,
            `type`,
            `email`,
            `password`
        FROM `".TABLE_USERS."`
        WHERE `email` = '".mysqli_real_escape_string($conn, $_POST['email'])."'
        ";
    
    
        if ($result = mysqli_query($conn, $sql)) {
            $users = mysqli_fetch_assoc($result);
    }
}
        if (is_array($users) && count($users)) {
            if (password_verify($password, $users['password'])) {
                unset($users['password']);
                $_SESSION['user'] = $users;
                header('Location: index.php');
            } else {
                $errors[] = "Your password is not correct";
            }
        } else {
            $errors[] = "USER NO";
        }

}


?>    



<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form action="" method="post">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" name="email" value="<?=$email?>" id="inputEmail" class="form-control" placeholder="Email address" required="required" autofocus="autofocus" />
              <label for="inputEmail">Email address</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required="required" />
              <label for="inputPassword">Password</label>
            </div>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me">
                Remember Password
              </label>
            </div>
          </div>
          <button type="submit" name="submit" class="btn btn-primary btn-block" href="index.html">Login</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.html">Register an Account</a>
          <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
          <ul>
            <?php if (isset($errors) && count($errors)) : ?>
                <?php for ($i=0; $i < count($errors); $i++) : ?> 
                    <li><?=$errors[$i];?></li>
                    <?php endfor?>
                <?php endif?>
        </ul>
        </div>
      </div>
    </div>
  </div>
 

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
