<?header("Cache-Control: no-store")?>
<article style="width: 700px;">
	<h3 style="margin:20px; font-size: 20px;">Выбор изображения</h3>
	<div class="module_content">
		<fieldset style="padding:20px;">
			<div class="module_content-field">
				<header><h2 style="text-align: center; color: #444;" class="j-head">Главное изображение элемента</h2></header>
			</div>
			<div class="module_content-field galery-container">
				<!--div class="container">
					<label><input type="radio" name="choice" value="1">
					<img class="galery" src="/frame-22-22/public/imgs/uploads/196-12a2779bbf0c7a64c79e13f4cdfc1446.jpg" alt=""></label>
				</div>
				<div class="container">
					<label><input type="radio" name="choice" value="2">
					<img class="galery" src="http://www.cruzo.net/user/images/k/d760fbd8f50d9b92dc054ee8390df166_617.jpg" alt=""></label>
				</div>
				<div class="container">
					<label><input type="radio" name="choice" value="3">
					<img class="galery" src="http://picsdesktop.net/summer/1920x1440/PicsDesktop.net_5.jpg" alt=""></label>
				</div>
				<div class="container">
					<label><input type="radio" name="choice" value="4">
					<img class="galery" src="http://www.fullhdoboi.com/wallpapers/thumbs/6/kartinka-apelsiny-1885.jpg" alt=""></label>
				</div-->
			</div>
			<div class="module_content-field" style="clear:both">
				<input style="margin-left: 0; display: inline-block" type="button" value="Сохранить" class="button" id="j-save-pict">
				<a href="" class="button" style="display: inline; float: right; color: #fff; text-decoration: none;">Медиафайлы</a>
			</div>
			<input type="hidden" name="id" value="<?=$_POST['id']?>">
		</fieldset>
	</div>
</article>

<script>
	$.get( $('.j-dir').html() + '/uploads/images/')
		.done(function( data ) {
			console.log(data);
			generateGallery(data);
		}
	);

	function generateGallery(data) {
		for(src in data) {
			var container = document.createElement('div');
			container.className = 'container';
			var label = document.createElement('label');
			var input = document.createElement('input');
			input.type = 'radio';
			input.name = 'choice';
			var img = document.createElement('img');
			img.className = 'galery';
			label.appendChild(input);
			img.src = data[src];
			label.appendChild(img);
			container.appendChild(label);
			$('.galery-container').append(container);
		}
	}
</script>

<script>
	$('#j-save-pict').on('click', function() {
		var choice = $('[name=choice]').filter(':checked');
		var url = choice.next().attr('src');

		var id = $('[type=hidden]').val();

		$.post( $('.j-dir').html() + '/elems/'+id+'/image/', {src: url})
			.done(function( data ) {
				console.log(data);
			}
		);

	});
</script>