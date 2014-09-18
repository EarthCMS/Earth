<div class="pdn15">
{% use UI\Form; %}
{{Form::start( 'block-detail', array( 'method' => 'post', 'class' => 'panel-form', action => CCUrl::action( 'edit' ) ) )}}
<div class="row">
	<div class="col-md-12">

		{{Form::input('r', $block->id, 'hidden')}}

		<div class="form-group">
			{{Form::label('key', $block->__('key'))}}
			{{Form::input('key', $block->key )}}
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<small>{{$block->__('created_at')}}:</small>
				{% if $block->created_at == 0 %}
					{{__('Earth::common.never')}}
				{% else %}
					{{CCDate::format( $block->created_at )}}
				{% endif %}
			</div>
			<div class="col-md-6">
				<small>{{$block->__('modified_at')}}:</small>
				{% if $block->modified_at == 0 %}
					{{__('Earth::common.never')}}
				{% else %}
					{{CCDate::format( $block->modified_at )}}
					<small>({{CCDate::relative( $block->modified_at )}})</small>
				{% endif %}
			</div>
		</div>
		
		<hr>
		
		<div class="form-group">
			{{$editor}}
		</div>
	</div>
</div>
{{Form::end()}}
</div>