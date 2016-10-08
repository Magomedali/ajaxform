<?php

$respone = array();
$respone['result'] = 0;
	if(strtoupper($_SERVER['REQUEST_METHOD'])=="POST"){
		if(isset($_POST['name']) && trim(strip_tags($_POST['name']))){
			$name = trim(strip_tags($_POST['name']));
			if(preg_match('/[^а-я]+/msiu', $name)){
				$respone['messages'][] = "Поле 'Имя' должно состоять только из русских букв";
				echo json_encode($respone);
				exit;
			}
		}else{
			$respone['messages'][] = "Введите корректное имя.";
		}

		if(isset($_POST['email']) && trim(strip_tags($_POST['email']))){
			$email = trim(strip_tags($_POST['email']));
			if(!preg_match('/^.+@.+\.[a-zA-Z]{2,4}$/', $email)){
				$respone['messages'][] = "Не корректный E-mail.";
				$respone['result'] = 0;
				echo json_encode($respone);
				exit;
			}
		}else{
			$respone['result'] = 0;
			$respone['messages'][] = "Введите свой E-mail.";
		}

		if(isset($_POST['tel']) && trim(strip_tags($_POST['tel']))){
			$tel = trim(strip_tags($_POST['tel']));
			if(!preg_match('/^[0-9]{10,11}$/', $tel)){
				$respone['messages'][] = "Не корректный номер.";
				$respone['result'] = 0;
				echo json_encode($respone);
				exit;
			}
		}else{
			$respone['result'] = 0;
			$respone['messages'][] = "Введите свой номер.";
		}


	}else{
		$respone['message'][] = "this`s bad request";
		echo json_encode($respone);
		exit;
	}

	$url = "http://synergy.ru/lander/alm/lander.php?r=land/index&unit=synergy&type=test";
	
	$c = curl_init();

	$post_data = array (  
    	"name" => $name,  
    	"phone" => $tel,  
    	"email" => $email  
	);

	curl_setopt($c, CURLOPT_URL, $url);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_POST, 1);
	curl_setopt($c, CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($c); 
	curl_close($c);

	$respone['result'] = 1;
	$respone['culr_output'] = $output;

	echo json_encode($respone);
	exit;

?>