<div class="pdn20">
	<h4>Startseite</h4>
	
	<ol class="page-list">
		<li>
			<div class="page-item">
				<span class="page-item-title">{{$page->name}}</span>
			</div>
		</li>
	</ol>
	
	<h4>Seiten</h4>
	
	<ol id="earth-pages" class="page-list">
		{{CCView::create( 'Earth\\Pages::admin/page_list_item.view', array( 'page' => $page ) )}}
	</ol>
</div>
<?php $theme->capture_append( 'js', function() { ?>
<script>
$(document).ready(function()
{
	$('#earth-pages').nestedSortable(
	{
		handle: 'div',
		items: 'li',
		toleranceElement: '> div',
		placeholder: 'page-item-placeholder',
		tabSize: 25,
		isTree: true,
		expandOnHover: 700,
		startCollapsed: true
	});
	
	$(document).on('click', '.toggle-sub-pages', function( e ) 
	{
		e.preventDefault();
		
		var $this = $(this),
			container = $this.closest( 'li' ),
			subitems = container.find( '> ol' );
		
		if ( container.hasClass( 'page-item-collapsed' ) )
		{
			subitems.css(
			{
				opacity: 1,
				height: 'inherit',
			});
			container.removeClass( 'page-item-collapsed' );
			$this.html( '<i class="el-icon-chevron-up"></i>' );
		}
		else
		{
			subitems.css(
			{
				opacity: 0,
				height: '0px',
			});
			container.addClass( 'page-item-collapsed' );
			$this.html( '<i class="el-icon-chevron-down"></i>' );	
		}
	});
});
</script>
<?php }); ?>