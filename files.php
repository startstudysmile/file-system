<?php
    require 'config.php';
	session_start();
//php调试
//初始显示
//$action="files_show";
//$dept_id=6;
//$filesID=0;
//$menu_id=10;
//$sortID=1;
	$menu_id=$_SESSION['menu_id'];
	$dept_id=$_SESSION['dept_id'];
    $action =$_GET['action'];
    $menuID =$_POST['menuID'];
    $filesID =$_POST['filesID'];
	$sortID=$_POST['sortID'];
//插入数据库
//	$action="files_create";
//	$top_id=0;
//  $file_author='LMD';
	$file_name="新建文件夹";
	$type_id=1;
	$file_size="0M";
	$file_author=$_SESSION['user_name'];
	$insert_menu_id=10;		
	$top_id=$_POST['top_id'];
//删除选中文件
//$action="files_del";
//$delFilesID=array(22,23);
	$delFilesID=$_POST['delFilesID'];	
//复制选中的文件 
//$action="files_copy";
//$copyTopID=array(0,0);
//$copyFilesName=array("css3呼吸灯","html5动画效果");
//$copyTypeID=array(2,3);
//$copySize=array("0.3M","0.1M");
//$copyAuthor="LMD";
	$copyTopID=$_POST['copyTopID'];	
	$copyFilesName=$_POST['copyFilesName'];
	$copyTypeID=$_POST['copyTypeID'];
	$copySize=$_POST['copySize'];
	$copyAuthor=$_SESSION['user_name'];
	$copyMenuID=10;

    switch($action) {
        case 'menu_show':
            menu_show($menuID,$dept_id);
            break;
      	case 'files_show':
          	files_show($filesID,$menu_id,$sortID);
          	break;
		case 'files_create':
          	files_create($top_id,$file_name,$type_id,$file_size,$file_author,$insert_menu_id);
          	break;
		case 'files_del':
			files_del($delFilesID);
      	break;
		case 'files_copy':
			files_copy($copyTopID,$copyFilesName,$copyTypeID,$copySize,$copyAuthor,$copyMenuID);
      	break;
    }
    function menu_show($menuID,$deptID){
        global $connID; 
        if($connID) {  
        	$sql="select*from menu where top_id='".$menuID."'and dept_id='".$deptID."' ";
            $result =mysqli_query($connID,$sql); 
			$result_num=mysqli_num_rows($result); 
			if($result_num>0){
				 while ($info=mysqli_fetch_array($result)){
				    $_SESSION['menu_id']=$info['id'];
					$_SESSION['dept_id']= $info['dept_id'];
	            	$menu_result["code"]=1;
					$menu_result["message"]="菜单查询成功";
	                $menu_result["list"][] = array(
	                  'id' => $info['id'], 
	                  'menu_name' => $info['menu_name'], 
	                  'top_id' => $info['top_id'],
	                  'dept_id' => $info['dept_id'] 
	                );
		        }
				$json = json_encode($menu_result);
	       		echo $json;
			}else{
				$menu_result["code"]=2;
				$menu_result["message"]="数据库查询无结果";
				$json=json_encode($menu_result);
				echo $json;
			}  
        }else{
        	$menu_result["code"]=0;
        	$menu_result["message"]="数据库连接失败";
			$json=json_encode($menu_result);
			echo $json;
        }
    }
    function files_show($ID,$menuID,$sortID){
        global $connID; 
        if($connID){
        	switch($sortID) {
        		case 0:
        			$sql="select*from files_info where top_id='".$ID."'and menu_id='".$menuID."'";
	        		$result =mysqli_query($connID,$sql);
        			break;
        		case 1:
        			$sql="select*from files_info where top_id='".$ID."'and menu_id='".$menuID."'order by size asc";
	        		$result =mysqli_query($connID,$sql);
        			break;
        		case 2:
        			$sql="select*from files_info where top_id='".$ID."'and menu_id='".$menuID."' order by type_id asc";
	        		$result =mysqli_query($connID,$sql);
        			break;
				case 3:
        			$sql="select*from files_info where top_id='".$ID."'and menu_id='".$menuID."'order by convert(author using gbk) asc";
	        		$result =mysqli_query($connID,$sql);
        			break;
				case 4:
        			$sql="select*from files_info where top_id='".$ID."'and menu_id='".$menuID."' order by create_time asc";
	        		$result =mysqli_query($connID,$sql);
        			break;
        		case 5:
        			$sql="select*from files_info where top_id='".$ID."'and menu_id='".$menuID."'order by size desc";
	        		$result =mysqli_query($connID,$sql);
        			break;
				case 6:
        			$sql="select*from files_info where top_id='".$ID."'and menu_id='".$menuID."'order by convert(author using gbk) desc";
	        		$result =mysqli_query($connID,$sql);
        			break;	
        		case 7:
        			$sql="select*from files_info where top_id='".$ID."'and menu_id='".$menuID."' order by create_time desc";
	        		$result =mysqli_query($connID,$sql);
        			break;
				
        	}  
			$result_num=@mysqli_num_rows($result);
			if($result_num>0){
				while ($info=mysqli_fetch_array($result)){
					$timestamp = strtotime($info['create_time']);
	            	$files_result["code"]=1;
        			$files_result["message"]="文件查询成功";
	                $files_result["list"][]=array(
		                'id' => $info['id'], 
		                'top_id' => $info['top_id'],
		                'file_name' => $info['file_name'], 
		                'type_id' => $info['type_id'],
		                'size' => $info['size'],
		                'author' => $info['author'],
		                'create_time' =>date("Y-m-d",$timestamp) , 
		                'file_content' => $info['file_content'],
		                'menu_id' => $info['menu_id']
	                );
		        }
		        $json=json_encode($files_result);
				echo $json;
			}else{
				$files_result["code"]=2;
	        	$files_result["message"]="数据库查询无结果";
				$json=json_encode($files_result);
				echo $json;
			}  
        }else{
        	$files_result["code"]=0;
        	$files_result["message"]="数据库连接失败";
			$json=json_encode($files_result);
			echo $json;
        } 
    }
	function files_create($topID,$fileName,$typeID,$fileSize,$fileAuthor,$insertMenuID){
		global $connID;
		if($connID) {  
        	$sql="insert into files_info(id,top_id,file_name,type_id,size,author,create_time,file_content,menu_id) values ('0','".$topID."','".$fileName."','".$typeID."','".$fileSize."','".$fileAuthor."', NOW(), '','".$insertMenuID."')";
            $result =mysqli_query($connID,$sql); 
			if($result){
        		$insert_result["code"]=1;
	        	$insert_result["message"]="插入数据库成功";
				$json=json_encode($insert_result);
				echo $json;
			}else{
				$insert_result["code"]=2;
	        	$insert_result["message"]="插入数据库失败";
				$json=json_encode($insert_result);
				echo $json;
			}  
        }else{
        	$insert_result["code"]=0;
        	$insert_result["message"]="数据库连接失败";
			$json=json_encode($insert_result);
			echo $json;
        }
	}
	function files_del($delFilesID){
		global $connID;
		if($connID) {
			$delID_num=count($delFilesID);
			for($i=0;$i<$delID_num;$i++){
				$sql1="delete from files_info where id='".$delFilesID[$i]."' ";
				$sql2="delete from files_info where top_id='".$delFilesID[$i]."'";
            	$result1 =mysqli_query($connID,$sql1); 
				$result2 =mysqli_query($connID,$sql2); 
			} 
			if($result1&&$result2){
        		$del_result["code"]=1;
	        	$del_result["message"]="删除文件成功";
				$json=json_encode($del_result);
				echo $json;
			}else{
				$del_result["code"]=2;
	        	$del_result["message"]="删除文件失败";
				$json=json_encode($del_result);
				echo $json;
			}  
        }else{
        	$del_result["code"]=0;
        	$del_result["message"]="数据库连接失败";
			$json=json_encode($del_result);
			echo $json;
        }
	}
	function files_copy($topID,$fileName,$typeID,$fileSize,$fileAuthor,$insertMenuID){
		global $connID;
		if($connID) {
			$topID_num=count($topID);
			for($i=0;$i<$topID_num;$i++){
        		$sql="insert into files_info(id,top_id,file_name,type_id,size,author,create_time,file_content,menu_id) values ('0','".$topID[$i]."','".$fileName[$i]."','".$typeID[$i]."','".$fileSize[$i]."','".$fileAuthor."', NOW(), '','".$insertMenuID."')";
            	$result =mysqli_query($connID,$sql); 
			} 
			if($result){
        		$del_result["code"]=1;
	        	$del_result["message"]="复制文件成功";
				$json=json_encode($del_result);
				echo $json;
			}else{
				$del_result["code"]=2;
	        	$del_result["message"]="复制文件失败";
				$json=json_encode($del_result);
				echo $json;
			}  
        }else{
        	$del_result["code"]=0;
        	$del_result["message"]="数据库连接失败";
			$json=json_encode($del_result);
			echo $json;
        }
	}
	