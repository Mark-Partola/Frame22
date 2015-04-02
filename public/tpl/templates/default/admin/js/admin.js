
function triggerMessageBlock(data){
	data = JSON.parse(data);

	var bgc = '#CE5A47';
	if(data.status){
		var bgc = '#47CE5A';
	}
	$('.message-box').html(data.title);
	$('.message-box').css({
		'display': 'block',
		'background-color': bgc
	}, 1000);

	setTimeout(function(){
		$('.message-box').fadeOut();
	}, 3000);
}