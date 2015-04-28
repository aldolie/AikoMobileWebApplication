@extends('app')

@section('content')
<div class="container" ng-controller="ProductDetailController">
	<div class="row">
		@if($status=='failed')
		<div class="alert alert-danger">Not Found</div>
		@else
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  >
			<img class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row-img" ng-init="product.gambar='{{$product->gambar}}'"  ng-src="[[image+product.gambar]]" />
			<div class="col-md-12 col-sm-12 col-xs-12">
				<h5 ng-init="product.productname='{{$product->productname}}'">[[product.productname]]</h5>
				<div>
					<span ng-init="product.harga={{$product->hargagrosir}}">Harga:</span><span>[[product.harga | currency:'Rp.']]</span>
				</div>
				<div>
					<span ng-init="product.type='{{$product->type}}'">Stock:</span><span ng-init="product.stock={{$product->stock}}">[[product.stock]] [[product.type]]</span>
				</div>
				<p>[[product.description]]</p>
				@if(Session::has('user'))
				<form> 
					<input type="text" class="form-control" ng-model="product.quantity" do-numeric />
					<button type="submit" class="btn btn-primary" style="margin-top:10px;width:100%;">Beli</a>
				</form>
				@else
					<div class="alert alert-danger">Untuk membeli barang Anda harus login terlebih dahulu</div>
				@endif
			</div>
		</div>
		@endif
	</div>
</div>

@endsection