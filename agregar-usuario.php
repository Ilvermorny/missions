<?php
/**
 * Created by PhpStorm.
 * User: Juliens
 * Date: 27-Aug-17
 * Time: 9:04 AM
 */
define('IN_MYBB', true);
require_once '../global.php';

require('acceso.php');

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
            <div class="panel-heading">Agregar Participante</div>
            <div class="panel-body">
                <?php

                if (isset($_POST['id_mision'])) {

                    $user = $db->escape_string($_POST['user']);
                    $experience = intval($db->escape_string($_POST['experience']));
                    $extraprize = $db->escape_string($_POST['extraprize']);
                    $id_mission = $db->escape_string($_POST['id_mision']);

                    $db->insert_query('mission_users', array(
                        'id_user' => $user,
                        'id_mission' => $id_mission,
                        'experience' => $experience,
                        'extraprize' => $extraprize,
                    ));
                    header('Location: mision.php?id=' . $id_mission);
                }

                ?>
                <?php
                if (isset($_POST['mision_id'])) {
                    ?>
                <form class="form-horizontal" role="form" method="post">
                    <input type="hidden" name="id_mision" value="<?php echo $_POST['mision_id']; ?>">

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