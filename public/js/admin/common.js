$(function(){

	var workArea = $('#main');
	$('.j-content-manager').on('click',function(){
		var dataset = $(this).data('content');
		$.ajax({
			'url' : $('.j-dir').html()+'/admin/'+dataset,
			success: function(data){
				workArea.html(data);
			}
		});
	});
});