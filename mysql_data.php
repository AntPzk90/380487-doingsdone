<?php
//массив с проэктами
$sql = "SELECT p.name_project FROM projects p WHERE p.id_user = 1";
$result = mysqli_query($config_sql, $sql);
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
//массив с задачами
$sql = "SELECT t.title, t.status, t.deadline, p.name_project FROM tasks t JOIN projects p ON t.id_project = p.id WHERE t.id_user = 1";
$result_task = mysqli_query($config_sql, $sql);
$tasks = mysqli_fetch_all($result_task, MYSQLI_ASSOC);