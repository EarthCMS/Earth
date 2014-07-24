<div class="content-header content-header-fixed">
	<div class="page-topic">
	{% if $new %}
		<h2>{{__(':action.new')}}</h2>
	{% else %}
		<h2>{{_e($user->email)}}</h2>
	{% endif %}
	</div>
</div>