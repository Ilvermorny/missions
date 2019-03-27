<?php
/**
 * Created by PhpStorm.
 * User: Juliens
 * Date: 10/7/2017
 * Time: 12:57
 */

function fecha( $fecha){

    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
    $date = date('jS \d\e F Y h:i:s A',strtotime(str_replace('-','/', $fecha)));
    $date = strtotime(str_replace('-','/', $fecha));
    return date('d', $date)." ".$meses[date('n',$date)-1]. " ".date('Y',$date);

}