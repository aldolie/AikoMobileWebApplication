@extends('app')

@section('content')
<div class="container" ng-controller="ProductReadyController">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row-app" ng-repeat="product in products" ng-cloak>
			<img class="col-lg-2 col-md-2 col-sm-4 col-xs-3 row-img"  ng-src="[[image+product.gambar_small]]" />
			<div class="col-md-8 col-sm-8 col-xs-9">
				<h5>[[product.productname]]</h5>
				<div>
					<span>Harga:</span><span>[[product.harga | currency:'Rp.']]</span>

					<a href="{{url('Product')}}/[[product.productid]]/[[clean(product.productname)]]" class="btn btn-primary btn-view">Beli</a>
				</div>
				<div>
					<span>Stock:</span><span>[[product.stock]] [[product.type]]</span>
				</div>
				<p>[[product.description]] </p>
			</div>
		</div>
		<button class="col-lg-12 col-md-12 col-sm-12 col-xs-12 btn btn-primary" ng-show="isAvailable()" ng-click="loadMore()">View More</button>
	</div>
</div>

@endsection