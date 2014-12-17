<?php
	require_once('book_fns.php');
	require_once('db_fns.php');
	session_start();
	display_header();
?>
<div id="wrapper">
	<div id="sections">
		<?php
			$conn = db_connect();
			$query = "SELECT catid, catname from categories";
			$result = mysqli_query($conn, $query);
			if(mysqli_num_rows($result) == 0){
			echo 'Sorry, there are currently no categories';
			}
			echo '<div class="catListing"><h3>Categories</h3>';
			echo '<ul class="catList">';
			while($row = mysqli_fetch_assoc($result)){
			$url = 'category.php?category=' . ($row['catid']);
			$title = $row['catname'];
			echo '<li id="' . strtolower($row['catname']) . '">';
			create_link($url, $title);
			echo '</li>';
	}
	echo '</ul></div>';
		?>
	</div>
	
	<div id="topBooks">
		<h3>Top Books</h3>
		<?php
			$conn = db_connect();
			$query = "SELECT * FROM history ORDER BY count DESC LIMIT 4";
			$result = mysqli_query($conn, $query);
			echo '<div id="topBookList">';
			while($row = mysqli_fetch_assoc($result)){
				if($row['count'] > 0){
				echo "<div class='item'>
						<div class='singleItem'><a href=\"display_book.php?isbn=".$row['isbn']."\"><img class='topPic' src=\"images/".$row['isbn'].".jpg\"></a>
						</div>
						<div class='itemInfo'>
							<h4>".get_title($row['isbn'])."</h4>
							<p>$".get_price($row['isbn'])."</p>
						</div>
					</div>
					";
					
			}		
		}
	echo '</div>';

			$conn = db_connect();
			$query = "SELECT * FROM history ORDER BY count DESC LIMIT 4, 4";
			$result = mysqli_query($conn, $query);
			echo '<div id="topBookList">';
			while($row = mysqli_fetch_assoc($result)){
				if($row['count'] > 0){
				echo "<div class='item'>
						<div class='singleItem'><a href=\"display_book.php?isbn=".$row['isbn']."\"><img class='topPic' src=\"images/".$row['isbn'].".jpg\"></a>
						</div>
						<div class='itemInfo'>
							<h4>".get_title($row['isbn'])."</h4>
							<p>$".get_price($row['isbn'])."</p>
						</div>
					</div>
					";
					
			}		
		}
	echo '</div>';
		?>
	</div>
</div>
</div>

<?php
	display_footer();
?>