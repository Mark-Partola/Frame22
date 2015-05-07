requirejs.config({

	paths:{
		"jquery": "../../../../../libs/jquery/dist/jquery",
		"underscore": "../../../../../libs/underscore-amd/underscore",
		"backbone": "../../../../../libs/backbone-amd/backbone",
		ionRangeSlider: "/frame-22-22/public/tpl/templates/app/libs/ion.rangeSlider-2.0.6/js/ion.rangeSlider.min"
	},
	shim: {
		ionRangeSlider: {
			deps: ['jquery'],
			exports: "ionRangeSlider"
		}
	}
});

requirejs([

	'jquery', 
	'views/productView',
	'models/productModel',
	'collections/productsCollection',
	'views/productsCollectionView',
	'ionRangeSlider',

], function(

	$, 
	ProductView,
	ProductModel,
	ProductsCollection,
	ProductsCollectionView,
	ionRangeSlider

) {

	var filter = {
		priceRange:{
			from: 100,
			to: 10000
		},
	};

	var saveResult = function (data) {
		filter.priceRange.from = data.from;
		filter.priceRange.to = data.to;
	};

	var rangePrice = $("#range").ionRangeSlider({
		type: "double",
		grid: true,
		min: filter.priceRange.from,
		max: filter.priceRange.to,
		onChange: saveResult,
		onFinish: saveResult,
	});

	$("#range1").ionRangeSlider({
		type: "double",
		grid: true,
		min: -1000,
		max: 1000,
	});

	var productsCollection = new ProductsCollection();

	productsCollection.fetch({

		success: function(){
			new ProductsCollectionView({
				collection: productsCollection
			}).render();
		}

	});

	$('#j-filter').on('click', function() {

		var title = $('#j-filter-title').val();

		if(title) filter.title = title;

		productsCollection.fetch({

			url: 'http://localhost/frame-22-22/public/products/filter?filter='+JSON.stringify(filter),

			success: function(){
				new ProductsCollectionView({
					collection: productsCollection
				}).render();
			}

		});
	});

})