<?php
// показывать или нет выполненные задачи
require_once("config.php");
require_once("functions.php");

if(!empty($_SESSION["user"])){
	$session_user_id = $_SESSION["user"]["id"];
}else{
	$session_user_id = 0;
}

$show_complete_tasks = 0;
if(isset($_GET['show_completed'])){
	if($_GET['show_completed'] == 1){
		$show_complete_tasks = 1;		
	} else {
		$show_complete_tasks = 0;
	}
}

if(isset($_GET['task_id']) and isset($_GET['check'])){
	if ($_GET['check'] == 0) {
            $sql = "UPDATE tasks SET status = 0 WHERE id = '$_GET[task_id]'";
        } 
    if ($_GET['check'] == 1) {
            $sql = "UPDATE tasks SET status = 1 WHERE id = '$_GET[task_id]'";
        }
    $result = mysqli_query($config_sql, $sql);
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

if(!empty($_GET['id']))
{
	$project_id = $_GET['id'];
	$project_id = substr($project_id, 0, -1);
	$sql = "SELECT * FROM tasks t WHERE t.id_project = $project_id";
	$result_task = mysqli_query($config_sql, $sql);
	$tasks_filtered = mysqli_fetch_all($result_task, MYSQLI_ASSOC);
} elseif ($_GET["id"] == NULL) {
	$sql = "SELECT * FROM tasks t WHERE t.id_user = '$session_user_id'";
	$result_task = mysqli_query($config_sql, $sql);
	$tasks_filtered = mysqli_fetch_all($result_task, MYSQLI_ASSOC);
}

$tasks_filtered_date = $tasks_filtered;

if($_GET['all']){
	$tasks_filtered_date = $tasks_filtered;
} elseif($_GET['today']){
	$tasks_filtered_date = today($tasks_filtered);
} elseif($_GET['tomorow']){
	$tasks_filtered_date = tomorow($tasks_filtered);
} elseif($_GET['overdue']){
	$tasks_filtered_date = overlure($tasks_filtered);
}

if(!isset($_SESSION["user"])){
	$layout_content = include_template("guest.php", ["title" => "Дела в порядке"]);
}else{
	$page_content = include_template("index.php", ["tasks" => $tasks_filtered_date, "show_complete_tasks" => $show_complete_tasks]);

	$layout_content = include_template("layout.php", ["projects" => $projects, "content" => $page_content, "tasks" => $tasks, "user_name" => $_user_name, "title" => "Дела в порядке"]);
}
print($layout_content);
?>