<?php
include_once "vendor/autoload.php";

use RustemKaimolla\KazPost\API;

$api = new API();

$my_track = $api->get('TRACK_CODE');
echo "Статус посылки " .$my_track->status;
echo "Статус код посылки " .$my_track->status_code;