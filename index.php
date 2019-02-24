<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

/*require_once ("data.php");*/
require_once ("config.php");
require_once ("functions.php");
require_once("mysql_data.php");

$page_content = include_template("index.php", ["tasks" => $tasks_sql, "show_complete_tasks" => $show_complete_tasks]);

$layout_content = include_template("layout.php", ["projects" => $projects_sql, "content" => $page_content, "tasks" => $tasks_sql, "title" => "Дела в порядке"]);

print($layout_content);
?>