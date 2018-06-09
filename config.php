<?php
	header('Content-Type:text/html;charset=UTF-8');

	$config=array(
		'host' =>'localhost',
		'port'=>'3306',
		'db' =>'localhost',
		'db_user' =>'root',
		'db_psw' =>'',
		'db_name' =>'files_system'
	);
	$connID=mysqli_connect($config['host'],$config['db_user'],$config['db_psw'],$config['db_name'],$config['port']);
	if(!$connID){
		echo("数据库连接失败");
	}
//	@mysqli_query('SET NAMES UTF8') or die('字符集错误：'.mysql_error());
	
?>