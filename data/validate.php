<?php
	$code = $_POST['c'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	require_once('rfc638.php');
	$secretkey = "AINUNABDULLAHGRESIK";
	$currentcode = $code
	if (TokenAuth6238::verify($secretkey, $currentcode)) {
		if ($username=='aal' && $password=='action') {
			echo "Code is valid \n";
		}else{
			echo "username dan password invalid \n";			
		}
	}else{
		if ($username=='aal' && $password=='action') {
			echo "invalid code \n";
		}else{
			echo "username dan password invalid \n";			
		}
	}
	print sprintf('<img src="%s"/>', TokenAuth6238::getBarCodeUrl('ainun', 'abdullahainun.me', $secretkey,'Ainun%20TPA'));
?>