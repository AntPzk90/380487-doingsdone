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
/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}
/**
* получаем данные из БД
*
* @param $sql запрос
* @param $con ресурс соединения
*
* @return $data массив с даными
*/
function get_data_from_sql($sql,$con){

    $result = mysqli_query($con, $sql);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $data;
}
/**
* выполняет фильтрацию задач по дате
*
* @param $now_date дата в данный момент
* @param $arr массив для фитьтрации
*
* @return $date_tasks отфильрованные задачи по дате
*/
function overlure($arr){

    $now_date = date('Y-m-d');
    foreach ($arr as $elem) {
        if($now_date > $elem['deadline']){
            $date_tasks[] = $elem;
        }
    }
    return $date_tasks;
}
/**
* выполняет фильтрацию задач по дате
*
* @param $now_date дата в данный момент
* @param $arr массив для фитьтрации
*
* @return $date_tasks отфильрованные задачи по дате
*/
function today($arr){

    $now_date = date('Y-m-d');
    foreach ($arr as $elem) {
        if($now_date == $elem['deadline']){
            $date_tasks[] = $elem;
        }
    }
    return $date_tasks;
}
/**
* выполняет фильтрацию задач по дате
*
* @param $now_date дата в данный момент
* @param $arr массив для фитьтрации
*
* @return $date_tasks отфильрованные задачи по дате
*/
function tomorow($arr){

    $now_date = date('Y-m-d');
    foreach ($arr as $elem) {
        $unix_now_date = strtotime($now_date);
        $unix_deadline_date = strtotime($elem['deadline']);
        $date_result = ($unix_deadline_date - $unix_now_date) / 3600;
        if($date_result >= 24 && $date_result <= 48){
            $date_tasks[] = $elem;
        }
    }
    return $date_tasks;
}

?>