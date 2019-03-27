<?php
/**
 * Created by PhpStorm.
 * User: Juliens
 * Date: 5/7/2017
 * Time: 14:25
 */


$db2 = new mysqli('localhost', 'juliens_ilvermorny', 'juliohurtado1208', 'juliens_ilvermorny');

if ($db2->connect_error)
    die("Lo siento, no se ha podido establecer la conexion");