<?php

include_once "connectdb.php";
session_start();

error_reporting();

if (isset($_POST['btnregister'])) {

  $name = $_POST['newreg_name'];
  $gender = $_POST['newreg_gender'];
  $email = $_POST['newreg_email'];
  $phone = $_POST['newreg_phone'];
  $password = $_POST['newreg_password'];
  $rpassword = $_POST['newreg_password_r'];
  $role = "Admin";

  if ($password!= $rpassword) {

    $_SESSION['status'] = "Password don't match";
    $_SESSION['status_code'] = "warning";
  
} else {

    if (isset($_POST['newreg_email'])) {

    $select = $pdo->prepare("select useremail from register_tbl where useremail='$email'");

    $select->execute();

    if ($select->rowCount() > 0) {

      $_SESSION['status'] = "Email already registered";
      $_SESSION['status_code'] = "warning";

    } else {

      $insert = $pdo->prepare('insert into register_tbl (username, gender, useremail, phone, userpassword, role) values(:name, :gender, :email, :phone, :password, :role)');

      $insert->bindParam(':name', $name);
      $insert->bindParam(':gender', $gender);
      $insert->bindParam(':email', $email);
      $insert->bindParam(':phone', $phone);
      $insert->bindParam(':password', $password);
      $insert->bindParam(':role', $role);

      if ($insert->execute()) {

        $_SESSION['status'] = "Registered successfully";
        $_SESSION['status_code'] = "success";
        header('refresh: 1; ../index.php');

      } else {

        $_SESSION['status'] = "Register failed";
        $_SESSION['status_code'] = "error";

      }

    }
  }
}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pos_Clarke | Registration Page</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="../index.php"><b>Pos</b>Clarke</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Name" name="newreg_name" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <select class="form-control" name="newreg_gender">
                            <option value="" disabled selected>Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="newreg_email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Phone Number" name="newreg_phone" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="newreg_password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Retype password" name="newreg_password_r" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <a href="../index.php" class="text-center">I already have an account</a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block" name="btnregister">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="/../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/../dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
</body>

</html>

<?php

if (!empty($_SESSION['status']) && !empty($_SESSION['status_code'])) {

  $icon = $_SESSION['status_code'];
  $title = $_SESSION['status'];

  ?>
  <script>
    Swal.fire({
      icon: <?php echo json_encode($icon); ?>,
      title: <?php echo json_encode($title); ?>
    });
  </script>

<?php

  unset($_SESSION['status'], $_SESSION['status_code']);

}

?>