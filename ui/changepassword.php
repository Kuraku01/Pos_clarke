<?php

include_once "connectdb.php";
session_start();

if ($_SESSION['useremail']=="") {

  header('location:../index.php');
  
}

if ($_SESSION['role']=="Admin") {

  include_once "header.php";  

} elseif ($_SESSION['role']=="User") {

  include_once "userheader.php";

}



if (isset($_POST['updatepassword'])) {
    
    $old_password=$_POST['oldpassword'];
    $new_password=$_POST['newpassword'];
    $r_new_password=$_POST['rnewpassword'];

    $email = $_SESSION['useremail'];

    $select = $pdo->prepare("select * from user_tbl where useremail='$email'");
    $select = $pdo->prepare("select * from register_tbl where useremail='$email'");

    $select->execute();
    $row=$select->fetch(PDO::FETCH_ASSOC);

    $useremail_db = $row['useremail'];
    $password_db = $row['userpassword'];

    
    if ($old_password== $password_db) {       

      if ($new_password== $r_new_password) {

        $update=$pdo->prepare("update user_tbl set userpassword=:pass where useremail=:email");
        $update=$pdo->prepare("update register_tbl set userpassword=:pass where useremail=:email");

        $update->bindParam(':pass', $r_new_password);
        $update->bindParam(':email', $email);

        if ($update->execute()) {
          $_SESSION['status']="Changed Password Successfully";
          $_SESSION['status_code']="success";

        } else {
          $_SESSION['status']="Password failed to update";
          $_SESSION['status_code']="error";
        }

      } else {
      $_SESSION['status']="New Password don't match";
      $_SESSION['status_code']="error";
      }

    } else {
      $_SESSION['status']="Password don't match";
      $_SESSION['status_code']="error";
    }

}

?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Change Password</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
          <!--<li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>-->
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">

            <!-- Horizontal Form -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Input Credentials</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post">
                <div class="card-body">

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label"> Old Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword3" placeholder="Old Password" name="oldpassword" >
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label"> New Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword3" placeholder="New Password" name="newpassword" >
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label"> Repeat New Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword3" placeholder="Repeat New Password" name="rnewpassword" >
                    </div>
                  </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="updatepassword" >Update Password</button>
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php

include_once "footer.php";

?>

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
