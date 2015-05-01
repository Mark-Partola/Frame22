define([

	"backbone",
	"jquery",
	"../views/productsView",

], function(Backbone, $, Product){

	var productsView = Backbone.View.extend({

		tagName: 'ul',

		render: function () {
			this.collection.each(function(person){
				console.log(person);
				var productView = new Product({model: person});

				this.$el.append(productView.render().el);

			}, this);

			return this;
		}

	});

	return productsView;

});