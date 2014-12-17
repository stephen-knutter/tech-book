<?php
	require_once('book_fns.php');
	require_once('db_fns.php');
	session_start();
	
	$category = $_GET['category'];
	
	$conn = db_connect();
	$query = "SELECT catname from categories WHERE catid='$category'";
	$result = $conn->query($query);
	if($result->num_rows == 0){
		echo 'No, categories could be found!';
		return false;
	}
	
	$row = $result->fetch_assoc();
	$name = $row['catname'];
	
	display_header($name);
	
	echo '<div id="categoryWrap">';
	
	echo '<h2 class="top_head_books">' . $name . '</h2>';
	
	if( !($category) || $category == ''){
		echo 'No, categories could be found...!';
	}
	
	$query_books = "SELECT * FROM books WHERE catid='$category'";
	$result_books = $conn->query($query_books);
	
	if(!$result_books){
		echo 'Sorry, no books in this category';
		return false;
	}
	echo '<table class="book_listing_table" border=0>';
	while($row_book = $result_books->fetch_assoc()){
		$url = 'display_book.php?isbn=' .($row_book['isbn']);
		echo '<tr><td style="padding-bottom: 10px; padding-top: 5px;">';
		if(@file_exists('images/' . $row_book['isbn'] . '.jpg')){
			$title = '<img src=\'images/' .($row_book['isbn']). '.jpg\' border=0>';
			create_link($url, $title);
		} else {
			echo '&nbsp';
		}
		echo '</td><td>';
		$title = $row_book['title'] . ' by ' . $row_book['author'];
		create_link($url, $title);
		echo $row_book['description'];
		echo '<td></tr>';
	}
	echo '</table>';
	echo '</div>';
	display_footer();
?>