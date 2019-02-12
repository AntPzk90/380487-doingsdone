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
?>