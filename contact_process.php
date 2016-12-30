<?php
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

include 'settings.php';
	
$domain= $_SERVER['SERVER_NAME'];
// $url= $_SERVER['SERVER_NAME'];
// $domain = str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
// echo $domain; 
$post=TRUE;
// echo $post;

	if($post){

		$name = stripslashes($_POST['name']);
		$message = stripslashes($_POST['message']);
		$email = stripslashes($_POST['email']);
		$subject = $domain.' Domain Sale Inquiry';
		$error = '';
	
$emailbody = '<html><head><title>Request</title></head>';
$emailbody .='<body>';
$emailbody .='<p>name: '.$name.'</p>';
$emailbody .='<p>message: '.$message.'</p>';
$emailbody .='<p>email : '.$email.'</p>';
$emailbody .='</body></html>';


		// if the titles have Russian letters - they need to be encoded , because
		// in the Content-Type specifies the encoding of the body only , which can be sent in any encoding .
		// it is necessary for normlano display and OUTLOOK THE BAT
		$name = '=?UTF-8?B?'.base64_encode($name).'?='; 
		$subject = '=?UTF-8?B?'.base64_encode($subject).'?='; 

		if (!ValidateEmail($email)){
			$error = '<p class="bg-danger">email format is not correct! </p>';
		}

		if(!$error){

    $date = new DateTime();
    $currentdate = $date->format('Y-m-d H:i:s');
    $subject .= " / ".$currentdate;
/* Working 
			$mail = mail(CONTACT_FORM, $subject, $emailbody,
			     "From: ".$name." <".$email.">\r\n"
			    ."Reply-To: ".$email."\r\n"
			    ."Content-type: text/html; charset=utf-8 \r\n"
			    ."X-Mailer: PHP/" . phpversion());
*/
		$mail = mail(CONTACT_FORM, $subject, $emailbody,
			     "From: Domain Sale Form <".CONTACT_FORM.">\r\n"
			    ."Reply-To: ".CONTACT_FORM."\r\n"
			    ."Content-type: text/html; charset=utf-8 \r\n"
			    ."X-Mailer: PHP/" . phpversion());

			if($mail){
				echo '<div class="bg-danger">'."Thank you! Your email has been sent".'</div>';
			}
		}else{
			echo '<div class="bg-danger">Error: '.$error.'</div>';
		}

	}
?>