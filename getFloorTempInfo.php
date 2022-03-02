<?php

require_once 'src/FloorHeatingManager.php';

$floorHeatingManager = new FloorHeatingManager();

$data = $floorHeatingManager->getCurrentFloatingInfo();

header('Content-Type', 'application/json');
echo json_encode($data);

exit;