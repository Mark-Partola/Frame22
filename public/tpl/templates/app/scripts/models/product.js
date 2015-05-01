define(["backbone"], function(Backbone){

	var Product = Backbone.Model.extend({
		validate: function(attr) {
			console.log('attr');
			console.log(attr);
		},
		defaults:{
			id:0,
			content: "Какой-то контент"
		},
	});

	return Product;

});
