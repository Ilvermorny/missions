<?php
/**
 * Created by PhpStorm.
 * User: Juliens
 * Date: 8/25/2017
 * Time: 11:29 AM
 */

require('acceso.php');

require('conexion.php');
require('forum-conexion.php');
require('reutilizar/fechas.php');

if (!$acceso) {
    header('Location: error.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar Misión - Ilvermorny.es</title>
    <?php
    include('reutilizar/js.php');
    ?>
    <link href="css/starter-template.css" rel="stylesheet">

</head>

<body>

    <?php
    include('reutilizar/menu.php');
    ?>

    <div class="container">
        <br><br>
        <div class="panel panel-info">
            <div class="panel-heading">Agregar Misión</div>
            <div class="panel-body">
                <?php

                if (isset($_POST['user'])) {

                    $user = mysqli_real_escape_string($db, $_POST['user']);
                    $name = mysqli_real_escape_string($db, $_POST['name']);
                    $type = mysqli_real_escape_string($db, $_POST['type']);
                    $init = mysqli_real_escape_string($db, $_POST['init']);
                    $end = mysqli_real_escape_string($db, $_POST['end']);
                    $creator = mysqli_real_escape_string($db, $_POST['user']);
                    $link = mysqli_real_escape_string($db, $_POST['link']);
                    $description = mysqli_real_escape_string($db, $_POST['description']);

                    $query = sprintf("INSERT INTO mision (name, type, description, link, init, end, user) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')", $name, $type, $description, $link, $init, $end, $user);
                    $result = $db->query($query);
                    header('Location: mision.php?id=' . mysqli_insert_id($db));
                }

                ?>

                <form class="form-horizontal" role="form" method="post">
                    <div class="form-group">
                        <label for="name" class="col-lg-2 control-label">Nombre de la Misión</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="name" placeholder="Nombre de la Misión" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="type" class="col-lg-2 control-label">Tipo de Misión</label>
                        <div class="col-lg-10">
                            <select class="form-control" name="type">
                                <option value="Normal">Normal</option>
                                <option value="Bando">Bando</option>
                                <option value="Cadena">Cadena</option>
                                <option value="Restringida">Restringida</option>
                                <option value="Limite de Tiempo">Limite de Tiempo</option>
                            </select>
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="init" class="col-lg-2 control-label">Fecha de Inicio</label>
                        <div class="col-lg-10">
                            <input type="date" class="form-control" name="init" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="end" class="col-lg-2 control-label">Fecha de Finalización</label>
                        <div class="col-lg-10">
                            <input type="date" class="form-control" name="end">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="user" class="col-lg-2 control-label">Master de la Misión</label>
                        <div class="col-lg-10">
                            <input type="number" class="form-control" name="user" placeholder="ID de usuario del foro" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="link" class="col-lg-2 control-label">Link a la Misión</label>
                        <div class="col-lg-10">
                            <input type="url" class="form-control" name="link" placeholder="Enlace del post del foro" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-lg-2 control-label">Descripción</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="10" name="description" required></textarea>
                        </div>
                    </div>

                    <?php

                    if ($acceso) {
                        //echo "<form action='editar-mision.php' method='post'>";
                        //echo sprintf("<input type='hidden' value='%s' name='mision'>", $_POST['mision']);
                        echo "<button type='submit' type=\"button\" class=\"btn btn-default btn-primary btn-block\">";
                        echo "Guardar";
                        echo "</button>";
                        echo "<br>";
                    }




                    ?>

                </form>



            </div>
        </div>

    </div>
</body>

</html> 