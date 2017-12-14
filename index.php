<?php

	session_start(); //відкриваємо сесію для того щоб виключити проблему з f5!

	require_once 'config.php'; //підключення фалів
	require_once 'functions.php'; //підключення фалів
//видалення коментаря
	if ($_SESSION['admin']) {
		$del = "Видалити";

		if (isset($_GET['id'])) {
			deletePost($_GET['id']);
			header("Location: " .$_SERVER['PHP_SELF']);
			exit;
		}
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$res = AddPost($_POST['name'], $_POST['email'], $_POST['msg']);
	//якщо отримали істину при передачі
		if ($res) {
			$_SESSION['res'] = $res;
			//header("Location: " .$_SERVER['PHP_SELF']); //перезагрузка сторінка 
			//Эту строку мы получим как ответ от сервера при использовании AJAX
			echo $_SESSION['res'];
			exit; //завершення скріпта
		} else { //якщо поле коментаря не заповнили!
			$_SESSION['res'] = ERROR;
			//Эту строку мы получим как ответ от сервера при использовании AJAX
			echo $_SESSION['res'];
			$_SESSION['name'] = clearDataClient($_POST['name']); //якщо заповнили поле імені, але забули про коментар, то поле імені памятає введені дані!
			$_SESSION['email'] = clearDataClient($_POST['email']); //так само і з полем email!
			//header("Location: " .$_SERVER['PHP_SELF']); //перезагрузка сторінка
			exit; //завершення скріпта 
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/G_P.js"></script>
	<link rel="stylesheet" type="text/css" href="jquery-ui.css">
	<title>Гостьова книга</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<!--Шрифти з google.com/fonts-->
	<link href="https://fonts.googleapis.com/css?family=Indie+Flower|Josefin+Sans|Quicksand" rel="stylesheet">
</head>
<body>
	<div id="general">
		<h2> Гостьова книга </h2>

		<p class="open">Додати повідомлення</p>

		<div id="add_Msg"></div>

		<div id="form_style" title="Нове повідомлення">
			
			<form id="mainform" action="" method="post">
				<p class="name">
					<input id="name" type="text" name="name" value="<?php echo $_SESSION['name'] ?>" />
					<label for="name">Ім'я</label>
				</p>
				
				<p class="email">
					<input id="email" type="text" name="email" value="<?php echo $_SESSION['email'] ?>" />
					<label for="email" >E-Mail</label>
				</p>
				
				<p class="msg">
					<textarea id="msg" name="msg" ></textarea>
				</p>
				
				<input name="send" type="hidden"  />
		<!--Не використовуємо оскільки працювати будемо з jquery!!!-->		
				<!--<p class="send" >
					<input type="submit" name="submit" value="Відправити"/>
				</p>-->
			</form>
		</div>

		<div id="new_Msg"></div>

			<?php
				unset($_SESSION['res']);
				unset($_SESSION['name']);
				unset($_SESSION['email']);
			?>

			<?php
				$posts = selectAll();
				foreach ($posts as $post) {
			?>
				<div class="msg_container">
					<div class = "msg_header">
						<b><?php echo clearDataClient($post['Name'])?></b> <?php echo clearDataClient($post['Email'])?>
					</div>
				
					<div class = "msg_body">
						<?php echo nl2br(bbTags(clearDataClient($post['Post']))) ?> <!--заміняє переноси на тег <br>-->
					</div>

					<div class = "msg_footer">
						Комментар добавлений: <?php echo $post['date']?> <strong><a href="?id=<?php echo $post['id']?>"><?php echo $del ?></a></strong>
					</div>
				</div>
			<?php		
				}
			?>
	</div>
</body>
</html>