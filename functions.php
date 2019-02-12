<?php
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function projects_count($category_name, $tasks) {
    $shift = 0;
        foreach($tasks as $val) { 
        
        if ($val['category'] == $category_name) {
            $shift++;    
        }
        
    }
    return $shift;
};
/**
 * ф-ция считает количество задач в конкретной категории
 * @param {string} $category_name - название текущей категории
 * @param {Arary} $tasks - все задачи для текущего пользователя
 * @return {integer} количество задач в категории
 */
/*не придумал где оставить данные про часовой пояс*/
date_default_timezone_get("Europe/Moscow");
setlocale(LC_ALL, "ru_RU");

function days_counter($end_date){
    $tsk_dt_end = $end_date;
    $dt_now = date('d.m.Y');
    $dt_end = $tsk_dt_end;
    $unix_dt_now = strtotime($dt_now);
    $unix_dt_end = strtotime($dt_end);
    $left_days = ($unix_dt_end - $unix_dt_now) / 3600;
    return $left_days;
}
/**
 * ф-ция считает количество оставшихся дней до определённой пользователем даты
 * @param {string} $end_date - конечная дата выполнения задачи
 * @return {integer} ост. количество дней до конечной даты
 */
?>