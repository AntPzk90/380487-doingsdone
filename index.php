<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

require_once("config.php");
require_once("functions.php");

//массив с проэктами
$sql = "SELECT p.id, p.name_project, p.id_user FROM projects p ";
$result = mysqli_query($config_sql, $sql);
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
//массив с задачами
$sql = "SELECT t.title, t.status, t.deadline, p.name_project, t.id_project, t.file FROM tasks t JOIN projects p ON t.id_project = p.id WHERE t.id_user = 1";
$result_task = mysqli_query($config_sql, $sql);
$tasks = mysqli_fetch_all($result_task, MYSQLI_ASSOC);

if(!empty($_GET['id']))
{
	$project_id = $_GET['id'];
	$project_id = substr($project_id, 0, -1);
	$sql = "SELECT * FROM tasks t WHERE t.id_project = $project_id";
	$result_task = mysqli_query($config_sql, $sql);
	$tasks_filtered = mysqli_fetch_all($result_task, MYSQLI_ASSOC);
} elseif ($_GET["id"] == NULL) {
	$sql = "SELECT * FROM tasks";
	$result_task = mysqli_query($config_sql, $sql);
	$tasks_filtered = mysqli_fetch_all($result_task, MYSQLI_ASSOC);
}

$page_content = include_template("index.php", ["tasks" => $tasks_filtered, "show_complete_tasks" => $show_complete_tasks]);

$layout_content = include_template("layout.php", ["projects" => $projects, "content" => $page_content, "tasks" => $tasks, "title" => "Дела в порядке"]);

print($layout_content);
?>