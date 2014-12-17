<?php
	require_once('book_fns.php');
	require_once('db_fns.php');
	session_start();
	
	display_header('Checkout');
	
	if(($_SESSION['cart']) && (array_count_values($_SESSION['cart']))){
		echo '<table border=0 width="100%" cellspacing=0 class="form_table">
					<tr>
						<th colspan="2" align="center">Item</th>
						<th align="center">Price</th>
						<th align="center">Quantity</th>
						<th align="center">Total</th>
					<tr>';
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
							echo '<td align="center">'.$qty.'</td>';
							echo '<td align="center">$'.number_format($row['price']*$qty, 2).'</td>';
							echo '</tr>';
						}
						
						echo '<tr>';
						echo '<th colspan=3>&nbsp;</th>';
						echo '<th align="center">'.$_SESSION['items'].'</th>';
						echo '<th align="center">$'.number_format($_SESSION['total_price'],2).'</th>';
						echo '<tr>';
						echo '</table>';
						echo '<br/>';

					echo '<h3 id="info">Customer Information</h3>';
					echo '<div class="customer_info">';
					echo '<i>This is a fake store, enter a valid email and hit Buy to run the post-transaction auto-email script!</i>';
					echo '<form action="buy.php" method="post">
							<p>
								<label for="name">Name</label>
								<input type="text" class="buy_input" name="name" size=40><br/>
								<label for="email">Email</label>
								<input type="text" class="buy_input" name="email" size=40><br/>
								<label for="address">Address</label>
								<input type="text" class="buy_input" name="address" size=40><br/>
								<label for="city">City</label>
								<input type="text" class="buy_input" name="city" size=40><br/>
								<label for="state">State</label>
								<input type="text" class="buy_input" name="state" size=40><br/>
								<label for="zip">Zip</label>
								<input type="text" class="buy_input" name="zip" size=40><br/>
								
								<label for="card_name">Card Name</label>
								<input type="text" class="buy_input" name="card_name" /><br/>
								
								<label for="number">Card Number</label>
								<input type="text" class="buy_input" name="number" /><br/>
								
								<label for="card">Card Type</label>
								<select name="card">
									<option>MasterCard</option>
									<option>Visa</option>
									<option>AMEX</option>
									<option>Discover</option>
								</select>
								
								<span class="exp">Expiration:</span>
								<select>
										<option>01</option>
										<option>02</option>
										<option>03</option>
										<option>04</option>
										<option>05</option>
										<option>06</option>
										<option>07</option>
										<option>08</option>
										<option>09</option>
										<option>10</option>
										<option>11</option>
										<option>12</option>
									</select>
									<select>
											<option>2014</option>
											<option>2015</option>
											<option>2016</option>
											<option>2017</option>
											<option>2018</option>
											<option>2019</option>
											<option>2020</option>
											<option>2021</option>
											<option>2022</option>
											<option>2023</option>
											<option>2024</option>
											<option>2025</option>
										</select><br/>';
								
								echo '<input type="submit" class="buy_button" name="submit" value="Buy">';
								echo '</p></form></div>';
						
	} else {
		echo 'There are currently no items in your cart!';
	}
	
	display_footer();
?>