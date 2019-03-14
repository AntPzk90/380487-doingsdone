<?php
require_once('functions.php');
require_once('config.php');

if(!empty($_SESSION["user"])){
	$session_user_id = $_SESSION["user"]["id"];
}else{
	$session_user_id = 0;
}

//массив с проэктами
$sql = "SELECT p.id, p.name_project, p.id_user FROM projects p WHERE p.id_user = '$session_user_id'";
$projects = get_data_from_sql($sql,$config_sql);
//массив с задачами
$sql = "SELECT t.title, t.status, t.deadline, p.name_project, t.id_project, t.file FROM tasks t JOIN projects p ON t.id_project = p.id WHERE t.id_user = '$session_user_id'";
$tasks = get_data_from_sql($sql,$config_sql);
//имя пользователя
$sql = "SELECT u.name FROM users u WHERE u.id = '$session_user_id'";
$user_name = get_data_from_sql($sql,$config_sql);

$_user_name = $user_name[0]["name"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$project = $_POST;
	$required_fields = ["name"];
	$errors = [];

	foreach ($required_fields as $field) {
		if (empty($project[$field])) {
            $errors[$field] = "Заполните это поле ";
		}
	}

	if(empty($errors)){
		$_name_project = $project["name"];
		$sql = "INSERT INTO projects (name_project, id_user)
				VALUES (?, '$session_user_id')";
		$stmt = db_get_prepare_stmt($config_sql, $sql, [$project["name"]]);
        $result = mysqli_stmt_execute($stmt);
		if($sql){
			// заголовок для перенаправления пользователя на страницу входа
			header("location: index.php");
		}
	}
	
}
$page_content = include_template("add_project.php", ["tasks" => $tasks, "projects" => $projects, "errors" => $errors]);
$layout_content = include_template("layout.php", ["projects" => $projects, "content" => $page_content, "tasks" => $tasks,"user_name" => $_user_name, "title" => "Добавление проэкта"]);

print($layout_content);
?>