requirejs.config({

	paths:{
		"jquery": "../../../../../libs/jquery/dist/jquery",
		"underscore": "../../../../../libs/underscore-amd/underscore",
		"backbone": "../../../../../libs/backbone-amd/backbone"
	}
});

requirejs([

	'jquery', 
	'views/productView',
	'models/productModel',
	'collections/productsCollection',
	'views/productsCollectionView'

], function($, ProductView, ProductModel, ProductsCollection, ProductsCollectionView){

	var productsCollection = new ProductsCollection();

	productsCollection.fetch({

		success: function(){
			new ProductsCollectionView({
				collection: productsCollection
			}).render();
		}

	});

})