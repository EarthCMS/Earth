{% use UI\Form; %}
{{Form::start( 'user-detail', array( 'method' => 'post', 'class' => 'panel-form', action => CCUrl::action( 'edit', array(), true ) ) )}}
<div class="row">
	<div class="col-md-4">
		<img style="width: 100%;" src="{{$user->avatar()}}" class="box-shadow" />
	</div>
	<div class="col-md-8">
		<div class="form-group">
			{{Form::label('name', $user->__('name'))}}
			{{Form::input('name', $user->name )}}
		</div>
		<div class="form-group">
			{{Form::label('email', $user->__('email'))}}
		 	{{Form::input('email', $user->email )}}
		</div>
		<div class="form-group">
			{{Form::label('group_id', $user->__('group'))}}
			{{Form::select('group_id', $groups, $user->group->id )}}
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
{{Form::end()}}