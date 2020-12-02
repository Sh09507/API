<?php
    $headers = apache_request_headers();
    
    $token = $headers['Authorization'];
    
    if ($token !== 'Basic alskdjgaedaertgjasdgj') {
        http_response_code(401);
        exit();
    }
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    if (array_key_exists('mem', $_COOKIE)) {
        echo $_COOKIE['mem'];
        exit();
    } else {
        echo "0";
        exit();
    }

} else if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
    exit();

} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (array_key_exists('val', $_POST)) {
        $val = $_POST['val'];
        setcookie('mem', $val);
        echo $val;
        exit();
    } else {
        http_response_code(400);
        exit();
    }

} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $current = 0;
    if (array_key_exists('mem', $_COOKIE)) {
        $current = $_COOKIE['mem'];
    }
    
    $putdata = fopen("php://input", "r");
    $buffer = "";
    while ($data = fread($putdata, 1024)) {
        $buffer .= $data;
    }
    if ($buffer !== "") {
        $val = 0;
        $json = json_decode($buffer);
        if (isset($json->val)) {
            $val = $json->val;
            $val = $val + $current;
            setcookie('mem', $val);
            echo $val;
            exit();
        } else {
            http_response_code(400);
            exit();
        }
    } else {
        http_response_code(400);
        exit();
    }

} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    setcookie("mem", "", time() - 3600);
    exit();

} else {
    http_response_code(405);
    exit();
}
?>