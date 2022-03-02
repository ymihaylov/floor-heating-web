<?php

require_once 'src/FloorHeatingManager.php';

$newTemps = $_POST;

$floorHeatingManager = new FloorHeatingManager();
$floorHeatingManager->setFloorTemp($newTemps);

header('Content-Type', 'application/json');
echo json_encode(['status' => 1]);

exit;