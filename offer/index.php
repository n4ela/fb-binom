<?php
$config = include('../config.php');
$imklo_link = $config['imklo_link'];
$white_link = "http://".$config['white_site'].'/';

$link = $_GET['link'];
$info = new SplFileInfo($link);
if($info->getExtension() == 'php' || $info->getExtension() == 'html' || $info->getExtension() == '') {
	$post['ip'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	if (in_array($post["ip"], $config['ignore_ip'])) {
		require_once('b.php');
		exit();
	}
	$post['domain'] = $_SERVER['HTTP_HOST'];
	$post['referer'] = @$_SERVER['HTTP_REFERER'];
	$post['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
	$post['url'] = $_SERVER['REQUEST_URI'];
	$post['headers'] = json_encode(apache_request_headers());
	$curl = curl_init($imklo_link.'/api/check_ip');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_TIMEOUT, 60);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
	$json_reqest = curl_exec($curl);
	curl_close($curl);
	$api_reqest = json_decode($json_reqest);
	
	if(!@$api_reqest || @$api_reqest->white_link || @$api_reqest->result == 0){
		$type = 'text/html';
	} else {
		require_once('b.php');
		exit();
	}
} else {
	$type = 'text/'.$info->getExtension();
}

$dirExist = file_exists('../cache');
if (!$dirExist) {
	$dirExist = mkdir('../cache');
}
if ($dirExist) {
	$fileName = '../cache/' . md5($white_link . $link);
	if (!file_exists($fileName)) {
		$html = file_get_contents($white_link . $link);
		file_put_contents($fileName, $html);
	} else {
		$html = file_get_contents($fileName);
	}		
}

header('Content-type: '.$type);
$html = str_replace($config['white_site'], $_SERVER['HTTP_HOST'], $html);
$html = str_replace("www.www", 'www', $html);
$html = str_replace("http:", 'https:', $html);
echo $html;

?>
