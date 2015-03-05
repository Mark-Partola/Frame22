<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>Авторизация</h1>
	<form action="<?=$_SERVER['REDIRECT_URL']?>" method="POST">
		<input type="text" name="login">
		<input type="password" name="password">
		<input type="submit" value="Войти">
	</form>
</body>
</html>