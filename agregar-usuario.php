<?php
/**
 * Created by PhpStorm.
 * User: Juliens
 * Date: 27-Aug-17
 * Time: 9:04 AM
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
    <title>Agregar Misión - Ilvermorny.es</title>
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
        <div class="panel-heading">Agregar Participante</div>
        <div class="panel-body">
            <?php

            if(isset($_POST['id_mision'])){

                $user = mysqli_real_escape_string($db, $_POST['user']);
                $experience = mysqli_real_escape_string($db, $_POST['experience']);
                $extraprize = mysqli_real_escape_string($db, $_POST['extraprize']);
                $id_mission = mysqli_real_escape_string($db, $_POST['id_mision']);

                $query = sprintf("INSERT INTO usersinmission (id_user, id_mission, experience, extraprize) VALUES ('%s', '%s', '%s', '%s')", $user, $id_mission, $experience, $extraprize);
                $db->query($query);
                header('Location: mision.php?id='.$id_mission);
            }


            //$query = sprintf("SELECT * FROM mision WHERE id = '%s' LIMIT 1", $_POST['mision']);
            //$result = $db->query($query);
            //$mision = mysqli_fetch_array($result);
            ?>
            <?php
            if (isset($_POST['mision_id'])){
            ?>
                <form class="form-horizontal" role="form" method="post">
                    <input type="hidden" name="id_mision"  value="<?php echo $_POST['mision_id'];?>">

                    <div class="form-group">
                        <label for="user" class="col-lg-2 control-label">Usuario</label>
                        <div class="col-lg-10">
                            <input type="number" class="form-control" name="user" placeholder="ID de usuario del foro" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="experience" class="col-lg-2 control-label">Experiencia Ganada</label>
                        <div class="col-lg-10">
                            <input type="number" class="form-control" name="experience" placeholder="Puntos de Experiencia Ganados">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="extraprize" class="col-lg-2 control-label">Premios Adicionales</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="10" name="extraprize"></textarea>
                        </div>
                    </div>
                    <button type='submit' type="button" class="btn btn-default btn-primary btn-block">Guardar
                    </button><br>
                </form>

            <?php
            }
            ?>




        </div>
    </div>

</div>
</body>
</html>