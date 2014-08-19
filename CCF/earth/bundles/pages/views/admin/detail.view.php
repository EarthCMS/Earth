{% use UI\Form; %}
<ul class="page-type-tabs clearfix">
{% each Earth\Pages\Page::$_types as $type %}
	<li {{ $page->type == $type ? 'class="active"' : '' }}>
		<a style="width: {{ 100 / count( Earth\Pages\Page::$_types ) }}%;" class="panel-ajax-trigger" href="{{CCUrl::action( 'change_type', array( ':fingerprint', 'r' => $page->id, 'type' => $type ) )}}">{{__('Earth\\Pages::model/page.type.'.$type)}}</a>
	</li>
{% endeach %}
</ul>
<div class="page-detail-edit pdn15">
	{{Form::start( 'page-detail', array( 'method' => 'post', 'class' => 'panel-form form-horizontal', action => CCUrl::action( 'edit' ) ) )}}
		<div class="form-group">
			<div class="col-sm-6">
				{{Form::input('status', '0', 'hidden')}}
				{{Form::checkbox('status', __('Earth\\Pages::model/page.status'), $page->status)}}
			</div>
			<div class="col-sm-6">
				{{Form::input('hidden', '0', 'hidden')}}
				{{Form::checkbox('hidden', __('Earth\\Pages::model/page.hidden'), $page->hidden)}}
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-6">
				{{Form::label('name', __('Earth\\Pages::model/page.name'))}}
				{{Form::input('name', $page->name)}}
			</div>
			<div class="col-sm-6">
				{{Form::label('url', __('Earth\\Pages::model/page.url'))}}
				{{Form::input('url', $page->url)}}
			</div>
		</div>
		<hr>
		{{$edit_view}}
		{{Form::input( 'r', $page->id, 'hidden' )}}
	{{Form::end()}}
</div>