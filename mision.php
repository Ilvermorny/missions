<?php
/**
 * Created by PhpStorm.
 * User: Juliens
 * Date: 8/23/2017
 * Time: 10:07 PM
 */
define('IN_MYBB', true);
require_once '../global.php';

require('acceso.php');

require('reutilizar/fechas.php');

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


    <script>
        function showPopUp(id_usuario) {

            $("#mostrarmodal").modal("show");
            $("#temporalID").html(id_usuario);
            $("#resultado").text("¿Está seguro que desea eliminar al usuario de la misión?")
            $(".borrarBoton").show();

        }

        function ejecutarAjax(id_usuario) {
            var parametros = {
                "id_usuario": id_usuario,
            };
            $.ajax({
                data: parametros, //datos que se envian a traves de ajax
                url: 'borrar-usuario.php', //archivo que recibe la peticion
                type: 'post', //método de envio
                success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    $("#resultado").text(response);
                    $("#fila-" + id_usuario).hide();
                    $(".borrarBoton").hide();
                }
            });
        }
    </script>


</head>

<body>

    <?php
    include('reutilizar/menu.php');
    ?>

    <div class="container">
        <br><br>
        <div class="panel panel-info">
            <div class="panel-heading">Detalle de la Misión</div>
            <div class="panel-body">
                <?php
                if (isset($_REQUEST['id']) and is_numeric($_REQUEST['id'])) {
                    //$query = sprintf("SELECT * FROM mision T1 INNER JOIN usersinmission T2 ON T1.id = T2.id_mission WHERE T1.id = '%s'",$_REQUEST['id']);
                    $id = $db->escape_string($_REQUEST['id']);
                    $result = $db->simple_select('mission', '*', "id=$id", array(
                        "limit" => 1
                    ));
                    $mision = $db->fetch_array($result);

                    if ($acceso) {
                        echo "<form action='editar-mision.php' method='post'>";
                        echo sprintf("<input type='hidden' value='%s' name='mision'>", $id);
                        echo "<button type='submit' type=\"button\" class=\"btn btn-sm btn-primary\">";
                        echo "<span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span> Editar Misión";
                        echo "</button>";
                        echo "</form><br>";
                    }
                    if ($mision['status'] == 1)
                        echo sprintf("<span class='label label-success'>Abierta</span> <b>Nombre de la Misión: </b>%s<br />", $mision['name']);
                    else if ($mision['status'] == 2)
                        echo sprintf("<span class='label label-danger'>Cerrada</span> <b>Nombre de la Misión: </b>%s<br />", $mision['name']);
                    echo sprintf("<b>Tipo: </b>%s <br />", $mision['type']);
                    echo sprintf("<b>Dificultad: </b>%s <br />", $mision['difficulty']);
                    echo sprintf("<b>Fecha de Inicio: </b>%s<br />", fecha($mision['init']));

                    if ($mision['status'] == 1)
                        echo sprintf("<b>Fecha de Finalización: </b>En curso<br />");
                    else if ($mision['status'] == 2 and $mision['end'] != '0000-00-00')
                        echo sprintf("<b>Fecha de Finalización: </b>%s<br />", fecha($mision['end']));
                    else echo "<b>Fecha de Finalización: </b>--<br />";

                    $resultadoTemp = $resultadoTemp = $db->simple_select("users", "*", "uid=" . $mision['user'], array(
                        "limit" => 1
                    ));
                    $arrayResulado = $db->fetch_array($resultadoTemp);
                    //echo $arrayResulado['username'];

                    echo sprintf("<b>Master de la misión: </b>%s<br />",  $arrayResulado['username']);
                    echo sprintf("<b>Ver en el  foro: </b><a href='%s' target='_blank'>%s</a><br />", $mision['link'], $mision['link']);
                    echo sprintf("<b>Descripción de la misión: </b><br><br><div class=\"well\">%s</div>", $mision['description']);
                    $result = $result = $db->simple_select('mission_users', '*', "id_mission=" . $_REQUEST['id'], array(
                        "order_by" => 'id_user'
                    ));
                }
                ?>
                <br>
                <?php
                if ($acceso) {
                    echo "<form action='agregar-usuario.php' method='post'>";
                    echo sprintf("<input type='hidden' name='mision_id' value='%s'>", $_REQUEST['id']);
                    echo "<button type=\"submit\" class=\"btn btn-sm btn-primary\">";
                    echo "<span class=\"glyphicon glyphicon-plus\" aria-hidden=\"true\"></span> Añadir Usuario";
                    echo "</button></form><br><br>";
                }
                ?>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Experiencia</th>
                                <th>Premios adicionales</th>
                                <?php if ($acceso) {; ?>
                                <th>Editar</th>
                                <th>Borrar</th>

                                <?php 
                            } ?>
                            </tr>
                        </thead>

                        <tbody>

                            <?php

                            if ($db->num_rows($result) > 0) {

                                while ($row = $db->fetch_array($result)) {
                                    echo sprintf("<tr id='fila-%s'>", $row['id_mission_users']);
                                    echo "<td>";
                                    $resultadoTemp = $db->simple_select("users", "*", "uid=" . $row['id_user'], array(
                                        "limit" => 1
                                    ));
                                    $arrayResulado = $db->fetch_array($resultadoTemp);
                                    $mostrarDueno = $arrayResulado['username'];
                                    echo $mostrarDueno;

                                    echo "</td>";

                                    echo "<td>";
                                    echo $row['experience'];
                                    echo "</td>";

                                    echo "<td>";
                                    echo $row['extraprize'];
                                    echo "</td>";


                                    if ($acceso) {
                                        echo "<td>";
                                        echo "<form action='editar-usuario.php' method='post'>";
                                        echo sprintf("<input type='hidden' name='id_mission_users' value='%s'>", $row['id_mission_users']);
                                        echo "<button type=\"submit\" class=\"btn btn-xs btn-primary\">";
                                        echo "<span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span> Editar";
                                        echo "</button></form>";

                                        echo "<td>";
                                        echo "<form action='borrar-usuario.php' method='post'>";
                                        echo sprintf("<input type='hidden' name='id_mission_users' value='%s' id='%s'>", $row['id_mission_users'], $row['id_mission_users']);
                                        //echo sprintf("), $row['']);
                                        ?>
                            <button type="button" href="javascript:;" class="btn btn-xs btn-danger" onclick="showPopUp(<?php echo $row['id_mission_users']; ?>)">
                                <?php
                                echo "<span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span> Borrar";
                                echo "</button></form>";
                            }
                            echo "</tr>";
                        }
                    }

                    if ($acceso) {
                        ?>
                                <div class="modal fade" id="mostrarmodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                    &times;
                                                </button>
                                                <h3>Eliminar Usuario de la Misión</h3>
                                            </div>
                                            <div class="modal-body">
                                                <h4 id="resultado">¿Está seguro que desea eliminar al usuario de la misión?</h4>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="#" data-dismiss="modal" class="btn btn-danger borrarBoton">Cancelar</a>
                                                <span style="display: none;" id="temporalID"></span>
                                                <button type="button" href="javascript:;" class="btn btn-default btn-primary borrarBoton" onclick="ejecutarAjax($('#temporalID').html())"> Borrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php

                            }
                            ?>
                        </tbody>

                    </table>


                </div>

            </div>
        </div>

    </div>
</body>

</html> 