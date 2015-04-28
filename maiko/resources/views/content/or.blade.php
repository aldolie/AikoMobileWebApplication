@extends('app')

@section('content')
<div class="container" >
	<div class="row">
		<?php $total=0; ?>
		@foreach ($orders as $order)

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row-app" ng-controller="General">
			<img class="col-lg-2 col-md-2 col-sm-4 col-xs-3 row-img" ng-init="order.gambar='{{$order->gambar_small}}'"  ng-src="[[image+order.gambar]]" />
			<div class="col-md-8 col-sm-8 col-xs-9">
				<h5 ng-init="order.productname='{{$order->productname}}'">[[order.productname]]</h5>
				<div>
					<span >Harga : </span><span ng-init="order.harga={{$order->harga}}">[[order.harga | currency:'Rp']]</span>
				</div> 
				<div>
					<span ng-init="order.type='{{$order->type}}'">Jumlah : </span><span ng-init="order.quantity={{$order->quantity}}">[[order.quantity]] [[order.type]]</span>
				</div>
				<div>
					<span>Total : </span><span>[[order.harga*order.quantity| currency:'Rp']]</span>
				</div>
				<span ng-init="order.created='{{$order->created_at}}'">[[order.created]]</span>
			</div>
		</div>
		<?php $total+=$order->harga*$order->quantity; ?>
		@endforeach
		<div class="col-lg-8 col-lg-offset-2 col-xs-8 col-xs-offset-4" ng-init="total={{$total}}">
			<b>[[total |currency:'Rp']]</b>
		</div>
	</div>
</div>

@endsection