<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title><?=$title?></title>
	<link rel="shortcut icon" href="<?=ROUTE_ROOT?>/images/favicon.png">
	<link rel="stylesheet" href="<?=ROUTE_ROOT?>/css/reset.css">
	<link rel="stylesheet" href="<?=ROUTE_ROOT?>/css/main.css">
	<script type="text/javascript" src="<?=ROUTE_ROOT?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?=ROUTE_ROOT?>/js/common.js"></script>
	<script>
		$(document).ready(function(){
			$('#exit').on('click', function(){
				$.get("/library/public/logout");
			});
		});
	</script>
</head>
<body>

<div class="wrapper">
	<div id="header">
		<img src="<?=ROUTE_ROOT?>/images/header.jpeg">
		<div id="logo"><b>Sharaga`s Book</b></div>
		<div id="top_nav" class="nav">
			<ul class="right">
				<?if(isset($_SESSION['user']) && !empty($_SESSION['user'])) : ?>
					<li><a class="user_ico" href="<?=ROUTE_ROOT.'/logout'?>">Выход</a></li>
				<?else:?>
					<li><a class="user_ico" href="<?=ROUTE_ROOT.'/login'?>">Вход</a></li>
				<?endif?>
			</ul>
			<ul>
				<li class="rb"><a href="<?=ROUTE_ROOT?>" class="home_ico">Главная</a></li><li class="lb"><a href="<?=ROUTE_ROOT?>/profile">Моя страница</a></li>
			</ul>
		</div>
	</div>