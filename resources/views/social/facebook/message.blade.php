@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Facebook Publisher: {{ $info['page']['name'] }}</div>

				<div class="panel-body">
					@if (count($errors))
					<div class="alert alert-danger">
						@foreach($errors->all() as $error)
						<div>{{ $error }}</div>
						@endforeach
					</div>
					@endif

					@if (Session::has('success'))
					<div class="alert alert-success">
						{{ Session::get('success') }}
					</div>
					@endif

					<form action="{{ route('social.publish', 'facebook') }}" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="page_id" value="{{ $info['page_id'] }}">
						<input type="hidden" name="page_token" value="{{ $info['page_token'] }}">

						<div class="form-group">
							<textarea name="message" class="form-control" rows="10"></textarea>
						</div>

						<div class="btn-toolbar">
							<input type="submit" class="btn btn-primary">
							<a href="{{ route('social.facebook.pages') }}" class="btn btn-default">&laquo; Choose another page</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
