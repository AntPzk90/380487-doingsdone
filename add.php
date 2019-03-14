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

	$task = $_POST;
	$required_fields = ["title"];
	$dict = ["title" => "Название", "name_project" => "Проект", "deadline" => "Дата выполнения"];
	$errors = [];

	if(!empty($task["deadline"])){
		// сохраняем дату в формате дд.мм.гггг
		$calendar_format = $task["deadline"];
		//форматируем дату в формат указаныйв ТЗ перед отправкой
		$date_form_create = date_create_from_format("d.m.Y", $task["deadline"]);
		$date_form = date_format($date_form_create, 'Y-m-d');
		//проверка разници во времени
		$now_date = date('d.m.Y');
		$deadline_date = date('d.m.Y', strtotime($task["deadline"]));
		$unix_now_date = strtotime($now_date);
		$unix_deadline_date = strtotime($deadline_date);
		$date_result = ($unix_deadline_date - $unix_now_date) / 3600;
		if($date_result < 0){
			$error_date_massage = "вы указали прошедшую дату";
			//вносим в массив с ошибками ошибку даты.
			$errors["date_error"] = $date_form;
		}
	}else{
		$date_form = date('Y-m-d');
	}

	foreach ($required_fields as $field) {
		if (empty($_POST[$field])) {
            $errors[$field] = "Заполните это поле";
		}
	}
	//перемещение 
	if (isset($_FILES['preview']['name'])) {
		$tmp_name = $_FILES['preview']['tmp_name'];
		$path = $_FILES['preview']['name'];
		$task_file = move_uploaded_file($tmp_name, 'uploads/' . $path);
		$task['path'] = $path;
	}
	//текст ошибок
	$name_task_error = "Заполните это поле, &quot;Название проекта&quot; обязательно к заполнению.";
	$date_task_error = "Вы указали прошедшую дату";
	if(count($errors)){
		$page_content = include_template("add.php", ["tasks" => $tasks, "projects" => $projects, "errors" => $errors,"date_result" => $date_result, "date_task_error" => $date_task_error, "name_task_error" => $name_task_error, "date" => $calendar_format]);
		$layout_content = include_template("layout.php", ["projects" => $projects, "content" => $page_content, "tasks" => $tasks, "title" => "Добавление задачи"]);
		print($layout_content);

	}else{
		//если нет ошибок то перееадресовать пользователя на гл. стр. и отправить таск в БД
			$_name = $task['name_project'];
			//уздаём id проекта для отправки в БД tasks
			$sql = "SELECT id FROM projects WHERE '$_name' = name_project";
			$result = mysqli_query($config_sql, $sql);
			$id_project = mysqli_fetch_array($result, MYSQLI_ASSOC);
			//формируем запрос для отправки в бд tasks
			$sql = "INSERT INTO tasks (title, deadline, id_user, id_project, file)
					VALUES (?, ?, ?, ?, ?)";
			$stmt = db_get_prepare_stmt($config_sql, $sql, [$task['title'], $date_form, $session_user_id, $id_project[id], $path]);
        	$result = mysqli_stmt_execute($stmt);
			if($sql){
				// заголовок для перенаправления пользователя
				header("location: index.php");
			}
	}

}else{
	$page_content = include_template("add.php", ["tasks" => $tasks, "projects" => $projects]);
	$layout_content = include_template("layout.php", ["projects" => $projects, "content" => $page_content, "tasks" => $tasks,"user_name" => $_user_name, "title" => "Добавление задачи"]);

print($layout_content);
}
