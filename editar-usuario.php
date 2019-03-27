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
        <div class="panel-heading">Agregar Misión</div>
        <div class="panel-body">
            <?php

            if(isset($_POST['id_user_mision_save'])){

                $id_user_mision_save = mysqli_real_escape_string($db, $_POST['id_user_mision_save']);
                $experience = mysqli_real_escape_string($db, $_POST['experience']);
                $extraprize = mysqli_real_escape_string($db, $_POST['extraprize']);

                $query = sprintf("UPDATE usersinmission SET experience = '%s', extraprize = '%s' WHERE id_usermission = '%s'", $experience, $extraprize, $id_user_mision_save);
                $db->query($query);

                header('Location: mision.php?id='.$_POST['id_mision']);
            }


            //$query = sprintf("SELECT * FROM mision WHERE id = '%s' LIMIT 1", $_POST['mision']);
            //$result = $db->query($query);
            //$mision = mysqli_fetch_array($result);
            ?>
            <?php
            if (isset($_POST['id_usermission'])){
                $id_usermission = mysqli_real_escape_string($db, $_POST['id_usermission']);
                $query = sprintf("SELECT * FROM usersinmission WHERE id_usermission = '%s' LIMIT 1", $id_usermission);
                $result = $db->query($query);
                $user_mision = mysqli_fetch_array($result);

                $tmpquery = sprintf("SELECT * FROM mybb_users WHERE uid = '%s' LIMIT 1", $user_mision['id_user']);
                $resultadoTemp = $db2->query($tmpquery);
                $arrayResulado = mysqli_fetch_array($resultadoTemp);
                $mostrarDueno = $arrayResulado['username'];

                ?>
                <form class="form-horizontal" role="form" method="post">
                    <input type="hidden" name="id_user_mision_save"  value="<?php echo $user_mision['id_usermission'];?>">
                    <input type="hidden" name="id_mision"  value="<?php echo $user_mision['id_mission'];?>">

                    <div class="form-group">
                        <label for="user" class="col-lg-2 control-label">Usuario</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="user" disabled value="<?php echo $arrayResulado['username'];?>">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="experience" class="col-lg-2 control-label">Experiencia Ganada</label>
                        <div class="col-lg-10">
                            <input type="number" class="form-control" name="experience" placeholder="Puntos de Experiencia Ganados" value="<?php echo $user_mision['experience']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="extraprize" class="col-lg-2 control-label">Premios Adicionales</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="10" name="extraprize"><?php echo $user_mision['extraprize']; ?></textarea>
                        </div>
                    </div>
                    <button type='submit' class="btn btn-default btn-primary btn-block">Guardar
                    </button><br>

                    <a href="mision.php?id=<?php echo $user_mision['id_mission']; ?>" type="button" class="btn btn-default btn-danger btn-block">Cancelar
                    </a><br>


                </form>

                <?php
            }
            ?>




        </div>
    </div>

</div>
</body>
</html>