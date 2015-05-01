define([

	"backbone",
	"jquery",
	"../models/product",

], function(Backbone, $, Products){

	var productsView = Backbone.View.extend({

		tagName: 'li',

		render: function () {

			this.$el.html(this.model.get('content'));

			return this;
		}

	});

	return productsView;

});