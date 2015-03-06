$(function(){

	var workArea = $('#main');
	$('.j-content-manager').on('click',function(){
		var dataset = $(this).data('content');

		$.ajax({
			'url' : $('.j-dir').html()+'/admin/'+dataset,
			beforeSend: function(){
				workArea.html('<img class="preloader" src="http://onlinecomics.ru/MyImg/preloader.gif">');
			},
			success: function(data){
				workArea.css('opacity', 0)
				workArea.html(data);
				workArea.animate({opacity: 1}, 500);
			}
		});
	});
});