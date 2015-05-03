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
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					
					@if(isset($message))
						<div class="alert alert-info">
							{{$message}}
						</div>
					@endif
					@if(Session::get('user')->status==1)
					<form method="POST" action="{{url('/Product/Buy')}}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="id" value="{{$product->productid}}" /> 
						<input type="text" class="form-control" ng-change="validateStock([[product.quantity]])" ng-model="product.quantity" do-numeric name="quantity" />
						<button type="submit" class="btn btn-primary" style="margin-top:10px;width:100%;">Beli</button>
					</form>
					<!-- <a class="btn btn-warning"  download="[[product.productname]]" title="[[product.productname]]" style="margin-top:10px;width:100%;" href="[[image+product.gambar]]">Simpan Gambar</a>-->
					@else
						<div class="alert alert-danger">Account anda belum aktif, Pastikan lengkapi data anda atau hubungi administrator</div>
					@endif
			   
				@else
					<div class="alert alert-danger">Untuk membeli barang Anda harus login terlebih dahulu</div>
				@endif
			</div>
		</div>
		@endif
	</div>
</div>

@endsection