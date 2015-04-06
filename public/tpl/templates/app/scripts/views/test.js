define([

	"backbone",
	"../models/test",

], function(Backbone, Model){

	var testView = Backbone.View.extend({
		initialize: function() {
			this.model = new Model;
			this.render();
		},

		render: function() {
			console.log(this.model.get("content"));
			this.model.set("content", "Новый");
			console.log(this.model.get("content"));
			this.model.save();
		}
	});

	return testView;
});