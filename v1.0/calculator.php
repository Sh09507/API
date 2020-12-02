<?php
	
	$headers = apache_request_headers();
		// var_dump($headers);
		
	$token = $headers['Authorization'];
		
		if ($token !== 'Basic kiibo') {
			http_response_code(401);
			exit();
		}
	#Only handle GET requests
	if($_SERVER['REQUEST_METHOD'] == 'GET') {
		
		#Grab the numbers and operation
		$num1 = $_GET['num1'];
		$num2 = $_GET['num2'];
		$op = $_GET['operation'];
		
		#validate the input
		if ($op === "+" || $op === "-" || $op === "*" || $op === "/" || $op === "**"){
			#Do math
			$n1 = floatval($num1);
			$n2 = floatval($num2);
			
			$result = Null;
			switch($op){
				case "+":
					$result = $n1 + $n2;
					break;
				case "-":
					$result = $n1 - $n2;
					break;
				case "*":
					$result = $n1 * $n2;
					break;
				case "/":
					$result = $n1 / $n2;
					break;
				case "**":
					$result = $n1 ** $n2;
					break;
			}
			
			if ($result !== Null){
				echo $result;
			} else {
				#Not sure how I got here, but...
				http_response_code(500);
			}
		}else {
			http_response_code(400);
			exit();
		}
		
	} else if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
		#Don't do anything
		exit();
	}else {
		http_response_code(405);
		exit();
	}
		
?>