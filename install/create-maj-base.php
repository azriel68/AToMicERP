<?php
/*
 * Script créant et vérifiant que les champs requis s'ajoutent bien
 *
 */

require ('../inc.php');

$db = new TPDOdb;

TAtomic::createMajBase($db, $conf);