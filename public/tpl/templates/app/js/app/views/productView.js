define([

	"backbone",
	"jquery",
	"underscore",
	"../models/productModel"

], function(Backbone, $, _, productModel){

	var productView = Backbone.View.extend({

		template: _.template($('#product-template').html()),

		render: function () {

			this.$el.html( this.template( this.model.toJSON() ) );

			return this;
		}

	});

	return productView;

});