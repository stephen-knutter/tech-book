<?php
	function db_connect(){
		$result = new mysqli('localhost', 'cl54-book', 'HiUn3EoN', 'cl54-book');
		if(!$result){
			return false;
		}
		return $result;
	}
?>