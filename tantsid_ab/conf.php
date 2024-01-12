<?php
$kasutaja='d123173_maksdot';
$serverinimi='localhost';
//$serverinimi='d123173.mysql.zonevs.eu';
$parool='Tark123456';
$andmebaas='d123173_tantsid';
$yhendus=NEW mysqli($serverinimi,$kasutaja,$parool,$andmebaas);
$yhendus->set_charset('UTF8');

