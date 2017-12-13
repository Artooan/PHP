<?php 

	//Підключення до БД
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'Guest_Page');
	define('ERROR', 'Заповніть поле коментарів!');
	define('ADMIN', 'admin');
	define('PASS', '827ccb0eea8a706c4c34a16891f84e7b'); //пароль: 12345
	define('ERROR', 'Заповніть поле коментування!');

	mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Немає з'єднання з сервером!");
	mysql_select_db(DB_NAME) or die("немає підключення до БД!");

	mysql_query("SET NAMES 'utf8'"); //Кодіровка
?>