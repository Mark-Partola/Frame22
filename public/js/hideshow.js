//  Andy Langton's show/hide/mini-accordion @ http://andylangton.co.uk/jquery-show-hide

// this tells jquery to run the function below once the DOM is ready
$(document).ready(function() {
	var toggleItems = $('.toggleLink');
	toggleItems.next().slideUp();
	toggleItems.click(function (event) {
		$(this).next().slideToggle();
	});
});