<?php
require_once("config.php");
require_once("functions.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$user_auth = $_POST;
	$required_fields = ["email",  "password"];
	$errors =[];
	//проверка на заполнение поля
	foreach ($required_fields as $field) {
		if (empty($user_auth[$field])) {
            $errors[$field] = "Заполните это поле ". $field;
		}
	}
	$email = mysqli_real_escape_string($config_sql, $user_auth["email"]);
	$sql = "SELECT id, email, password FROM users WHERE email = '$email'";
	$result = mysqli_query($config_sql, $sql);
	$user = $result ? mysqli_fetch_array($result, MYSQLI_ASSOC) : null;

	if (!count($errors) && $user){
			if (password_verify($user_auth['password'], $user['password'])) {
				$_SESSION['user'] = $user;
			}else {
				$errors['password'] = 'Неверный пароль';
			}
		}else{
			if(!filter_var($user_auth["email"],FILTER_VALIDATE_EMAIL)){
			$errors["email"] = "некорректный email";
			}
			$errors['email'] = 'Такой пользователь не найден';
		}
	
	if (count($errors)) {
		$page_content = include_template("auth.php", ["errors" => $errors, "user_auth" => $user_auth]);
		$layout_content = include_template("enter-register-layout.php", ["page_content" => $page_content, "title" => "Авторизация"]);
		print($layout_content);
	}else{
		header("location: index.php");
		print("kljlk");
	}
}
	$page_content = include_template("auth.php", []);
	$layout_content = include_template("enter-register-layout.php", ["page_content" => $page_content, "title" => "Авторизация"]);
	print($layout_content);
?>