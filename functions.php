<?php
//виключення sql-інєкцій!!!
	//очистка даних
	function clearData($var) {
		$var = trim(mysql_real_escape_string($var)); //trim удаляємо пробіли з ліва і з права. mysql_real_escape_string - так як дані тільки текстові
		return $var;
	}

	//очистка даних для клієнта
	function clearDataClient($var){
		$var = htmlspecialchars($var);

		return $var;
	}

	//Додавання повідомлень
	function AddPost($name, $email, $msg){
		$name = clearData($name);
		$email = clearData($email);
		$msg = clearData($msg);
	//якщо не вказано в полі ім'я нічого, то ми ставимо по дефолту значення Гість	
			if (empty($name)) $name = 'Гість';
	//якщо не вказано в полі e-mail нічого, то ми ставимо по дефолту "E-mail не вказаний!"	
			if (empty($email)) $email = '[E-mail не вказаний!]';
	//передача інформації в базу даних
			if (!empty($msg)) {
				$query = "INSERT INTO P_Info (Name, Email, Post) VALUES ('$name', '$email', '$msg')"; 
				mysql_query($query);
	//перевірка на заповнення поля коментаря
			if (mysql_affected_rows() > 0) {
				$res = "Повідомлення добавлено!";
			} else {
				$res = "Помилка!";
			} 
		} else {
			$res = FALSE;
		}
		return $res;
	}

	//вибір повідомлень
	function selectAll(){
		$posts = array(); //якщо не оголосити змінну як масив, то foreach свариться при відсутності інфи в БД!!!
		//реалізовано вивід коментарів до даті додавання і вивід тільки годин і хвилин!
		$query = "SELECT id, Name, Email, Post, LEFT(date, 16) AS date FROM P_Info ORDER BY date DESC";
		$res = mysql_query($query);
		//масив для збереження даних з БД!
		while ($row = mysql_fetch_assoc($res)) {
			$posts[] = $row; 
		}
		return $posts;
	}

	//видалення повідомлень
	function deletePost($id){
		$id = (int)$id;
		$query = "DELETE FROM P_Info WHERE id = $id";
		mysql_query($query);
	}

	//теги для редагування тексту і смайли!
	function bbTags($var){
		$bb = array(':)', ';)', '[B]', '[/B]'); //те що хочемо замінити
		$tag = array('<img src = "smiles/1.gif">', '<img src = "smiles/2.gif">', '<b>', '</b>'); //на що будемо заміняти!!!

		return str_ireplace($bb, $tag, $var); //srt_ireplace не враховує регістр на відміну від srt_replace!!!
	}
?>