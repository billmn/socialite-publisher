@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Twitter Publisher: {{ $info['name'] }} ( {{ '@' . $info['nickname'] }} )</div>

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

					<form action="{{ route('social.publish', 'twitter') }}" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<textarea name="message" class="form-control" rows="10" maxlength="140"></textarea>
						</div>

						<div class="btn-toolbar">
							<input type="submit" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
