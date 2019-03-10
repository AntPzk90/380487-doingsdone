<?php
require_once("config.php");
require_once("functions.php");


if($_SERVER["REQUEST_METHOD"] == "POST"){
	$user_reg = $_POST;
	$required_fields = ["email",  "password", "name"];
	$errors =[];
	//проверка на заполнение поля
	foreach ($required_fields as $field) {
		if (empty($user_reg[$field])) {
            $errors[$field] = "Заполните это поле ". $field;
		}
	}
	//валидация поля email
	if(!empty($user_reg["email"])){
		if(!filter_var($user_reg["email"],FILTER_VALIDATE_EMAIL)){
			$errors["email"] = "некорректный email";
		}else{
			$email = mysqli_real_escape_string($config_sql, $user_reg['email']);
        	$sql = "SELECT id FROM users WHERE email = '$email'";
        	$result_user_reg = mysqli_query($config_sql, $sql);
        	if(mysqli_num_rows($result_user_reg) > 0){
        		$errors["email"] = "Пользователь с этим email уже зарегистрирован";
        	}
		}
	}
	if(empty($errors)){
		$_name = $user_reg["name"];
		$_email = $user_reg["email"];
		$_password = password_hash($user_reg['password'], PASSWORD_DEFAULT);
		$sql = "INSERT INTO users (email, password, name)
				VALUES ('$_email', '$_password', '$_name')";
		$result = mysqli_query($config_sql, $sql);
		if($sql){
			// заголовок для перенаправления пользователя на страницу входа
			header("location: auth.php");
		}
	}
}

$page_content = include_template("register.php", ["errors" => $errors]);
$layout_content = include_template("enter-register-layout.php", ["page_content" => $page_content, "title" => "Регистрация"]);
print($layout_content);
?>