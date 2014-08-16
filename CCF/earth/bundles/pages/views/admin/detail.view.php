<ul class="page-type-tabs">
{% each Earth\Pages\Page::$_types as $type %}
	<li {{ $page->type == $type ? 'class="active"' : '' }}>
		<a class="panel-ajax-trigger" href="{{CCUrl::action( 'change_type', array( ':fingerprint', 'r' => $page->id, 'type' => $type ) )}}">{{__('Earth\\Pages::model/page.type.'.$type)}}</a>
	</li>
{% endeach %}
</ul>
<div class="page-detail-edit">
	{{$edit_view}}
</div>