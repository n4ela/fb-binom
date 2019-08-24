<?php
$config = include('../config.php');
$URL = $config['binom_url'] . '?lp=1&emulation_mode=1&uclick=' . $_GET['uclick'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$result = curl_exec( $ch );
curl_close( $ch );
require_once($_GET["folder"].'/index.php');
?>
