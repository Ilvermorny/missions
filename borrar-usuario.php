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
    $query = sprintf("SELECT * FROM usersinmission WHERE id_usermission = '%s' LIMIT 1", $_POST['id_usuario']);
    $result = $db->query($query);
    $mision = mysqli_fetch_array($result);


    $tmpquery = sprintf("SELECT * FROM mybb_users WHERE uid = '%s'", $mision['id_user']);
    $resultadoTemp = $db2->query($tmpquery);
    $arrayResulado = mysqli_fetch_array($resultadoTemp);
    $mostrarDueno = $arrayResulado['username'];


    $query = sprintf("DELETE FROM usersinmission WHERE id_usermission = '%s' LIMIT 1", $_POST['id_usuario']);
    $result = $db->query($query);

    echo sprintf("El usuario %s fue eliminado correctamente de la misión", $mostrarDueno);
}

