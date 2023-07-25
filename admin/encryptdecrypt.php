<?php



	function dataEncrypt($value){
		$val = base64_encode($value);
		$val = reverse($val);
		return $val;
	}

	function dataDecrypt($value){
		$val = reverse($value);
		$val = base64_decode($val);
		return $val;
	}

	function string_reverse($str){ 
		return strrev($str); 
	} 



?>