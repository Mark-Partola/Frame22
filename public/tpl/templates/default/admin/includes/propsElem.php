<article style="width: 700px;">
	<h3 style="margin:20px; font-size: 20px;">Управление свойствами элемента</h3>
	<div class="module_content">
		<fieldset style="padding:20px;">
			<div class="module_content-field">
				<header><h2 style="text-align: center; color: #444;" class="j-head">Заголовок</h2></header>
			</div>
			<div class="module_content-field">
				<table class="table_key-value">
					<thead>
						<th>Свойство</th>
						<th>Значение</th>
					</thead>
					<tbody class="j-table_key-value_body">

					</tbody>
				</table>
			</div>
			<div class="module_content-field">
				<input style="margin-left: 0; display: inline-block" type="button" value="Сохранить" class="button" id="j-save-props">
				<input style="float: right; display: inline-block;" type="button" value="Новое свойство" class="button" id="j-add-prop">
			</div>
			<input type="hidden" name="id" value="<?=$_POST['id']?>">
		</fieldset>
	</div>
</article>
<script>
	/********Добавление инпутов для нового свойства*********/
	$('#j-add-prop').on('click', function(){
		var tr		= document.createElement('tr'),
			leftTd	= document.createElement('td'),
			rightTd	= document.createElement('td'),
			input	= document.createElement('input'),
			table 	= document.getElementsByClassName('table_key-value')[0].querySelector('tbody');

		input.type = 'text';
		input.placeholder = 'Введите название';
		leftTd.appendChild(input);
		leftTd.style.height = '63px';

		rightInput = input.cloneNode(true);
		rightInput.placeholder = 'Введите значение'
		rightTd.appendChild(rightInput);


		tr.appendChild(leftTd);
		tr.appendChild(rightTd);

		table.appendChild(tr);

		$(table).find('tr:last-child input').addClass('animate');

	});
</script>

<script>
	var id = $('input[type=hidden]').val(); // айди подкруженного элемента
	var props = {};
	var status = false;

	/***Получение доступных свойств***/
	$.ajax({
		type: "GET",
		url: $('.j-dir').html() + '/elems/props/'+id,
		success: function(data){
			var response = JSON.parse(data);
			for(var i=0; i<response.length; i++) {
				props[response[i]] = undefined;
			}

			status = true;
		}
	});

	/**Получение информации об элементе (Заголовок, существующие свойства)**/

	$.ajax({
		type: "GET",
		url: $('.j-dir').html() + '/products/'+id,
		success: function(data){
			$('.j-head').text(data.title);

			for(prop in data.props) {
				props[prop] = data.props[prop];
			}

			generateListProps(props);
		}
	});

	/**Генерация списка свойств**/
	function generateListProps(data) {
		var tr, value,
			table = document.getElementsByClassName('table_key-value')[0].querySelector('tbody');

		for(prop in props) {
			if(props[prop] !== undefined) {
				value = props[prop];
			} else {
				value = '';
			}
			tr = document.createElement('tr');
			tr.innerHTML = "\
			<td style='position:relative'>\
				<a href='#' class='j-del-prop'></a>\
				<h4 style='font-size: 14px; display:inline-block; margin-left: 60px; margin-right: 60px;'>"+prop+"</h4>\
			</td>\
			<td><input type='text' placeholder='Введите Значение' value="+value+"></td>";

			table.appendChild(tr);

		}
	}

	/*пробегаемся по таблице,
	собираем объект значений. 
	Четные - ключи, нечетные - значения, 
	после удаляем элементы без значений*/

	$('#j-save-props').on('click', function(){
		var table = $('.j-table_key-value_body');
		var tds = table.find('tr td');
		var result = {};
		var tdWithName = null;

		for(var i = 0; i < tds.length; i++) {
			if(i % 2 === 0) {
				tdWithName = tds[i].querySelector('h4');
				if(!tdWithName) tdWithName = tds[i].querySelector('input').value;
				else tdWithName = tdWithName.innerText;
				result[tdWithName] = undefined;
			} else {
				var value = tds[i].querySelector('input').value;
				if(!value) {
					delete result[tdWithName];
				} else {
					result[tdWithName] = value;
				}
			}
		}

		function emptyObject(obj) {
			for (var i in obj) {
				return false;
			}
			return true;
		}

		if(!emptyObject(result)) {
			$.post( $('.j-dir').html() + '/elems/props/'+id, result)
				.done(function( data ) {
					triggerMessageBlock(data);
				}
			);
		} else {
			triggerMessageBlock('{"title": "Нет заполненных свойств", "status": ""}');
		}

	});

	/**Удаление свойства**/

	$('.j-table_key-value_body').on('click', '.j-del-prop', function(e){
			e.preventDefault();
			$(this).parents('tr').remove();
	});
</script>