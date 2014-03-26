<?php
include_once "config.php";

if($_SERVER['REQUEST_METHOD']=="GET")
{
	header('Location: index.php'); die();
}

function apiReq($url, $arrHeader, $arrData)
{
	$f = fopen($GLOBALS['LOG_FILE'], 'w');
	$data = '';

	foreach($arrData as $key => $value)
	{ 
    	$data .= $key . '=' . $value . '&'; 
	}
   	rtrim($data, '&');

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLOPT_STDERR, $f);
	$result=curl_exec($ch);
	curl_close($ch);
	fclose($f);

	return json_decode($result, true);
}

function getToken()
{
	$T_REQ_BODY= array("grant_type"=>"client_credentials");
	$TOKEN_URL= $GLOBALS['BASE_URL']."/oauth2/token";
	$encAccess=urlencode($GLOBALS['ACCESS']);
	$encSecret=urlencode($GLOBALS['SECRET']);
	$cred=$encAccess.":".$encSecret;
	$baseCred=base64_encode($cred);
	$header=array('Authorization: Basic '.$baseCred);

	$val = apiReq($TOKEN_URL, $header, $T_REQ_BODY);

	if(isset($val["access_token"]))
	{
		return $val['access_token'];
	}
	else
	{
		return false;
	}
}

?>