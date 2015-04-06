requirejs.config({

	paths:{
		"jquery": "../../../../libs/jquery/dist/jquery",
		"underscore": "../../../../libs/underscore-amd/underscore",
		"backbone": "../../../../libs/backbone-amd/backbone"
	}
});

requirejs(['views/test'], function(View){

	new View;

});