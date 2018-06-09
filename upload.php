<?php
	require 'config.php';
	session_start();
	print_r($_FILES);
	$upload_path="uploads/";
	$type_list=array("image/jpg","image/png","text/html","application/zip");//定义允许的类型
	$upload_error=$_FILES["myfile"]["error"];
	$upload_type=$_FILES["myfile"]["type"];
	$upload_name=$_FILES["myfile"]["name"];
	$upload_tmp_name=$_FILES["myfile"]["tmp_name"];
	//插入数据库内容
	$upload_topID=0;
	$upload_name=$_FILES["myfile"]["name"];
	$upload_typeID=2;
	$upload_size=$_FILES["myfile"]["size"];
	$upload_author=$_SESSION['user_name'];
	$upload_content=$upload_path;
	$upload_menuID=10;
	
	if($connID) {
	 	if($upload_error>0){
	 		switch ($upload_error){
			    case 1:
					$upload_result["code"]=01;
		        	$upload_result["message"]="上传的文件超过了php.ini 中 upload_max_filesize 选项限制的值";
			       	$json=json_encode($upload_result);
					echo $json;
				    break;
			    case 2:
					$upload_result["code"]=02;
		        	$upload_result["message"]="上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值";
			        $json=json_encode($upload_result);
			        echo $json;
			        break;
			    case 3:
				    $upload_result["code"]=03;
		        	$upload_result["message"]="文件并未完全上传，请再次尝试！文件只有部分被上传";
			        $json=json_encode($upload_result);
					echo $json;
			        break;
			    case 4:
					$upload_result["code"]=04;
		        	$upload_result["message"]="未选择上传文件";
					$json=json_encode($upload_result);
					echo $json;
			        break;
			    case 5:
					$upload_result["code"]=05;
		        	$upload_result["message"]="上传文件为0";
					$json=json_encode($upload_result);
					echo $json;
			        break;
				case 6:
					$upload_result["code"]=06;
					$upload_result["message"]="找不到临时文件夹";
					$json=json_encode($upload_result);
					echo $json;
			        break;
                case 7:
					$upload_result["code"]=07;
					$upload_result["message"]="文件写入失败";
					$json=json_encode($upload_result);
					echo $json;
			        break;
                case 8:
					$upload_result["code"]=08;
					$upload_result["message"]="由于PHP的扩展程序中断了文件上传";
					$json=json_encode($upload_result);
					echo $json;
                    break;
			}
	 	}
		if($uploadFileSize>20*1024*1024){
            //对特定表单的上传文件限制大小
            $upload_result["code"]=11;
        	$upload_result["message"]="上传文件超出限制大小";
			$json=json_encode($upload_result);
			echo $json;
	    }
		if(!in_array($upload_type,$type_list)){
	    	//判断文件类型
	    	$upload_result["code"]=12;
        	$upload_result["message"]="上传的文件不是指定类型";
			$json=json_encode($upload_result);
			echo $json;
	    }
		//上传文件后对文件名进行定义
		$fileinfo=pathinfo($upload_name);//解析上传文件名字
		do{
			$newfile=date("YmdHis").rand(1000, 9999).".".$fileinfo["extension"];
		}while(file_exists($upload_path.$newfile));
		//判断是否是一个上传的文件
		if(is_uploaded_file($upload_tmp_name)){
			//执行文件上传
			if(move_uploaded_file($upload_tmp_name,$upload_path.$newfile)){
				$upload_result["code"]=1;
				$upload_result["message"]="文件上传成功";
				$json=json_encode($upload_result);
				echo $json;
				$sql="insert into files_info(id,top_id,file_name,type_id,size,author,create_time,file_content,menu_id) values ('0','".$upload_topID."','".$upload_name."','".$upload_typeID."','".$upload_size."','".$upload_author."', NOW(), '".$upload_path."','".$upload_menuID."')";
				$result =mysqli_query($connID,$sql); 
				if($result){
					$upload_result["code"]=1;
		        	$upload_result["message"]="文件已经上传且插入数据库成功";
					$json=json_encode($upload_result);
					echo $json;
				}else{
					$upload_result["code"]=2;
		        	$upload_result["message"]="文件已经上传且插入数据库失败";
					$json=json_encode($upload_result);
					echo $json;
				} 
			}else{
				$upload_result["code"]=13;
				$upload_result["message"]="上传文件失败";
				$json=json_encode($upload_result);
				echo $json;
			}
		}else{
			$upload_result["code"]=14;
			$upload_result["message"]="不是一个上传文件";
			$json=json_encode($upload_result);
			echo $json;
		}		
	}else{
		$upload_result["code"]=0;
    	$upload_result["message"]="数据库连接失败";
		$json=json_encode($upload_result);
		echo $json;
	}
?>