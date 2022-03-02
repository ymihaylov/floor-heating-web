<?php

class FloorHeatingManager
{
    private $config;

    public function __construct()
    {
        $this->config = require_once 'config.php';
    }

    public function getCurrentFloatingInfo()
    {
        $setFileRows = file($this->config['ROOM_SET_FILE_PATH']);

        $roomInfo = [];
        foreach ($setFileRows as $row) {
            $rowData = explode(' ', $row);
            $roomId = $rowData[0];
            $floorTempSet = $this->formatTemp($rowData[1]);

            $roomInfo[$roomId] = $this->initRoomInfoRow($roomId);
            $roomInfo[$roomId]['name'] = $this->config['ROOM_MAPPINGS'][$roomId];
            $roomInfo[$roomId]['floor_temp_set'] = $floorTempSet;
        }

        $logFileRows = file($this->config['ROOM_LOG_FILE_PATH']);
        foreach ($logFileRows as $lineNumber => $row) {
            $rowData = explode(' ', trim($row));
            $roomId = 'room'.($lineNumber + 1);
            $roomInfo[$roomId]['current_floor_temp'] = $this->formatTemp($rowData[1]);
            $roomInfo[$roomId]['is_open'] = $rowData[2] == 'open';
        }

        return $roomInfo;
    }

    public function setFloorTemp($newTemps)
    {
        $newRows = [];

        $newSetFileRows = [];

        $setFileRows = file($this->config['ROOM_SET_FILE_PATH']);
        foreach ($setFileRows as $row) {
            $rowData = explode(' ', trim($row));
            $roomId = $rowData[0];
            $newSetFileRows[] = "{$roomId} {$newTemps[$roomId]}\n";
        }

        file_put_contents($this->config['ROOM_SET_FILE_PATH'], $newSetFileRows);
    }

    private function formatTemp($temp) {
        return number_format((int)$temp / 1000, 1);
    }

    private function initRoomInfoRow($roomId)
    {
        return [
            'id' => $roomId,
            'name' => '',
            'current_floor_temp' => 0,
            'floor_temp_set' => 0,
            'is_open' => false,
        ];
    }
}
