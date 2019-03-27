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
    $id = $db->escape_string($_POST['id']);
    $db->delete_query("mission", "id=$id", 1);

    echo sprintf("La misión fue eliminada correctamente");
}
