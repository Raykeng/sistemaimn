<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $adminid = $_SESSION['sturecmsaid'];
        $AName = $_POST['adminname'];
        $mobno = $_POST['mobilenumber'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = hash('sha512', $_POST['password']); // Encriptar la contraseña con SHA-512
        
        $sql = "UPDATE tbladmin SET AdminName=:adminname, MobileNumber=:mobilenumber, Email=:email, UserName=:username, Password=:password WHERE ID=:aid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':adminname', $AName, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobilenumber', $mobno, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':aid', $adminid, PDO::PARAM_STR);
        $query->execute();

        echo '<script>alert("Your profile has been updated")</script>';
        echo "<script>window.location.href ='profile.php'</script>";
    }

    if (isset($_GET['delid'])) {
        $adminid = $_GET['delid'];
        $sql = "DELETE FROM tbladmin WHERE ID=:aid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':aid', $adminid, PDO::PARAM_STR);
        $query->execute();

        echo '<script>alert("Admin deleted successfully")</script>';
        echo "<script>window.location.href ='profile.php'</script>";
    }
?>

<!-- El resto del código HTML -->



<!-- partial:partials/_navbar.html -->
<?php include_once('includes/header.php'); ?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <?php include_once('includes/sidebar.php'); ?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">Perfil del Administrador</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Estadisticas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Perfil del Administrador</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title" style="text-align: center;">Editar Información</h4>
                            <form class="forms-sample" method="post">
                                <?php
                                $adminid = $_SESSION['sturecmsaid'];
                                $sql = "SELECT * FROM tbladmin WHERE ID=:aid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':aid', $adminid, PDO::PARAM_STR);
                                $query->execute();
                                $result = $query->fetch(PDO::FETCH_OBJ);

                                if ($result) {
                                ?>
                                <div class="form-group">
                                    <label for="exampleInputName1">Nombre del Administrador</label>
                                    <input type="text" name="adminname" value="<?php echo htmlentities($result->AdminName); ?>" class="form-control" required='true'>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Nombre de Usuario</label>
                                    <input type="text" name="username" value="<?php echo htmlentities($result->UserName); ?>" class="form-control" required='true'>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword4">Numero de Contacto</label>
                                    <input type="text" name="mobilenumber" value="<?php echo htmlentities($result->MobileNumber); ?>" class="form-control" maxlength='10' required='true' pattern="[0-9]+">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputCity1">Correo Electronico</label>
                                    <input type="email" name="email" value="<?php echo htmlentities($result->Email); ?>" class="form-control" required='true'>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Contraseña</label>
                                    <input type="password" name="password" value="<?php echo htmlentities($result->Password); ?>" class="form-control" required='true'>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputCity1">Fecha de Registro</label>
                                    <input type="text" name="" value="<?php echo htmlentities($result->AdminRegdate); ?>" readonly="" class="form-control">
                                </div>
                                <?php } ?>
                                <button type="submit" class="btn btn-primary mr-2" name="submit">Actualizar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de otros administradores -->
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title" style="text-align: center;">Otros Administradores</h4>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre del Administrador</th>
                                        <th>Nombre de Usuario</th>
                                        <th>Correo Electronico</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM tbladmin WHERE ID!=:aid";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':aid', $adminid, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;

                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($row->AdminName); ?></td>
                                        <td><?php echo htmlentities($row->UserName); ?></td>
                                        <td><?php echo htmlentities($row->Email); ?></td>
                                        <td>
                                            <a href="view-admin.php?adminid=<?php echo htmlentities($row->ID); ?>" class="btn btn-info">Ver</a>
                                            <a href="edit-admin.php?adminid=<?php echo htmlentities($row->ID); ?>" class="btn btn-primary">Editar</a>
                                            <a href="profile.php?delid=<?php echo htmlentities($row->ID); ?>" class="btn btn-danger" onclick="return confirm('Do you really want to delete this admin?');">Eliminar</a>
                                        </td>
                                    </tr>
                                    <?php
                                        $cnt++;
                                        }
                                    } else {
                                    ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center;">No se econtro información del administrador.</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php include_once('includes/footer.php'); ?>
        <!-- partial -->
    </div>
    <!-- main-panel ends -->
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