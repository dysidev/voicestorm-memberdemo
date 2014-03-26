<?php

include "config.php";
require_once "../functions.php";

if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['invitationKey']))
{
	$userEmail= $_POST['email'];
	$userPassword = $_POST['password'];
	$regToken = $_POST['invitationKey'];
	if(getToken())
	{
		$token = getToken();
		$REG_URL=$GLOBALS['BASE_URL']."/register";
		$data=array("email"=>$userEmail,"password"=>$userPassword, "invitationKey" => $regToken);
		$header=array('Authorization: Bearer '.$token);
		$result=apiReq($REG_URL, $header, $data);
		if(isset($result["user"]))
		{
			$retVal = array("result"=>"success", "token" => $result["token"], "expiration" => $result["expiration"]);
		}
		else if(isset($result["code"]) && $result["code"]=="already_exists")
		{
			$retVal= array("result"=>"error", "msg"=>"Your email address is already registered. Try signing in.");
		}
		else
		{
			$retVal= array("result"=>"error", "msg"=>"Please try again with valid details");
		}
	}
	else
	{
		$retVal= array("result"=>"error", "msg"=>"Check your internet connection and try again");
	}

	echo json_encode($retVal);
}
else
{
	echo "You are not allowed to access this page";
}
?>