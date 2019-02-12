<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

require_once ("data.php");
require_once ("functions.php");

$page_content = include_template("index.php", ["tasks" => $tasks, "show_complete_tasks" => $show_complete_tasks]);

$layout_content = include_template("layout.php", ["projects" => $projects, "content" => $page_content, "tasks" => $tasks, "title" => "Дела в порядке"]);

print($layout_content);
?>
