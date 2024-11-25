<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $nottitle = $_POST['nottitle'];
        $classid = $_POST['classid'];
        $notmsg = $_POST['notmsg'];
        $sql = "insert into tblnotice(NoticeTitle, ClassId, NoticeMsg) values(:nottitle, :classid, :notmsg)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':nottitle', $nottitle, PDO::PARAM_STR);
        $query->bindParam(':classid', $classid, PDO::PARAM_STR);
        $query->bindParam(':notmsg', $notmsg, PDO::PARAM_STR);
        $query->execute();
        $LastInsertId = $dbh->lastInsertId();
        if ($LastInsertId > 0) {
            echo '<script>alert("El aviso ha sido añadido.")</script>';
            echo "<script>window.location.href ='add-notice.php'</script>";
        } else {
            echo '<script>alert("Algo salió mal. Por favor, inténtelo de nuevo")</script>';
        }
    }
?>

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
                <h3 class="page-title">Agregar Aviso </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Tablero</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Agregar Aviso</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title" style="text-align: center;">Agregar Aviso</h4>

                            <form class="forms-sample" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label for="exampleInputName1">Título del Aviso</label>
                                    <input type="text" name="nottitle" value="" class="form-control" required='true'>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail3">Aviso Para</label>
                                    <select name="classid" class="form-control" required='true'>
                                        <option value="">Seleccionar Clase</option>
                                        <?php
                                        $sql2 = "SELECT * FROM tblclass";
                                        $query2 = $dbh->prepare($sql2);
                                        $query2->execute();
                                        $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                        foreach ($result2 as $row1) {
                                        ?>
                                            <option value="<?php echo htmlentities($row1->ID); ?>"><?php echo htmlentities($row1->ClassName); ?> <?php echo htmlentities($row1->Section); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName1">Mensaje del Aviso</label>
                                    <textarea name="notmsg" value="" class="form-control"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary mr-2" name="submit">Agregar</button>

                            </form>
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
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<?php } ?>
