<?php
/**
 * Created by PhpStorm.
 * User: Juliens
 * Date: 8/25/2017
 * Time: 11:29 AM
 */

require ('acceso.php');

require('conexion.php');
require('forum-conexion.php');
require('reutilizar/fechas.php');

if (!$acceso){
    header('Location: error.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalle de Misión - Ilvermorny.es</title>
    <?php
    include('reutilizar/js.php');
    ?>
    <link href="css/starter-template.css" rel="stylesheet">

</head>

<body>

<?php
include ('reutilizar/menu.php');
?>

<div class="container">
    <br><br>
    <div class="panel panel-info">
        <div class="panel-heading">Editar de la Misión</div>
        <div class="panel-body">
            <?php

            if(isset($_POST['save'])){
                $id = mysqli_real_escape_string($db, $_POST['save']);
                $name = mysqli_real_escape_string($db, $_POST['name']);
                $init = mysqli_real_escape_string($db, $_POST['init']);
                $end = mysqli_real_escape_string($db, $_POST['end']);
                $creator = mysqli_real_escape_string($db, $_POST['user']);
                $link = mysqli_real_escape_string($db, $_POST['link']);
                $description = mysqli_real_escape_string($db, $_POST['description']);
                $status = mysqli_real_escape_string($db, $_POST['status']);
                $type = mysqli_real_escape_string($db, $_POST['type']);
                $difficulty = mysqli_real_escape_string($db, $_POST['difficulty']);

                $query = sprintf("UPDATE mision SET name = '%s', type = '%s', difficulty = '%s', init = '%s', end = '%s', link = '%s', description = '%s', status = '%s' WHERE id = '%s'",$name, $type, $difficulty, $init, $end, $link, $description, $status, $id);
                $db->query($query);
                header('Location: mision.php?id='.$id);
            }

            if (isset($_POST['mision'])) {
                //$query = sprintf("SELECT * FROM mision T1 INNER JOIN usersinmission T2 ON T1.id = T2.id_mission WHERE T1.id = '%s'",$_REQUEST['id']);
                $query = sprintf("SELECT * FROM mision WHERE id = '%s' LIMIT 1", $_POST['mision']);
                $result = $db->query($query);
                $mision = mysqli_fetch_array($result);
            ?>
                <form class="form-horizontal" role="form" method="post">
                    <input type="hidden" name="save" value="<?php echo $_POST['mision']; ?>">
                    <div class="form-group">
                        <label for="name" class="col-lg-2 control-label">Nombre</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="name" value="<?php echo $mision['name'];?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type" class="col-lg-2 control-label">Tipo de Misión</label>
                        <div class="col-lg-10">
                            <select class="form-control" name="type">
                                <option value="Normal" <?php if ($mision['type'] == 'Normal') echo "selected";?>>Normal</option>
                                <option value="Bando" <?php if ($mision['type'] == 'Bando') echo "selected";?>>Bando</option>
                                <option value="Cadena" <?php if ($mision['type'] == 'Cadena') echo "selected";?>>Cadena</option>
                                <option value="Restringida" <?php if ($mision['type'] == 'Restringida') echo "selected";?>>Restringida</option>
                                <option value="Limite de Tiempo" <?php if ($mision['type'] == 'Limite de Tiempo') echo "selected";?>>Limite de Tiempo</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="difficulty" class="col-lg-2 control-label">Dificultad</label>
                        <div class="col-lg-10">
                            <select class="form-control" name="difficulty">
                                <option value="A" <?php if ($mision['difficulty'] == 'A') echo "selected";?>>A</option>
                                <option value="AA" <?php if ($mision['difficulty'] == 'AA') echo "selected";?>>AA</option>
                                <option value="AAA" <?php if ($mision['difficulty'] == 'AAA') echo "selected";?>>AAA</option>
                                <option value="Especial" <?php if ($mision['difficulty'] == 'Especial') echo "selected";?>>Especial</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="init" class="col-lg-2 control-label">Fecha de Inicio</label>
                        <div class="col-lg-10">
                            <input type="date" class="form-control" name="init" value="<?php echo $mision['init'];?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="end" class="col-lg-2 control-label">Fecha de Finalización</label>
                        <div class="col-lg-10">
                            <input type="date" class="form-control" name="end" value="<?php echo $mision['end'];?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="col-lg-2 control-label">Estado de la Misión</label>
                        <div class="col-lg-10">
                            <select class="form-control" name="status">
                                <option value="1" <?php if ($mision['status'] == 1) echo "selected";?>>Abierta</option>
                                <option value="2" <?php if ($mision['status'] == 2) echo "selected";?>>Cerrada</option>
                            </select>
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="user" class="col-lg-2 control-label">Master de la Misión</label>
                        <div class="col-lg-10">
                            <?php
                            $query_user = sprintf("SELECT * from mybb_users WHERE uid = '%s' LIMIT 1", $mision['user']);
                            $resultuser = $db2->query($query_user);
                            $user = mysqli_fetch_array($resultuser);
                            ?>
                            <input type="text" class="form-control" name="user" value="<?php echo $user['username'];?>" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="link" class="col-lg-2 control-label">Link a la Misión</label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <a href="<?php echo $mision['link'];?>" type="button" class="btn btn-default" aria-haspopup="true" aria-expanded="false" target="_blank">Ver</a>
                                </div>
                                <input type="url" class="form-control" name="link" value="<?php echo $mision['link'];?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-lg-2 control-label">Descripción</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="10" name="description" required><?php echo $mision['description'];?></textarea>
                        </div>
                    </div>

                    <?php

                        if ($mybb->usergroup['cancp'])
                        {
                            //echo "<form action='editar-mision.php' method='post'>";
                            echo sprintf("<input type='hidden' value='%s' name='mision'>", $_POST['mision']);
                            echo "<button type='submit' type=\"button\" class=\"btn btn-default btn-primary btn-block\">";
                            echo "Guardar";
                            echo "</button>";
                            echo "<br>";
                        }

                        echo sprintf("<a href='mision.php?id=%s' type=\"button\" class=\"btn btn-default btn-danger btn-block\">", $_POST['mision']);
                        echo "Cancelar";
                        echo "</a>";
                        echo "<br>";
                    }



                    ?>

                </form>



        </div>
    </div>

</div>
</body>
</html>