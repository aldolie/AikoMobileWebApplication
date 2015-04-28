@extends('app')

@section('content')
<div class="container" >
	<div class="row">
		<?php $total=0; ?>
		@foreach ($transactions as $tr)

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row-app" ng-controller="General" ng-cloak>
			<img class="col-lg-2 col-md-2 col-sm-4 col-xs-3 row-img" ng-init="tr.gambar='{{$tr->gambar_small}}'"  ng-src="[[image+tr.gambar]]" />
			<div class="col-md-8 col-sm-8 col-xs-9">
				<h5 ng-init="tr.productname='{{$tr->productname}}'">[[tr.productname]]</h5>
				<div>
					<span >Harga : </span><span ng-init="tr.harga={{$tr->harga}}">[[tr.harga | currency:'Rp']]</span>
				</div> 
				<div>
					<span >Status : </span><span ng-init="tr.status='{{$tr->status}}'">[[tr.status]]</span>
				</div>
				<div>
					<span ng-init="tr.quantity={{$tr->quantity}}">Total : </span><span>[[tr.harga*tr.quantity| currency:'Rp']]</span>
				</div>
				<span ng-init="tr.created='{{$tr->created_at}}'">[[tr.created]]</span>
			</div>
		</div>
		
		@endforeach
	
	</div>
</div>

@endsection