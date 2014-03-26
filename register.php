<?php

require_once "functions.php";

if($_SERVER['REQUEST_METHOD']!="POST")
{
	header('Location: index.php'); die();
}
else
{
	if(isset($_POST['activateId']))
	{
		$userId= $_POST['activateId'];
		$data=array("id"=>$userId);
		if(getToken())
		{
			$token = getToken();
			$REG_URL=$GLOBALS['BASE_URL']."/register/activate/".$userId;
			$header=array('Authorization: Bearer '.$token);
			$result=apiReq($REG_URL, $header, $data);
			if(isset($result["code"]) && $result["code"]=="success")
			{
				$retVal= array("result"=>"success", "msg"=>"Registered Successfully");
			}
			else
			{
				$retVal= array("result"=>"error", "msg"=>$result);
			}
		}
		else
		{
			$retVal= array("result"=>"error", "msg"=>"Check your internet connection and try again");
		}

	}
	else
	{
		if(!isset($_POST['email']) || !isset($_POST['password']))
		{
			if(!isset($_POST['email']) && !isset($_POST['password'])) 
			{
				$retVal= array("result"=>"error", "msg"=>"Email and password are required"); 
			}
			else if(!isset($_POST['email']) && isset($_POST['password']))
			{
				$retVal= array("result"=>"error", "msg"=>"Email is required");
			}
			else 
			{
				$retVal= array("result"=>"error", "msg"=>"Password is required"); 
			}
		}
		else
		{
			$userEmail= $_POST['email'];
			$userPassword = $_POST['password'];
			$data=array("email"=>$userEmail,"password"=>$userPassword, "delayActivation"=>true);
			if(isset($_POST['invitationKey'])) $data["invitationKey"] = $_POST['invitationKey'];
			if(getToken())
			{
				$token = getToken();
				$REG_URL=$GLOBALS['BASE_URL']."/register";
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
		}
	}
	echo json_encode($retVal);
}


?>