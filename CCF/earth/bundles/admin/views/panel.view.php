<div class="content-header">
	{% if $close %}
	<div class="pull-right">
		<a class="panel-close-trigger" href="#"><i class="el-icon-return-key"></i></a>
	</div>
	{% endif %}
	<div class="page-topic">
		<h2>{{_e($topic)}}</h2>
	</div>
</div>
<div class="panel-body">
	{{$body}}
</div>