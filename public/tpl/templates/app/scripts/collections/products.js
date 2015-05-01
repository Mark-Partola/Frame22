define(["backbone", "../models/product"], function(Backbone, Product){

	var Products = Backbone.Collection.extend({
		model: Product,
		url: 'http://localhost/frame-22-22/public/products',
	});

	return Products;

});
