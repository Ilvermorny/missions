<?php
/**
 * Created by PhpStorm.
 * User: Juliens
 * Date: 8/23/2017
 * Time: 9:05 AM
 */
define('IN_MYBB', true);
require_once '../global.php';


require('acceso.php');

require('reutilizar/fechas.php');


$result = $db->simple_select("mission", "*", "status != 0", array(
    "order_by" => 'status'
));

$perpage = 20;

if (isset($_REQUEST["page"])) {
    if (is_string($_REQUEST["page"]))
        if (is_numeric($_REQUEST["page"]) and $_REQUEST['page'] > 0)
            $page = (int)$_REQUEST["page"];
        else
            $page = 1;
    else
        $page = 1;
} else {
    $page = 1;
}
$numberofresults = $db->num_rows($result);

$totalpages = ceil($numberofresults / $perpage);

if ($page > $totalpages)
    $page = $totalpages;

$start = ($page - 1) * $perpage;

$result = $db->simple_select("mission", "*", "status != 0", array(
    "limit" => "$start, $perpage",
    "order_by" => 'status'
));


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

    <script>
        function showPopUp(id) {

            $("#mostrarmodal").modal("show");
            $("#temporalID").html(id);
            $("#resultado").text("¿Está seguro que desea eliminar la misión?")
            $(".borrarBoton").show();

        }

        function ejecutarAjax(id) {
            var parametros = {
                "id": id,
            };
            $.ajax({
                data: parametros, //datos que se envian a traves de ajax
                url: 'borrar-mision.php', //archivo que recibe la peticion
                type: 'post', //método de envio
                success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    $("#resultado").text(response);
                    $("#fila-" + id).hide();
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
            <div class="panel-heading">Listado de Misiones</div>
            <div class="panel-body">

                <?php
                if ($acceso) {
                    echo "<a href=\"agregar-mision.php\" type=\"button\" class=\"btn btn-sm btn-primary\">";
                    echo "<span class=\"glyphicon glyphicon-plus\" aria-hidden=\"true\"></span> Agregar Misión";
                    echo "</a>";
                    echo "<br><br>";
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre de la Misión</th>
                                <th>Tipo de Misión</th>
                                <th>Dificultad</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Finalización</th>
                                <th>Master de la misión</th>
                                <?php
                                if ($acceso) {
                                    ?>
                                <th>Borrar</th>
                                <?php

                            }
                            ?>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $total = 0;
                            if ($numberofresults != 0) {
                                while ($row = $db->fetch_array($result)) {
                                    echo sprintf("<tr id='fila-%s'>", $row['id']);
                                    echo "<td>";

                                    if ($row['status'] == 1)
                                        echo sprintf("<span class='label label-success'>Abierta</span> <a href='mision.php?id=%s'>%s</a>", $row['id'], $row['name']);
                                    elseif ($row['status'] == 2)
                                        echo sprintf("<span class='label label-danger'>Cerrada</span> <a href='mision.php?id=%s'>%s</a>", $row['id'], $row['name']);

                                    echo "</td>";
                                    echo sprintf("<td>%s</td>", $row['type']);
                                    echo sprintf("<td>%s</td>", $row['difficulty']);

                                    echo "<td>";
                                    echo fecha($row['init']);
                                    echo "</td>";

                                    echo "<td>";

                                    if ($row['status'] == 1)
                                        echo sprintf("En curso");
                                    else if ($row['status'] == 2 and $row['end'] != '0000-00-00')
                                        echo sprintf("%s", fecha($row['end']));
                                    else
                                        echo "--";

                                    echo "</td>";

                                    echo "<td>";

                                    $resultadoTemp = $db->simple_select("users", "*", "uid=" . $row['user'], array(
                                        "limit" => 1
                                    ));
                                    $arrayResulado = $db->fetch_array($resultadoTemp);
                                    echo $arrayResulado['username'];
                                    echo "</td>";
                                    echo sprintf("<input type='hidden' name='id_usermission' value='%s' id='%s'>", $row['id'], $row['id']);
                                    if ($acceso) {
                                        ?>
                            <td>
                                <button type="button" href="javascript:;" class="btn btn-xs btn-danger" onclick="showPopUp(<?php echo $row['id']; ?>)">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Borrar
                                </button>
                            </td>


                            <?php

                        }
                        echo "</tr>";
                    }
                }


                ?>

                        </tbody>

                    </table>

                    <nav aria-label="Page navigation">
                        <ul class="pagination">


                            <?php

                            if ($page == 1)
                                $previous = "<li class = 'disabled'><a href='#' aria-label='Anterior'><span aria-hidden='true'>&laquo;</span></a></li>";
                            else
                                $previous = sprintf("<li><a href='index.php?page=%d' aria-label='Anterior'><span aria-hidden='true'>&laquo;</span></a></li>", $page - 1);


                            echo $previous;
                            for ($i = 1; $i <= $totalpages; $i++) {
                                if ($i == $page)
                                    $status = 'active';
                                else
                                    $status = '';

                                $link = sprintf("<li class = '%s'><a href='index.php?page=%d'>%d</a></li>", $status, $i, $i);
                                echo $link;
                            }


                            if ($page == $totalpages)
                                $next = "<li class = 'disabled'><a href='#' aria-label='Siguiente'><span aria-hidden='true'>&raquo;</span></a></li>";
                            else
                                $next = sprintf("<li><a href='index.php?page=%d' aria-label='Siguiente'><span aria-hidden='true'>&raquo;</span></a></li>", $page + 1);

                            echo $next;

                            ?>
                        </ul>
                    </nav>

                    <?php
                    if ($acceso) {
                        ?>

                    <div class="modal fade" id="mostrarmodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h3>Eliminar Misión</h3>
                                </div>
                                <div class="modal-body">
                                    <h4 id="resultado">¿Está seguro que desea eliminar la misión?</h4>
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



                </div>

            </div>
        </div>

    </div>
</body>

</html> 