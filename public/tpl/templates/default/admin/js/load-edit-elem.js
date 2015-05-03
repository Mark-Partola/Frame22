<!-- Подгрузка в фэнсибокс -->
	$(function(){

		$('#callback').off();

		$('.j-elems-container').on('click', function(e){
			if($(e.target).is($('.j-edit-elem'))){

				var title = $('.j-elems-container').find('tr').has('[data-id='+$(e.target).data('id')+']').find('.j-elem-title').text();
				var content = $('.j-elems-container').find('tr').has('[data-id='+$(e.target).data('id')+']').find('.j-elem-content div').text();
				var id = $(e.target).data('id');
				$.post( $('.j-dir').html()+'/tpl/templates/default/admin/includes/editElem.php',
				{
					'title': title,
					'content': content,
					'id': id
				})
				.done(function( data ) {
					$('#callback').html(data);
				});

			}

			e.preventDefault();
		});
	});


<!-- Обновление элемента -->
	$(function(){
		$('#callback').on('click', '#j-update-elem' ,function(e){

			var title = $('[name=title]').val();
			var content = $('[name=content]').val();
			var id = $('[name=id]').val();

			$.post( $('.j-dir').html()+'/admin/content/update/'+id,
			{
				'title': title,
				'content': content
			})
			.done(function( data ) {
				$.fancybox.close();
				triggerMessageBlock(data);
			});
		});
	});