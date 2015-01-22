<html>
	<head>
		<link href='http://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 100;
				font-family: 'Lato';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 96px;
				margin-bottom: 40px;
			}

			.quote {
				font-size: 24px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title">Socialite Publisher</div>

				<div class="btn-toolbar">
					<a class="btn btn-primary" href="{{ route('social.login', 'facebook') }}">Login with Facebook</a>
					<a class="btn btn-info" href="{{ route('social.login', 'twitter') }}">Login with Twitter</a>
				</div>
			</div>
		</div>
	</body>
</html>
