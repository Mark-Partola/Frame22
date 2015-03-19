<article style="width: 700px;">
	<h3 style="margin:20px; font-size: 20px;">Редактирование элемента</h3>
	<div class="module_content">
		<fieldset class="j-register">
			<div class="module_content-field">
				<label>Заголовок</label>
				<input type="text" name="title" placeholder="Имя" value="<?=$_POST['title']?>">
			</div>
			<div class="module_content-field">
				<label>Контент</label>
				<textarea name="content" rows="10" style="width: 85%; float: none; padding: 5px;"><?=$_POST['content']?></textarea>
			</div>
			<div class="module_content-field">
				<input type="button" value="Сохранить" class="button" id="j-update-elem">
			</div>
		</fieldset>
	</div>
</article>