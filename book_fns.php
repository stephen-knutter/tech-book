<?php
	function display_header($title=''){
		if(!@$_SESSION['items']) $_SESSION['items'] = '0';
		if(!@$_SESSION['total_price']) $_SESSION['total_price'] = '0.00';
?>

<html>
<head>
	<title><?php echo $title; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/suggest.css" />
	<link rel="stylesheet" type="text/css" href="./css/bookStyle.css" />
	<link rel="stylesheet" type="text/css" href="./css/header.css" />
	<link rel="stylesheet" type="text/css" href="./css/footer.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="./js/suggest.js"></script>
	<script>
		window.onload = function(){
			 start();
		}
	</script>
</head>
<body>
<div id="header">
	<div id="headerImg"><a href="index.php"><img src="./images/techbook.png" class="headLogo"></a></div>
	<div id="cart">
		<p id="phone">+1-888-888-8888</p>
		<a id="cartLink" href="cart.php">Cart <?php
				if(isset($_SESSION['admin_user'])){
					echo '(0)';
				} else {
					echo '('.$_SESSION['items'].')';
				}
		?></a>
	</div>
	
	<div id="searchBar">
		<input type="text" name="search" id="txtBox" class="searchInput" autocomplete="off" placeholder="Book Search..." />
	</div>
</div>

<?php
}

function display_footer(){
?>
<div id="footer">
	<ul id="footerList">
		<li>&copy; Stephen Knutter</li>
		<li><a href="http://www.stephenknutter.com">Home</a></li>
		<li><a href="http://www.stephenknutter.com">About</a></li>
		<li><a href="http://www.stephenknutter.com">Contact</a></li>
	</ul>
</div>
</body>
</html>
<?php
}

function display_button($target, $text, $title, $id=''){
	echo "<center>
			<a class='shopping_button' id=\"$id\" href=\"$target\" title=\"$title\"><img id='cart' src='images/shopping-cart.png' alt='Shopping Cart'>$text</a>
		</center>";
}

function display_book_button($target, $text, $title, $id=''){
	echo "<p class='".$id."'>
			<a class='shopping_button' id=\"$id\" href=\"$target\" title=\"$title\"><img id='cartButton' src='images/shopping-cart.png' alt='Shopping Cart'>$text</a>
		</p>";
}

function display_books(){

}

function display_categories($categories){

}

function create_link($url, $name){
?>
<a href="<?php echo $url; ?>"><?php echo $name; ?></a><br />
<?php
}

function get_title($isbn){
	$conn = db_connect();
	$query = 'SELECT title FROM books WHERE isbn="'.$isbn.'"';
	$result = $conn->query($query);
	$row = $result->fetch_array();
	$title = $row[0];
	return $title;
}

function get_price($isbn){
	$conn = db_connect();
	$query = 'SELECT price FROM books WHERE isbn="'.$isbn.'"';
	$result = $conn->query($query);
	$row = $result->fetch_array();
	$price = $row[0];
	return $price;
}

	function total_price($cart){
			$conn = db_connect();
			$price = 0.0;
			if(is_array($cart)){
				foreach($cart as $isbn=>$qty){
					$query = "SELECT price from books WHERE isbn='$isbn'";
					$result = $conn->query($query);
					if($result){
						$row = $result->fetch_assoc();
						$item = $row['price'];
						$price += $item*$qty;
					}
				}
			}
			return $price;
	}
	
	
	function total_items($cart){
		$conn = db_connect();
		$items = 0;
		
		if(is_array($cart)){
			foreach($cart as $isbn => $qty){
				$items += $qty;
			}
		}
		return $items;
	}
?>