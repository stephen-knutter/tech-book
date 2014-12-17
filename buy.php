<?php
	include('db_fns.php');
	include('book_fns.php');
	session_start();
	
	display_header('Purchase');
	$to = $_POST['email'];
	$conn = db_connect();
	
	$to = $conn->real_escape_string(trim($to));
	$regex = "^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$^";
	if(!preg_match($regex, $to)){
		echo '<div class="back">';
		echo 'Please enter a valid email address';
		echo '<br/><a href="checkout.php">&larr; Back</a>';
		echo '</div>';
		exit();
	}
	
	require("./PHPMailer-master/class.phpmailer.php");
	
	$mail = new PHPMailer();
	
		$mail->IsSMTP();
		$mail->Host = "mail.stephenknutter.com";
		$mail->SMTPAuth = true;
		$mail->Host = "mail.stephenknutter.com";
		$mail->Port = 25;
		$mail->Username = "me@stephenknutter.com";
		$mail->Password = "fDVWN!-^c";
		
		$mail->SetFrom("me@stephenknutter.com", 'Techbook DB');
		$mail->Subject = 'Techbook DB Fake Purchase!';
		$mail->AltBody = "To view message use HTML";
		$mail->MsgHTML('Thank for your fake purchase on Techbook DB!');
		
		$mail->AddAddress($to, "");
		
		if(!$mail->Send()){
			echo '<div class="back">Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo '<div class="back">Thank you for your fake purchase on Techbook DB!</div>';
		}
?>