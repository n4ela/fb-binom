<?php
	include("binom_click_api.php");
    $config = include('config.php');
    $CampaignLink = $config['binom_url'] . '?key=' . $config['binom_key'];
    $ApiKey = $config['binom_api_key'];
    $getClick = new getClick($CampaignLink, $ApiKey);

    $landing = $getClick->getLanding();
?>