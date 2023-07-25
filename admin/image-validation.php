<?php
	function checkfileextention($filename){
	 	$allowed =  array('gif','png' ,'jpg', 'jpeg');
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if(!in_array($ext,$allowed) ) {
			return "false";
		}else{
			return "true";
		}
	 }
	 
	 function checkfilesize($file){
	 	if($file['size'] > 2000000){
			return "false";
		}else{
			return "true";
		}
	 }
?>