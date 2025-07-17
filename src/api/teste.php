<?php

$bdPresencas = new BdPresencas();

echo json_encode($bdPresencas->visitasDiarias(), true);
