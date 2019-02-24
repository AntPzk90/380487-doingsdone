<?php
date_default_timezone_get("Europe/Moscow");
setlocale(LC_ALL, "ru_RU");

$config_sql = mysqli_connect("localhost", "root", "", "doingsdone");
mysqli_set_charset($config_sql, "utf8");