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
?>

<?php
			$posts = selectOne();
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