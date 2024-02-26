<?php
require_once('../config/rajaongkirstarter.php');

$asal = $_POST['asal'];
$tujuan = $_POST['tujuan'];
$berat = $_POST['berat'];
$kurir = $_POST['kurir'];

$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "origin=" . $asal . "&destination=" . $tujuan . "&weight=" . $berat . "&courier=" . $kurir,
	CURLOPT_HTTPHEADER => array(
		"content-type: application/x-www-form-urlencoded",
		"key:$api_key"
	),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
	echo "error^" . $err;
} else {
	echo $response;
}
