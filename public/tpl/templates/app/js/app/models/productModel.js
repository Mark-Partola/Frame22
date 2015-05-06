define([

	"backbone"

], function(Backbone){

	var productModel = Backbone.Model.extend({

		defaults: {
			title: 'Нет названия',
			main_image: '/frame-22-22/public/imgs/image_placeholder.png'
		},

	});

	return productModel;

});