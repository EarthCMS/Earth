{% use UI\Form; %}
{{Form::start( 'group-detail', array( 'method' => 'post', 'class' => 'panel-form', action => CCUrl::action( 'edit' ) ) )}}
<div class="row">
	<div class="col-md-6">

		{{Form::input('r', $group->id, 'hidden')}}

		<div class="form-group">
			{{Form::label('name', $group->__('name'))}}
			{{Form::input('name', $group->name )}}
		</div>
	</div>
</div>
{{Form::end()}}