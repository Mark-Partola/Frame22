requirejs.config({

	paths:{
		"jquery": "../../../../../libs/jquery/dist/jquery",
		"underscore": "../../../../../libs/underscore-amd/underscore",
		"backbone": "../../../../../libs/backbone-amd/backbone",
		ionRangeSlider: "/frame-22-22/public/tpl/templates/app/libs/ion.rangeSlider-2.0.6/js/ion.rangeSlider.min",
		treemodel: '../../../../../libs/backbone-tree-model/src/backbone.treemodel',
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
	'treemodel'

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
		}
	};
	var preFilter = {
		yearRange:{
			from: 2000,
			to: 2015
		},
	}

	$("#range").ionRangeSlider({
		type: "double",
		grid: true,
		min: filter.priceRange.from,
		max: filter.priceRange.to,
		onChange: function (data) {
			filter.priceRange.from = data.from;
			filter.priceRange.to = data.to;
		},
		onFinish: function (data) {
			filter.priceRange.from = data.from;
			filter.priceRange.to = data.to;
		}
	});

	$("#range1").ionRangeSlider({
		type: "double",
		grid: true,
		min: preFilter.yearRange.from,
		max: preFilter.yearRange.to,
		onChange: function (data) {
			preFilter.yearRange.from = data.from;
			preFilter.yearRange.to = data.to;
		},
		onFinish: function (data) {
			preFilter.yearRange.from = data.from;
			preFilter.yearRange.to = data.to;
		}
	});

	var productsCollection = new ProductsCollection();

	productsCollection.fetch({

		success: function(){
			new ProductsCollectionView({
				collection: productsCollection
			}).render();
		}

	});

	/**start Кнопка фильтра**/

	$('#j-filter').on('click', function() {

		var title = $('#j-filter-title').val();

		delete filter.title;
		if(title) {
			filter.title = title;
		}

		if(!$('#j-filter-year-activity').prop('checked')) {
			delete filter.yearRange;
		} else {
			filter.yearRange = preFilter.yearRange;
		}

		console.log(filter);
		productsCollection.fetch({

			url: '/frame-22-22/public/products/filter?filter='+JSON.stringify(filter),

			success: function(){
				new ProductsCollectionView({
					collection: productsCollection
				}).render();
			}

		});
	});

	/**end Кнопка фильтра**/

	/**start render Категорий**/

	$.get('/frame-22-22/public/')

	/**end render Категорий**/

})