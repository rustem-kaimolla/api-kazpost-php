<?php
include_once "vendor/autoload.php";

use RustemKaimolla\KazPost\KazPostAPI;

$api = new KazPostAPI();

$my_track = $api->getEvents('CC016695190KZ');
echo "Статус посылки " .$my_track->status;
echo "Статус код посылки " .$my_track->status_code;