<?php
	require 'config.php';
	session_start();
	@$action=$_GET['action'];
	@$loginAccount=$_POST['loginAccount'];
	@$loginPsw=$_POST['loginPsw'];
//	$action="login";
//	$loginAccount="liumd";
//	$loginPsw="123456";
	switch($action){
		case 'login':
			login($loginAccount,$loginPsw);
			break;
	}
	function login($num,$psw){
		global $connID;
		$sql="select*from staff_info where account='".$num."'and psw ='".$psw."'";
		$result=mysqli_query($connID,$sql);
		$result_num=@mysqli_num_rows($result);
		if($result_num>0){
			while($info=@mysqli_fetch_array($result)){
				$_SESSION['user_name']=$info['user_name'];
				$_SESSION['dept_id']=$info['dept_id'];
				$login_result["code"]=1;
				$login_result["message"]="登陆成功";
				$login_result["list"][]=array(
					'userName'=>$info['name'],
				);
			}
			$json=json_encode($login_result);
			echo $json;
		}else{
			$login_result["code"]=2;
			$login_result["message"]="您输入的用户名和密码不能匹配，登陆失败";
			$json=json_encode($login_result);
			echo $json;
		}
	}
	function register(){
		
	}
?>