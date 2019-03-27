<?php
/**
 * Created by PhpStorm.
 * User: Juliens
 * Date: 8/23/2017
 * Time: 9:42 AM
 */

session_start();
require('autenticacion/loggedin.php');
require ('conexion.php');
//require ('forum-conexion.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Misiones - Ilvermorny.es</title>
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
        <div class="panel-heading">Iniciar Sesión</div>
        <div class="panel-body">
            <form class="form-horizontal" action="autenticacion/login.php" method="post">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Usuario</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="user" id="inputEmail3"
                               placeholder="Usuario" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Contraseña</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" id="inputPassword3"
                               placeholder="Password" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Iniciar Sesión</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
</body>
</html>