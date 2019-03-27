<?php
/**
 * Created by PhpStorm.
 * User: Juliens
 * Date: 23/6/2017
 * Time: 12:54
 */

$db = new mysqli('localhost', 'juliens_harrypotter', 'Q@kn}k51', 'juliens_mision');

if ($db->connect_error)
    die("Lo siento, no se ha podido establecer la conexion");

