<?php
	require_once('book_fns.php');
	require_once('db_fns.php');
	session_start();
	
	@$new = $_GET['new'];
	
	
	if($new){
		$conn = db_connect();
		$query = "SELECT isbn FROM history where isbn='$new'";
		$result = $conn->query($query);
		if($result->num_rows == 1){
			$query = "UPDATE history set count = (count + 1) where isbn='$new'";
			$conn->query($query);
		} else {
			$query = "INSERT INTO history values('null', '$new', 1)";
			$conn->query($query);
		}
	
	
		if(!isset($_SESSION['cart'])){
			$_SESSION['cart'] = array();
			$_SESSION['items'] = 0;
			$_SESSION['total_price'] = '0.00';
		}
		
		if(isset($_SESSION['cart'][$new])){
			$_SESSION['cart'][$new]++;
		} else {
			$_SESSION['cart'][$new] = 1;
		}
		
		$conn = db_connect();
		$_SESSION['total_price'] = total_price($_SESSION['cart']);
		$_SESSION['items'] = total_items($_SESSION['cart']);
	}
	
	if(isset($_POST['save'])){
		foreach($_SESSION['cart'] as $isbn=>$qty){
			if($_POST[$isbn] == '0'){
				unset($_SESSION['cart'][$isbn]);
			} else {
				$_SESSION['cart'][$isbn] = $_POST[$isbn];
			}
		}
		
		$_SESSION['total_price'] = total_price($_SESSION['cart']);
		$_SESSION['items'] = total_items($_SESSION['cart']);
	}
	
	display_header("Shopping Cart");
	
	if((@$_SESSION['cart']) && (is_array(@$_SESSION['cart']))){
			?>
				<table border=0 cellspacing=0 class="form_table">
				<form action="cart.php" method="post">
					<tr>
						<th colspan='2' align='center'>Item</th>
						<th align='center'>Price</th>
						<th align='center'>Quantity</th>
						<th align='center'>Total</th>
					<tr>
					<?php
						foreach($_SESSION['cart'] as $isbn=>$qty){
							$conn = db_connect();
							$query = "SELECT * FROM books where isbn='$isbn'";
							$result = $conn->query($query);
							$row = $result->fetch_assoc();
							echo '<tr>';
							echo '<td align="center">';
							if(file_exists("images/$isbn.jpg")){
								echo '<img src="images/'.$isbn.'.jpg" border=0 class="checkoutImg">';
							} else {
								echo '&nbsp';
							}
							echo '</td>';
							
							echo '<td align="left">';
							echo '<a href="display_book.php?isbn='.$isbn.'">'.$row['title'].'</a></td>';
							echo '<td align="center">$'.number_format($row['price'],2).'</td>';
							echo '<td align="center"><input type="text" name="'.$isbn.'" class="qty" value="'.$qty.'"></td>';
							echo '<td align="center">$'.number_format($row['price']*$qty, 2).'</td>';
							echo '</tr>';
						}
						
						echo '<tr>';
						echo '<th colspan=3>&nbsp;</th>';
						echo '<th align="center">'.$_SESSION['items'].'</th>';
						echo '<th align="center">$'.number_format($_SESSION['total_price'],2).'</th>';
						echo '<tr>';
						
						echo '<tr>';
						echo '<td colspan=3 align="center">&nbsp;</td>';
						echo '<td align="center">';
						echo '<input type="submit" name="save" class="update_button" value="Update Cart">';
						echo '</td>';
						echo '</form>';
						echo '<td align="center"><form action="checkout.php" method="post"><input type="submit" class="update_button" name="checkout" value="Checkout"></form></td>';
						echo '</tr>';
						echo '</table>';
					?>
				
			<?php
	} else {	
		echo '<p id="noCart">You do not have any items in your cart!</p>';
	}

	display_footer();
?>