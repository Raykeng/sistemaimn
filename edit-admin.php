<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $adminid = $_GET['adminid'];
        $AName = $_POST['adminname'];
        $mobno = $_POST['mobilenumber'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = hash('sha512', $_POST['password']);
        
        $sql = "UPDATE tbladmin SET AdminName=:adminname, MobileNumber=:mobilenumber, Email=:email, UserName=:username, Password=:password WHERE ID=:aid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':adminname', $AName, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobilenumber', $mobno, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':aid', $adminid, PDO::PARAM_STR);
        $query->execute();

        echo '<script>alert("Admin profile has been updated")</script>';
        echo "<script>window.location.href ='profile.php'</script>";
    }

    if (isset($_GET['adminid'])) {
        $adminid = $_GET['adminid'];
        $sql = "SELECT * FROM tbladmin WHERE ID=:aid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':aid', $adminid, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
</head>
<body>
    <?php include_once('includes/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('includes/sidebar.php'); ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">Editar Administrador</h3>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Editar Informacion del Administrador</h4>
                                <form class="forms-sample" method="post">
                                    <?php if ($result) { ?>
                                    <div class="form-group">
                                        <label>Nombre del Administrador</label>
                                        <input type="text" name="adminname" value="<?php echo htmlentities($result->AdminName); ?>" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre de Usuario</label>
                                        <input type="text" name="username" value="<?php echo htmlentities($result->UserName); ?>" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Numero de Contacto</label>
                                        <input type="text" name="mobilenumber" value="<?php echo htmlentities($result->MobileNumber); ?>" class="form-control" maxlength='10' required pattern="[0-9]+">
                                    </div>
                                    <div class="form-group">
                                        <label>Correo Electronico</label>
                                        <input type="email" name="email" value="<?php echo htmlentities($result->Email); ?>" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Contraseña</label>
                                        <input type="password" name="password" value="" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2" name="submit">Actualizar</button>
                                    <a href="profile.php" class="btn btn-primary mr-2">Regresar</a>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
</body>
</html>
<?php } ?>
