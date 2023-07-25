<?php

	
	//DATA INSERT FUNCTIONALITY WITH SUCCESS MESSAGE RETURN
	function insert($tableName, $colNames, $colValues){
		include "connect.php";
		$sql = "INSERT INTO " . $tableName . " (";
		for($i = 0; $i < count($colNames); $i++){
			if($i+1 == count($colNames)){
				$sql = $sql . $colNames[$i] . ")";
			}else{
				$sql = $sql . $colNames[$i] . ", ";
			}
		}
		$sql = $sql . " VALUES (";
		for($i = 0; $i < count($colValues); $i++){
			if($i+1 == count($colValues)){
				$sql = $sql  . "?)";
			}else{
				$sql = $sql . "?,";
			}
		}
		
		$pre_stmt = $conn->prepare($sql);
		DynamicBindVariables($pre_stmt, $colValues);
		if($pre_stmt->execute()){
			$pre_stmt->close();
			$conn->close();
			return true;
		}else{
			return false;
		}
	}
	
	//DATA INSERT FUNCTIONALITY WITH INSERTED ROW ID RETURN
	function insert_rowid($tableName, $colNames, $colValues){
		include "connect.php";
		$sql = "INSERT INTO " . $tableName . " (";
		for($i = 0; $i < count($colNames); $i++){
			if($i+1 == count($colNames)){
				$sql = $sql . $colNames[$i] . ")";
			}else{
				$sql = $sql . $colNames[$i] . ", ";
			}
		}
		$sql = $sql . " VALUES (";
		for($i = 0; $i < count($colValues); $i++){
			if($i+1 == count($colValues)){
				$sql = $sql  . "?)";
			}else{
				$sql = $sql . "?,";
			}
		}
		
		$pre_stmt = $conn->prepare($sql);
		DynamicBindVariables($pre_stmt, $colValues);
		if($pre_stmt->execute()){
			$last_id = $conn->insert_id;
			$pre_stmt->close();
			$conn->close();
			return $last_id;
		}
	}
	
	//DATA EDIT FUNCTIONALITY WITH SUCCESS MESSAGE RETURN
	function update($tableName, $colNames, $colValues, $searchKeyName){
		include "connect.php";
		$sql = "UPDATE " . $tableName . " SET ";
		for($i = 0; $i < count($colNames); $i++){
			if($i+1 == count($colNames)){
				$sql = $sql . $colNames[$i] . "=?";
			}else{
				$sql = $sql . $colNames[$i] . "=?, ";
			}
		}
		
		$sql = $sql . " WHERE " . $searchKeyName . "=?";
		
		$pre_stmt = $conn->prepare($sql);
		DynamicBindVariables($pre_stmt, $colValues);
		if($pre_stmt->execute()){
			$pre_stmt->close();
			$conn->close();
			return true;
		}else{
			return false;
		}
	}
	
	// DATA DELETE FUNCTIONALITY
	function delete($tablename, $searchKeyColName, $searchKey, $deleteType, $fileColName, $folderPath){
		if(checkDataExistance($tablename, array($searchKeyColName), array($searchKey))){
			include "connect.php";
			if($deleteType == "data"){
				$sql = "DELETE FROM " . $tablename . " WHERE " . $searchKeyColName ."=?";
				$pre_stmt = $conn->prepare($sql);
				if(is_int($searchKey)) {
					// Integer
					$pre_stmt->bind_param("i",$searchKey);
				} elseif (is_float($searchKey)) {
					// Double
					$pre_stmt->bind_param("d",$searchKey);
				} elseif (is_string($searchKey)) {
					// String
					$pre_stmt->bind_param("s",$searchKey);
				} else {
					// Blob and Unknown
					$pre_stmt->bind_param("b",$searchKey);
				}
				if($pre_stmt->execute()){
					return true;
				}else{
					return false;
				}
			}else if($deleteType == "data_with_file"){
				$sql = "SELECT " . $fileColName . " FROM " . $tablename  . " WHERE " . $searchKeyColName ."=?";
				$pre_stmt = $conn->prepare($sql);
				DynamicBindVariables($pre_stmt, array($searchKey));
				$pre_stmt->execute();
				$result = $pre_stmt->get_result();
				while($row = $result->fetch_assoc()) {
					unlink($folderPath . $row[$fileColName]);
				}
				
				$sql = "DELETE FROM " . $tablename . " WHERE " . $searchKeyColName ."=?";
				$pre_stmt = $conn->prepare($sql);
				if(is_int($searchKey)) {
					// Integer
					$pre_stmt->bind_param("i",$searchKey);
				} elseif (is_float($searchKey)) {
					// Double
					$pre_stmt->bind_param("d",$searchKey);
				} elseif (is_string($searchKey)) {
					// String
					$pre_stmt->bind_param("s",$searchKey);
				} else {
					// Blob and Unknown
					$pre_stmt->bind_param("b",$searchKey);
				}
				if($pre_stmt->execute()){
					return true;
				}else{
					return false;
				}
			}
		}
	}
	
	// CHECK DATA EXISTANCE FUNCTIONALITY
	function checkDataExistance($tablename, $colNames, $colValues){
		include "connect.php";
		$sql = "SELECT ";
		for($i = 0; $i < count($colNames); $i++){
			if($i+1 == count($colNames)){
				$sql = $sql . $colNames[$i];
			}else{
				$sql = $sql . $colNames[$i] . ", ";
			}
		}
		$sql = $sql . " FROM " . $tablename . " WHERE ";
		for($i = 0; $i < count($colNames); $i++){
			if($i+1 == count($colNames)){
				$sql = $sql . $colNames[$i] . "=?";
			}else{
				$sql = $sql . $colNames[$i] . "=? AND ";
			}
		}
		$pre_stmt = $conn->prepare($sql);
		
		DynamicBindVariables($pre_stmt, $colValues);
		if($pre_stmt->execute()){
			$result = $pre_stmt->get_result();
			if($result->num_rows > 0){
				return true;
			}else{
				return false;
			}
			$pre_stmt->close();
			$conn->close();
		}
		
	}
	
	//QUERY RETURN VALUE
	function getValue($table, $returnValueColName, $SearchKeyName, $searchKey){
		include "connect.php";
		$sql = "SELECT " . $returnValueColName . " FROM " . $table . " WHERE " . $SearchKeyName . "=?";
		//return $sql;
		$pre_stmt = $conn->prepare($sql);
		if(is_int($searchKey)) {
			// Integer
			$pre_stmt->bind_param("i",$searchKey);
		} elseif (is_float($searchKey)) {
			// Double
			$pre_stmt->bind_param("d",$searchKey);
		} elseif (is_string($searchKey)) {
			// String
			$pre_stmt->bind_param("s",$searchKey);
		} else {
			// Blob and Unknown
			$pre_stmt->bind_param("b",$searchKey);
		}
		$pre_stmt->execute();
		$result = $pre_stmt->get_result();
		if($result->num_rows > 0){
			$row = $result->fetch_assoc();
			return $row[$returnValueColName];
		}else{
			return "not found";
		}
	}
	
	//POSTED VALUE STERILIZATION	
	function sterilizeValue($value){
		include "connect.php";
		$sterilized = stripslashes($value);
		$sterilized = mysqli_real_escape_string($conn, $sterilized);
		return $sterilized;
	}
	
	
	//DYNAMIC BIND PARAM FOR PREPARED STATEMENT
	
	function DynamicBindVariables($stmt, $params){
		if ($params != null)
		{
			// Generate the Type String (eg: 'issisd')
			$types = '';
			foreach($params as $param)
			{
				if(is_int($param)) {
					// Integer
					$types .= 'i';
				} elseif (is_float($param)) {
					// Double
					$types .= 'd';
				} elseif (is_string($param)) {
					// String
					$types .= 's';
				} else {
					// Blob and Unknown
					$types .= 'b';
				}
			}
	  
			// Add the Type String as the first Parameter
			$bind_names[] = $types;
	  
			// Loop thru the given Parameters
			for ($i=0; $i<count($params);$i++)
			{
				// Create a variable Name
				$bind_name = 'bind' . $i;
				// Add the Parameter to the variable Variable
				$$bind_name = $params[$i];
				// Associate the Variable as an Element in the Array
				$bind_names[] = &$$bind_name;
			}
			 
			// Call the Function bind_param with dynamic Parameters
			call_user_func_array(array($stmt,'bind_param'), $bind_names);
		}
		return $stmt;
	}
	
	// SINGLE FILE UPLOAD
	function singleFileUpload($file, $uploadPath){
		$imgFileName = $file["name"];
		$imgNewFileName = preg_replace('/\s+/', '', $imgFileName);
		if(move_uploaded_file($file['tmp_name'], $uploadPath . $file['name'])){
			rename($uploadPath.$imgFileName, $uploadPath.$imgNewFileName);
			return true;
		}else{
			return false;
		}
	}
	
	// MULTIPLE FILES UPLOAD
	function multipleFilesUpload($files, $uploadPath, $tableName, $colNames, $colValues){
		if (isset($files) && !empty($files)) {
			$no_files = count($files['name']);
			for ($i = 0; $i < $no_files; $i++) {
				if ($files["error"][$i] > 0) {
					echo "Error: " . $files["error"][$i] . "<br>";
				} else {
					$imgFileName = $files["name"][$i];
					$imgNewFileName = preg_replace('/\s+/', '', $imgFileName);
					
					if (file_exists($uploadPath . $files["name"][$i])) {
						echo 'File: ' . $files["name"][$i] . ' already exists';
					} else {
						move_uploaded_file($files["tmp_name"][$i], $uploadPath . $files["name"][$i]);
						rename($uploadPath.$imgFileName, $uploadPath.$imgNewFileName);
						$arr = array();
						for ($n = 0; $n < count($colValues); $n++) {
							if($colValues[$n] != "Insert_Dynamic_Image_Value"){
								array_push($arr, $colValues[$n]);
							}else{
								array_push($arr, $imgNewFileName);
							}
						}
						insert($tableName, $colNames, $arr);
					}
				}
			}
			return true;
		} else {
			return false;
		}
	}
	
	//CHECK IF INPUT TYPE FILE HAS SELECTED ANY FILE
	function fileSelected($file){
		if ($file["size"] > 0) {
			return true;
		}else{
			return false;
		}
	}
	
	//FILE MOVE ACTION
	function moveFile($oldroute, $newRoute){
		if(rename($oldroute, $newRoute)){
			return true;
		}else{
			return false;
		}
	}
	
	
	// FILE REPLACE ACTION
	function fileReplace($file, $uploadPath, $table, $colName, $searchKeyName, $searchKey){
		include "connect.php";
		$imgFileName = $file["name"];
		$imgNewFileName = preg_replace('/\s+/', '', $imgFileName);
		
		$sql = "SELECT " . $colName . " FROM " . $table . " WHERE " . $searchKeyName . "=?";
		$pre_stmt = $conn->prepare($sql);
		$pre_stmt->bind_param("i",intval($searchKey));
		$pre_stmt->execute();
		$result = $pre_stmt->get_result();
		$row = $result->fetch_assoc();
		$oldfileName = $row[$colName];
		if(move_uploaded_file($file['tmp_name'], $uploadPath . $file['name'])){
			unlink($uploadPath . $oldfileName);
			rename($uploadPath.$imgFileName, $uploadPath.$imgNewFileName);
			justUpdate($table, array($colName), array($imgNewFileName, intval($searchKey)), $searchKeyName);
			return true;
		}else{
			return false;
		}
	}
	
	//ENCRYPT DATA
	function encrypt($value){
		$val = base64_encode($value);
		$val = reverse($val);
		return $val;
	}
	
	//DECRYPT DATA
	function decrypt($value){
		$val = reverse($value);
		$val = base64_decode($val);
		return $val;
	}
	
	//STRING REVERSE
	function reverse($str){ 
		return strrev($str); 
	} 
	
	//CREATE FOLDER
	function createFolder($route, $name){
		$foldername = preg_replace('/\s+/', '', $name);
		$foldername = strtolower($foldername);
		$dirpath = $route . $foldername;
		if (!file_exists($dirpath)) {
			mkdir($dirpath, 0777, true);
		}
	}
	
	//DELETE FILE OR DIRECTORY
	function deleteDirectory($dirPath) {
		if (is_dir($dirPath)) {
			$objects = scandir($dirPath);
			foreach ($objects as $object) {
				if ($object != "." && $object !="..") {
					if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
						deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
					} else {
						unlink($dirPath . DIRECTORY_SEPARATOR . $object);
					}
				}
			}
		reset($objects);
		rmdir($dirPath);
		}
	}
	
	//GET FOLDER NAME
	function getFolderName($name){
		$foldername = preg_replace('/\s+/', '', $name);
		$foldername = strtolower($foldername);
		return $foldername;
	}

	function encryptPassword($password){
		return password_hash($password, PASSWORD_BCRYPT, ["cost"=>8, "salt"=>"qk7hT*&dFYwfQUbyr4!TVqv)xHQ+u7"]);
	}

	function login($tablename, $colNames, $colValues){
		if(checkDataExistance($tablename, $colNames, $colValues)){
			return true;
		}else{
			return false;
		}
	}


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

	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
?>