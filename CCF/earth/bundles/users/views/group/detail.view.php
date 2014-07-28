{% use UI\Form; %}

<div class="row">
	{{Form::start( 'group-detail', array( 'method' => 'post', 'class' => 'panel-form', action => CCUrl::action( 'edit' ) ) )}}
	<div class="col-md-12">

		{{Form::input('r', $group->id, 'hidden')}}

		<div class="form-group">
			{{Form::label('name', $group->__('name'))}}
			{{Form::input('name', $group->name )}}
		</div>
	</div>
	{{Form::end()}}
	
	{% if $group->id > 0 %}
	<div class="col-md-12">
		{{$user_list}}
		{{$theme->js}}
	</div>
	{% endif %}
</div>
