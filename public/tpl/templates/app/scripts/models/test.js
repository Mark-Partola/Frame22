define(["backbone"], function(Backbone){
	var TestModel = Backbone.Model.extend({
		validate: function(attr) {
			console.log('attr');
			console.log(attr);
		},
		defaults:{
			content: "Какой-то контент"
		},
		url: "/"
	});

	return TestModel;

});
