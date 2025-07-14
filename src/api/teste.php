<?php

$bdLogins = new BdLogins();
$bdLogins->createTable();

$bdLogbd = new BdLogDb();
$bdLogbd->createTable();

$bdMidias = new BdMidias();
$bdMidias->createTable();

$bdPresencas = new BdPresencas();
$bdPresencas->createTable();

$bdVisitantes = new BdVisitantes();
$bdVisitantes->createTable();