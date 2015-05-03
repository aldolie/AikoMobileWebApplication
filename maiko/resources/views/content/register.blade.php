<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Mobile - Aiko</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/login.css') }}" rel="stylesheet">
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body ng-app="maiko">
<div id="form-login">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="heading-title center-align">AIKO</div>
			<div class="panel">
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/Register/') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<div class="col-md-12">
								<input type="text" class="form-control form-none" name="username" value="{{ old('username') }}" placeholder="USERNAME">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<input type="password" class="form-control form-none" name="password" placeholder="PASSWORD" >
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<input type="password" class="form-control form-none" name="cpassword" placeholder="CONFIRMATION PASSWORD" >
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<input type="text" class="form-control form-none" name="nama" placeholder="NAMA" >
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<input type="text" class="form-control form-none" name="alamat" placeholder="ALAMAT" >
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<input type="text" do-numeric ng-model="telepon" class="form-control form-none" name="telepon" placeholder="TELEPON" >
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<input type="text" class="form-control form-none" name="email" placeholder="EMAIL" >
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<input type="submit" class="btn btn-none large all" value="REGISTER" />
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
	<script src="{{ asset('/js/angular.min.js') }}"></script>
	<script src="{{ asset('/js/app.js') }}"></script>
	<script src="{{ asset('/js/directives/numericDirective.js') }}"></script>
	<script src="{{ asset('/js/jquery.min.js') }}"></script>
	<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
</body>
</html>

