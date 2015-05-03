@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">PROFILE</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

						<form class="form-horizontal" role="form" method="POST" action="{{ url('/Profile/') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

				

						
						<div class="form-group">
							<div class="col-md-12">
								<input type="text" class="form-control form-none" name="nama" placeholder="NAMA" value="{{$user->nama}}" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<input type="text" class="form-control form-none" name="alamat" placeholder="ALAMAT" value="{{$user->alamat}}" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<input type="text" do-numeric ng-model="telepon" class="form-control form-none" name="telepon" placeholder="TELEPON" ng-init="telepon='{{$user->telepon}}'"/>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<input type="text" class="form-control form-none" name="email" placeholder="EMAIL" value="{{$user->email}}" >
							</div>
						</div>


					

						<div class="form-group">
							<div class="col-md-12">
								<input type="submit" class="btn btn-primary large all" value="UPDATE" />
							</div>
						</div>


					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
