<?php
$projects = [
    "incom" => "Входящие",
    "study" => "Учеба",
    "job" => "Работа",
    "home" => "Домашние дела",
    "auto" =>"Авто"
];
$tasks = [
    [
        "task" => "Собеседование в IT компании",
        "date" => "17.02.2019",
        "category" => $projects["job"],
        "completed" => false
    ],
    [
        "task" => "Выполнить тестовое задание",
        "date" => "25.12.2019",
        "category" => $projects["job"],
        "completed" => false
    ],
    [
        "task" => "Сделать задание первого раздела",
        "date" => "21.12.2019",
        "category" => $projects["study"],
        "completed" => true
    ],
    [
        "task" => "Встреча с другом",
        "date" => "22.12.2019",
        "category" => $projects["incom"],
        "completed" => false
    ],
    [
        "task" => "Купить корм для кота",
        "date" => null,
        "category" => $projects["home"],
        "completed" => false
    ],
    [
        "task" => "Заказать пиццу",
        "date" => null,
        "category" => $projects["home"],
        "completed" => false
    ]
];
?>