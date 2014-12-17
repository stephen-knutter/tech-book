<?php
	class Suggest{
		private $mMysqli;
		
		function __construct(){
			$this->mMysqli = new mysqli('localhost', '', '', '');
		}
		
		function __destruct(){
			$this->mMysqli->close();
		}
		
		public function getSuggestions($keyword){
			$patterns = array('/\s+/', '/"+/', '/%+/');
			$replace = array('');
			$keyword = preg_replace($patterns, $replace, $keyword);
			if($keyword != ''){
				$query = 'SELECT * FROM books WHERE title LIKE "%'.$keyword.'%"';
			}
			
			$result = $this->mMysqli->query($query);
			
			$output = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
			$output .= '<response>';
			if($result->num_rows){
				while($row = $result->fetch_assoc()){
					$title = htmlspecialchars($row['title']);
					$output .= '<name isbn="'.$row['isbn'].'">'.$title.'</name>';
				}
				$result->close();
			}
			$output .= '</response>';
			
			return $output;
		}
	}
?>