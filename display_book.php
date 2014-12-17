<?php
	require_once('book_fns.php');
	require_once('db_fns.php');
	session_start();
	
	$isbn = $_GET['isbn'];
	
	if(!$isbn || $isbn == ''){
		echo 'Sorry, book could not be found';
		return false;
	}
	
	
	
	$conn = db_connect();
	$query = "SELECT * FROM books where isbn='$isbn'";
	$result = $conn->query($query);
	if(!$result){
		echo 'Sorry, book could not be found';
		return false;
	}
	
	$row = $result->fetch_assoc();
	
	display_header($row['title']);
	
	echo '<div id="bookWrap">';
	
	echo '<h2 class="top_head_books bookTitle">' . $row['title'] . '</h2>';
	
	echo '<table class="book_display_table"><tr>';
	if(@file_exists('images/'.($row['isbn']).'.jpg')){
		echo '<td><img src=\'images/'.$row['isbn'].'.jpg\' border=0></td>';
	}
	echo '<td><ul class="book_desc">';
	echo '<li><strong>Author:</strong><span> ';
	echo $row['author'] . '</span>';
	echo '</li><li><strong>ISBN:</strong><span> ';
	echo $row['isbn'] . '</span>';
	echo '</li><li><strong>Year:</strong><span> ';
	echo $row['year'] . '</span>';
	echo '</li><li><strong>Price:</strong><span> $';
	echo number_format($row['price'], 2) . '</span>';
	echo '</li><li><strong>Description:</strong><span> ';
	echo $row['description'] . '</span>';
	echo '</li></ul><a class="pdf_link" href="view_pdf.php?isbn='.$isbn.'">View PDF</a></td></tr></table>';
	
	display_book_button("cart.php?new=".$isbn, "Add To Cart", "Add".$row['title']." To My Shopping Cart", "add");
	echo '</div>';
	display_footer();
?>