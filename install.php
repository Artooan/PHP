<?php
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'Guest_Page');
?>

<p>Підключаємося до сервева БД...</p>

<?php
	mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Немає з'єднання з сервером!");
?>

<p>Підключення до БД виконано!</p>
<p>Створюємо базу даних.</p>

<?php
	//if not exists - якщо БД немає, то її створить, а якщо вона є, то повторно її створювати не буде!!!
	$query = "CREATE DATABASE IF NOT EXISTS ".DB_NAME." DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

	if (!mysql_query($query)) die("Не вдалося створити БД.");
	mysql_select_db(DB_NAME) or die("Немає підключення з базою даних.") ;
?>

<p>База даних створена!</p>
<p>Створюємо необхідні таблиці...</p>

<?php
	$query = "CREATE TABLE `P_Info` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Post` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if (!mysql_query($query)) die("Не вдалося створити таблицю.");
?>	

<p>Установка завершена. Не забудьте удалити файл install.php</p>