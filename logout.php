<?php
require_once("config.php");
require_once("functions.php");
//выход и переадресация на главную
unset($_SESSION["user"]);
header("location: index.php");
?>