<?php
require_once "functions.php";

if($_SERVER['REQUEST_METHOD']!="POST")
{
	header('Location: index.php'); die();
}
else
{
	if(!isset($_POST['userId']))
	{
		$retVal= array("result"=>"error", "msg"=>"User Id is not provided"); 	
	}
	else
	{
		$userId=$_POST['userId'];
		if(getToken())
		{
			$token = getToken();
			$DELETE_USER_URL=$GLOBALS['BASE_URL']."/deleteuser";
			$data=array("id"=>$userId);
			$header=array('Authorization: Bearer '.$token);
			$result=apiReq($DELETE_USER_URL, $header, $data);
			if(isset($result["code"]))
			{
				$retVal = array("result"=>"success", "code"=>$result["code"]);
			}
			else
			{
				$retVal= array("result"=>"error", "msg"=>"Cannot delete account please try again");
			}
		}
		else
		{
			$retVal= array("result"=>"error", "msg"=>"Check your internet connection and try again");
		}	
	}
	echo json_encode($retVal);
}

?>