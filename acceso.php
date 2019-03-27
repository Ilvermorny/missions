<?php
/**
 * Created by PhpStorm.
 * User: Juliens
 * Date: 27-Aug-17
 * Time: 11:03 PM
 */

define('IN_MYBB', true);
//define('MYBB_LOCATION', 'Inferno Shoutbox');

require_once '../global.php';

if ($mybb->usergroup['cancp'] == 1)
    $acceso = True;
else
    $acceso = False;