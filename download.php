<?php
	$download_name=$_POST[""]; //下载文件名  
	$download_path=$_POST[""]; //下载文件存放目录    
	if(!file_exists ( $download_path . $download_name )){
		echo "文件找不到";    
   		exit ();    
	}else{
		//打开文件
		$file=fopen($download_path . $download_name, "r");
		//输入文件标签     
	    Header ( "Content-type: application/octet-stream" );    
	    Header ( "Accept-Ranges: bytes" );    
	    Header ( "Accept-Length: " . filesize ($download_path . $download_name ));    
	    Header ( "Content-Disposition: attachment; filename=" . $download_name); 
		//输出文件内容     
    	//读取文件内容并直接输出到浏览器    
	    echo fread ( $file, filesize ( $download_path . $download_name ) );    
	    fclose($file);    
	    exit ();    
		
	}
?>