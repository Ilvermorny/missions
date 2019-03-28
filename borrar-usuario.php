<?php
/**
 * Created by PhpStorm.
 * User: Juliens
 * Date: 30-Aug-17
 * Time: 8:01 AM
 */
define('IN_MYBB', true);
require_once '../global.php';
require('acceso.php');

require('reutilizar/fechas.php');

if ($acceso) {
    $id_mission_users = $db->escape_string($_POST['id_usuario']);


    $db->delete_query("mission_users", "id_mission_users= $id_mission_users", 1);

    echo sprintf("El usuario fue eliminado correctamente de la misión");
}
