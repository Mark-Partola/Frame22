requirejs.config({

	paths:{
		"jquery": "../../../../libs/jquery/dist/jquery",
		"underscore": "../../../../libs/underscore-amd/underscore",
		"backbone": "../../../../libs/backbone-amd/backbone"
	}
});

requirejs([

	'views/productsView',
	'views/productsCollectionView',
	'collections/products',

], function(View, ProductsCollectionView, Collection){

	var col = new Collection;

	col.fetch({success: function(){
		$('.edit').html(
			new ProductsCollectionView({
				collection: col
			}).render().el
		);
	}});

});