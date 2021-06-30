<?php
include_once "vendor/autoload.php";

use RustemKaimolla\KazPost\KazPostAPI;

$api = new KazPostAPI();

$my_track = $api->get('TRACK_CODE');
echo "Статус посылки " .$my_track->status;
echo "Статус код посылки " .$my_track->status_code;