<?php
/**
 * Created by PhpStorm.
 * User: Juliens
 * Date: 30-Aug-17
 * Time: 8:01 AM
 */

require ('acceso.php');

require('conexion.php');
require('forum-conexion.php');
require('reutilizar/fechas.php');

if($acceso){

    $query = sprintf("DELETE FROM mision WHERE id = '%s' LIMIT 1", $_POST['id']);
    $result = $db->query($query);

    echo sprintf("La misión fue eliminada correctamente");
}

