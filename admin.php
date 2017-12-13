<?php

session_start();
require_once 'config.php';

// блок виходу адміна
if($_GET['do'] == 'exit'){
	unset($_SESSION['admin']);
	session_destroy();
	header("Location: ".$_SERVER['PHP_SELF']);
	exit;
}

// блок авторизації
if($_POST['submit']){
	//перевірка отриманих даних з полів
	if(trim($_POST['name']) == ADMIN AND trim(md5($_POST['pass'])) == PASS){
		$_SESSION['admin'] = ADMIN;
		$_SESSION['ok'] = "<p>Вітаю, {$_SESSION['admin']}! <a href='./index.php'>В гостьову</a> | <a href='?do=exit'>Вихід</a></p>";
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
	}else{
		$_SESSION['error'] = "<p>Неправильний логін і/або пароль</p>";
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Гостьова книга</title>
	<link rel="stylesheet" rev="stylesheet" type="text/css" href="style.css"  />
</head>
<body>
	<?php
		if(!$_SESSION['admin']){
	?>

		<form class="admin_login" method="post">
			<p class="name"><input type="text" name="name" /> <label for="name"> Логін </label></p>
			<p class="pass"><input type="password" name="pass" /> <label for="pass"> Пароль </label></p>
			<p class="send"><input type="submit" name="submit" value="Войти" /></p>
			
		<?php
			echo $_SESSION['error'];
			unset($_SESSION['error']);
		?>
		
		</form>

	<?php
		}else{
			echo '<div class="admin_login">';
			echo $_SESSION['ok'];
			echo '</div>';
		}
	?>

</body>
</html>