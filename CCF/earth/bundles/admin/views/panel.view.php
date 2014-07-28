<div class="content-header">
	{% if $close %}
	<div class="header-item pull-right">
		<a class="panel-close-trigger link" href="#"><i class="el-icon-return-key"></i></a>
	</div>
	{% endif %}
	<div class="header-item pull-right page-topic">
		<h2>{{_e($topic)}}</h2>
	</div>
	{% each $headers as $header %}
	<div class="header-item">
		{{$header}}
	</div>
	{% endeach %}
</div>
<div class="panel-body">
	{{\UI\Alert::render()}}	
	{{$body}}
</div>