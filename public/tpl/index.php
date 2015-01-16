<?=$header?>

<div id="content" class="mp">
	<h1 class="header">Каталог книг</h1>
	<div id="main_block">
		<div class="mp_books">
			<?foreach($books as $book): ?>
				<div class="book">
					<a href="<?=ROUTE_ROOT?>/book/<?=$book['id']?>" class="link_book">
					<h2 class="book_title"><?=$book['title']?></h2>
					<div class="book_info">
						<img src="<?=ROUTE_ROOT.$book['image_preview']?>" alt="<?=$book['title']?>" width="120px">
						<div>
							<p><?=$book['author']?></p>
							<p><?=$book['pub_year']?></p>
						</div>
					</div>
					</a>
					<button class="btn order_book" data-book-id="<?=$book['id']?>">Добавить</button>
				</div>
			<?endforeach?>
			<div style="clear:both;"></div>
		</div>
	</div>
	<div id="right_block">
		<div class="fixed">
			<h3 class="header_small">Параметры каталога</h3>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>

<?=$footer?>