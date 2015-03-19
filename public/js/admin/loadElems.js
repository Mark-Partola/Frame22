function loadElems(options){

	/*
	* Навигация по пользователям
	*/
	var pageUser = 1; //текущая страница
	var hidden; //скрытая кнопка
	var itemHeight = $( options.container +' th').css('height');
	var tableHeight = parseInt(itemHeight) * $(options.container +' tr').length + 50;
	$(options.container).css('min-height', tableHeight +'px');

	hideDirectionButton(); //сразу активируем, т.к первая страница, нужно скрыть кнопку влево

	function hideDirectionButton(count){

		var direction;

		//определяем границу
		if(pageUser === 1){
			direction = 'left'
		}else if(pageUser === count){
			direction = 'right'
		}

		//управляем показать/скрыть в зависимости от границы
		if(hidden)
			hidden.css({
				'opacity': 1,
				'pointer-events': 'auto'
			});

		var what = $(options.link+'[data-dir='+direction+']');
		what.css({
			'opacity': 0,
			'pointer-events': 'none'
		});

		hidden = what;

		//подсветка активного пункта
		var buttonPagination = $('.j-pagination');
		buttonPagination.css({
			'color': '#77BACE',
			'pointer-events': 'auto'
		});
		buttonPagination.eq(pageUser-1).css({
			'color': '#999',
			'pointer-events': 'none'
		});
	}

	$(options.link).on('click', function(e){
		var direction = $(this).data('dir');
		if(direction === 'right'){
			if(pageUser < options.countNav)
				pageUser++;
		} else {
			if(pageUser > 1)
				pageUser--;
		}

		hideDirectionButton(options.countNav);

		console.log(pageUser);

		e.preventDefault();
		$('body').trigger('getUsersByOffset', pageUser);

	});

	$('.j-pagination').on('click', function(e){

		pageUser = $(this).data('pos');

		hideDirectionButton(options.countNav);

		e.preventDefault();
		$('body').trigger('getUsersByOffset', pageUser);
	});


	//запрос с сервера пользователей по смещению
	$('body').on('getUsersByOffset', function(e, offset){
		var offsetUser = offset;
		var url;
		if(options.offset){
			url = $('.j-dir').html()+'/admin/'+options.url+'?usersOffset='+offsetUser;
		}else{
			url = $('.j-dir').html()+'/admin/'+options.url;
		}
		console.log('getUsersByOffset');
		$.ajax({
			'url' : url,
			success: function(data){
				var fragment = $('<div>').html(data);
				$(options.container).css('opacity', 0);
				$(options.container).html($(options.table, fragment));
				$(options.container).animate({'opacity': 1}, 500);
				$('body').trigger('ajax');
			}
		});
	});
}