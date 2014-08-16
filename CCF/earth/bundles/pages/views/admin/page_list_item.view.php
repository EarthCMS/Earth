{% if !$page->is_root() %}
<li class="page-item-collapsed page-item-container">
	<div class="page-item">
		
		<a href="{{CCUrl::action( 'edit', array( 'r' => $page->id ) )}}" class="panel-ajax-trigger page-item-action">
			<i class="el-icon-edit"></i>
		</a>
		
		<a href="{{to($page->full_url)}}" target="_blank" class="page-item-action" style="margin-top: 1px;margin-right: -2px;">
			<i style="font-size: 16px;" class="el-icon-screen"></i>
		</a>
		
		<a href="#" class="toggle-sub-pages">
			<i class="el-icon-chevron-down"></i>
		</a>
		<span class="page-item-title">{{$page->name}}</span>
		<span class="page-item-type">{{$page->type}} - </span>
		<span class="page-item-url">{{$page->full_url}}</span>
	</div>
	<ol>
{% endif %}
	{% each $page->pages as $page %}
		{{CCView::create( 'Earth\\Pages::admin/page_list_item.view', array( 'page' => $page ) )}}
	{% endeach %}
{% if !$page->is_root() %}
	</ol>
</li>
{% endif %}
