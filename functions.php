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
/**
 * ф-ция считает количество задач в конкретной категории
 * @param {string} $category_name - название текущей категории
 * @param {Arary} $tasks - все задачи для текущего пользователя
 * @return {integer} количество задач в категории
 */
function projects_count($category_name, $tasks) {
    $shift = 0;
        foreach($tasks as $tasks_item){ 
        
        if ($tasks_item['name_project'] == $category_name) {
            $shift++;    
        }
        
    }
    return $shift;
};
/**
 * ф-ция считает количество оставшихся дней до определённой пользователем даты
 * @param {string} $end_date - конечная дата выполнения задачи
 * @return {integer} ост. количество дней до конечной даты
 */
function days_counter($end_date){
    $dt_now = date('d.m.Y h:i:s a');
    $unix_dt_now = strtotime($dt_now);
    $unix_dt_end = strtotime($end_date);
    $left_hours = ($unix_dt_end - $unix_dt_now) / 3600;
    return $left_hours;
}
?>