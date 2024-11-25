<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
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
        <title>Ver Administrador</title>
        <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    </head>
    <body>
        <?php include_once('includes/header.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once('includes/sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Ver Administrador</h3>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Detalles del Administrador</h4>
                                    <?php if ($result) { ?>
                                    <div class="form-group">
                                        <label>Nombre del Administrador</label>
                                        <input type="text" value="<?php echo htmlentities($result->AdminName); ?>" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre de Usuario</label>
                                        <input type="text" value="<?php echo htmlentities($result->UserName); ?>" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Numero de Contacto</label>
                                        <input type="text" value="<?php echo htmlentities($result->MobileNumber); ?>" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Correo Electronico</label>
                                        <input type="email" value="<?php echo htmlentities($result->Email); ?>" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Fecha de Registro</label>
                                        <input type="text" value="<?php echo htmlentities($result->AdminRegdate); ?>" class="form-control" readonly>
                                    </div>
                                    <a href="profile.php" class="btn btn-primary mr-2">Regresar</a>
                                    <?php } ?>
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
