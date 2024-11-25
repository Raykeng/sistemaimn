<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
} else {
  if(isset($_POST['submit'])) {
    $AName = $_POST['adminname'];
    $mobno = $_POST['mobilenumber'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = hash('sha512', $_POST['password']); // Encriptar la contraseña con SHA-512
    
    $sql = "INSERT INTO tbladmin (AdminName, UserName, MobileNumber, Email, Password) VALUES (:adminname, :username, :mobilenumber, :email, :password)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':adminname', $AName, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobilenumber', $mobno, PDO::PARAM_STR);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();

    echo '<script>alert("New admin has been added successfully")</script>';
    echo "<script>window.location.href ='new-admin.php'</script>";
  }
?>



<!-- partial:partials/_navbar.html -->
<?php include_once('includes/header.php');?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <!-- partial:partials/_sidebar.html -->
  <?php include_once('includes/sidebar.php');?>
  <!-- partial -->
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> New Admin </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">New Admin</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title" style="text-align: center;">Add New Admin</h4>
              <form class="forms-sample" method="post">
                <div class="form-group">
                  <label for="exampleInputName1">Admin Name</label>
                  <input type="text" name="adminname" class="form-control" required='true'>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">User Name</label>
                  <input type="text" name="username" class="form-control" required='true'>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword4">Contact Number</label>
                  <input type="text" name="mobilenumber" class="form-control" maxlength='10' required='true' pattern="[0-9]+">
                </div>
                <div class="form-group">
                  <label for="exampleInputCity1">Email</label>
                  <input type="email" name="email" class="form-control" required='true'>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" name="password" class="form-control" required='true'>
                </div>
                <button type="submit" class="btn btn-primary mr-2" name="submit">Add Admin</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <?php include_once('includes/footer.php');?>
    <!-- partial -->
  </div>
  <!-- main-panel ends -->
</div>
<!-- Orginal Author Name: CompuBinario.K. 
for any PHP, Codeignitor, Laravel OR Python work contact me at mdkhairnar92@gmail.com  
Visit website : https://CompuBinariok.com -->
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="js/off-canvas.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- endinject -->
</body>
</html>
<?php } ?>
