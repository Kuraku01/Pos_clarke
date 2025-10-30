<?php

include_once "connectdb.php";
session_start();

error_reporting(0);

$id = $_GET['id'];
if (isset($id)) {

  $delete = $pdo->prepare("delete from register_tbl where userid=" . $id);

  if ($delete->execute()) {

    $_SESSION['status'] = "Account Deleted";
    $_SESSION['status_code'] = "success";

  } else {

    $_SESSION['status'] = "Account Deletion Failed";
    $_SESSION['status_code'] = "error";

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
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User List</h1>
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
    <div class="col-md-8">
              <table class="table table-stripped table-hover">
                <thead>
                  <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>Gender</td>
                    <td>Email</td>
                    <td>Role</td>
                    <td>Delete</td>
                  </tr>
                </thead>

                <tbody>

                  <?php

                  $select = $pdo->prepare("select * from register_tbl order by userid asc");
                  $select->execute();

                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                    echo '
                    <tr>
                    <td>' . $row->userid . '</td>
                    <td>' . $row->username . '</td>

                    <td>' . $row->useremail . '</td>
                    <td>' . $row->role . '</td>
                    <td>
                    
                    <a href="memberlist.php?id='.$row->userid.'" class="btn btn-danger"><i class="fa fa-trash-alt"></i></a>

                    </td>
                    </tr>

                    
                    ';
                  }



                  ?>

                </tbody>

              </table>
            </div>
    </div>

<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>
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