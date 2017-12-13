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

	if ($_POST['submit']) {
		$res = AddPost($_POST['name'], $_POST['email'], $_POST['msg']);
	//якщо отримали істину при передачі
		if ($res) {
			$_SESSION['res'] = $res;
			header("Location: " .$_SERVER['PHP_SELF']); //перезагрузка сторінка 
			exit; //завершення скріпта
		} else { //якщо поле коментаря не заповнили!
			$_SESSION['res'] = ERROR;
			$_SESSION['name'] = clearDataClient($_POST['name']); //якщо заповнили поле імені, але забули про коментар, то поле імені памятає введені дані!
			$_SESSION['email'] = clearDataClient($_POST['email']); //так само і з полем email!
			header("Location: " .$_SERVER['PHP_SELF']); //перезагрузка сторінка
			exit; //завершення скріпта 
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Гостьова книга</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="general">
	<h2> Гостьова книга </h2>
		<form id="mainform" action="" method="post">
			<p class="name">
				<input type="text" name="name" value="<?php echo $_SESSION['name'] ?>" />
				<label for="name">Ім'я</label>
			</p>
			
			<p class="email">
				<input type="text" name="email" value="<?php echo $_SESSION['email'] ?>" />
				<label for="email" >E-Mail</label>
			</p>
			
			<p class="msg">
				<textarea name="msg" ></textarea>
			</p>
			
			<input name="send" type="hidden"  />
			
			<p class="send" >
				<input type="submit" name="submit" value="Відправити"/>
			</p>
		</form>

		<?php
			echo $_SESSION['res'];
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
					<?php echo nl2br(clearDataClient($post['Post']))?> <!--заміняє переноси на тег <br>-->
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