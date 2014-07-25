{% use UI\Form; Form::start( 'user-detail' ) %}
<div class="row">
	<div class="col-md-4">
		<img style="width: 100%;" src="{{$user->avatar()}}" class="box-shadow" />
	</div>
	<div class="col-md-8">
		<div class="form-group">
			{{Form::label('email', $user->__('email'))}}
			{{Form::input('email', $user->email )}}
		</div>
		<div class="row">
			<div class="col-md-6">
				<small>{{$user->__('created_at')}}:</small>
				{{CCDate::format( $user->created_at )}}
			</div>
			<div class="col-md-6">
				<small>{{$user->__('last_login')}}:</small>
				{{CCDate::format( $user->last_login )}}
				<small>({{CCDate::relative( $user->last_login )}})</small>
			</div>
		</div>
	</div>
</div>
{% Form::end() %}