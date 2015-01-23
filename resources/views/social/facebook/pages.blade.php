@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Choose Facebook Page</div>

				<div class="panel-body">
					<form action="{{ route('social.facebook.pages.chooose') }}" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<select name="page_id" class="form-control">
								@foreach($pages as $page)
								<option value="{{ $page['id'] }}">{{ $page['name'] }}</option>
								@endforeach
							</select>
						</div>

						<input type="submit" class="btn btn-primary">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
