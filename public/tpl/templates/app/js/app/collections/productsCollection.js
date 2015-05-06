define([

	"backbone",
	"../models/productModel"

], function(Backbone, productModel){

	var productsCollection = Backbone.Collection.extend({

		url: 'http://localhost/frame-22-22/public/products/limit/9',
		model: productModel

	});

	return productsCollection;

});