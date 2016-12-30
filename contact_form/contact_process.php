<?php
define("CONTACT_FORM", 'jorge@enterprisal.com');
function ValidateEmail($value)
{
	$regex = '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i';

	if($value == '') { 
		return false;
	} else {
		$string = preg_replace($regex, '', $value);
	}

	return empty($string) ? true : false;
}

	include 'defines.php';
	

	$post = (!empty($_POST)) ? true : false;

	if($post){

		$name = stripslashes($_POST['name']);
		$message = stripslashes($_POST['message']);
		$email = stripslashes($_POST['email']);
		$subject = 'Domain Sale INquiry';
		$error = '';	
		$message = '
			<html>
					<head>
							<title>Request</title>
					</head>
					<body>
							<p>name: '.$name.'</p>
							<p>message : '.$message.'</p>	
							<p>email : '.$email.'</p>
					</body>
			</html>';

		// if the titles have Russian letters - they need to be encoded , because
		// in the Content-Type specifies the encoding of the body only , which can be sent in any encoding .
		// it is necessary for normlano display and OUTLOOK THE BAT
		$name = '=?UTF-8?B?'.base64_encode($name).'?='; 
		$subject = '=?UTF-8?B?'.base64_encode($subject).'?='; 

		if (!ValidateEmail($email)){
			$error = '<p class="bg-danger">email format is not correct! </p>';
		}

		if(!$error){
			$mail = mail(CONTACT_FORM, $subject, $message,
			     "From: ".$name." <".$email.">\r\n"
			    ."Reply-To: ".$email."\r\n"
			    ."Content-type: text/html; charset=utf-8 \r\n"
			    ."X-Mailer: PHP/" . phpversion());

			if($mail){
				echo '<div class="bg-danger">'."Thank you! Your email has been sent".'</div>';
			}
		}else{
			echo '<div class="bg-danger">'.$error.'</div>';
		}

	}
?>