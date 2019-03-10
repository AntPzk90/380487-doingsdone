use doingsdone;
INSERT INTO users (email, password, name) 
VALUES 
("paziukAnatolii@gmail.com", "1234", "Anatolii"),
("paziukAlexey@gmail.com", "1324", "Aleksey");

INSERT INTO projects (name_project, id_user)
VALUES 
("Входящие", 1),
("Учеба", 1),
("Работа", 1),
("Домашние дела", 1),
("Авто", 1);

INSERT INTO tasks (status, title, file, deadline, id_user, id_project )
VALUES
(0, "Собеседование в IT компании", "", "12.02.2019", 3, 3),
(0, "Выполнить тестовое задание", "", "25.12.2019", 3, 3),
(1, "Сделать задание первого раздела", "", "21.12.2019", 3, 2),
(0, "Встреча с другом", "", "22.12.2019", 1, 1),
(0, "Купить корм для кота", "", "", 1, 4),
(0, "Заказать пиццу", "", "", 2, 4);

/*получить список из всех проектов для одного пользователя*/
SELECT t.title FROM tasks t WHERE t.id_user = 1;
/*получить список из всех задач для одного проекта*/
SELECT t.title FROM tasks t WHERE t.id_project = 3;
/*отметить задачу как выполненную*/
UPDATE tasks SET status = 1 WHERE id = 1;
/*обновить название задачи по её идентификатору*/
UPDATE tasks SET title = 'Покормил кота' WHERE id = 6;