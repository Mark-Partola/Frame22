define([

	"backbone",
	"jquery",
	"../views/productView",

], function(Backbone, $, ProductView){

	var productsView = Backbone.View.extend({

		//tagName: 'ul',

		render: function () {

			$('#area-products').html('');

			this.collection.each(function(product){
				//console.log(product);
				var productView = new ProductView({model: product});

				$('#area-products').append((productView.render().el));

			}, this);

			return this;
		}

	});

	return productsView;

});