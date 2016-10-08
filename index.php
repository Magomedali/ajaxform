<?php
header("Content-type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Тестовое задание</title>
	<style>.feedback{width:320px;margin:100px auto;border:1px solid #ccc;padding:10px}.field{margin:20px}.field label,small{display:block}.warning{color:red}.succes{color:#0f0}.serverErrors{padding:0;margin:0}.serverErrors li{margin-top:0;padding-left:30px;font-size:11px;color:red;list-style:none}.answer{margin:10px 0 5px;color:#0f0}</style>
	<script src="https://code.jquery.com/jquery-2.x-git.js"></script>
	<script src="script.js"></script>
</head>
<body>
	<div class="feedback">
		<h1>Тестовое задание</h1>
		<form action="ajax.php" method="POST">
			<div class="field">
				<label for="name">Имя</label>
				<input type="name" name="name" id="name" autofocus required>
			</div>
			<div class="field">
				<label for="tel">Телефон</label>
				<input type="tel" name="tel" id="tel" required>
			</div>
			<div class="field">
				<label for="email">E-mail</label>
				<input type="email" name="email" id="email" required>
			</div>
			<div class="field submit">
				<input type="submit" value="Отправить">
			</div>
		</form>
	</div>
</body>
</html>