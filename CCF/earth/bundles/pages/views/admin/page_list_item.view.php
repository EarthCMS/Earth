{% if !$page->is_root() %}
<li class="page-item-collapsed">
	<div class="page-item">
		<a href="#" class="toggle-sub-pages"></a>
		<span class="page-item-title">{{$page->name}}</span>
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
