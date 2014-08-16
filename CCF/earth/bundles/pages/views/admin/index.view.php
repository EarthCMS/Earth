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
	var pages_container = $('#earth-pages');
	
	pages_container.nestedSortable(
	{
		handle: 'div',
		items: 'li',
		toleranceElement: '> div',
		placeholder: 'page-item-placeholder',
		tabSize: 25,
		isTree: true,
		expandOnHover: 700,
		startCollapsed: true,
	});
	
	/*
	 * Save the pages order and structure
	 */
	$(document).on( 'click', '#pages-save-order-trigger', function( e ) {
		e.preventDefault();
		
		CC.UI.loading( pages_container );
		
		$.ajax( {
			url: '{{CCUrl::action('tree')}}',
			type: "POST",
			data: 
			{
				order: JSON.stringify( pages_container.nestedSortable( 'toArray' ) ),
			},
			success: function( res ) 
			{
				pages_container.html( res );
				
				// disable loading
				CC.UI.loading( pages_container );
			},
		});
	});
	
	/*
	 * Create new pages item
	 */
	$(document).on( 'click', '.create-new-page-item-trigger', function( e ) {
		e.preventDefault();
		
		CC.UI.loading( pages_container );
		
		$.ajax( {
			url: '{{CCUrl::action('create')}}',
			success: function( res ) 
			{
				pages_container.append( res );
				
				// disable loading
				CC.UI.loading( pages_container );
			},
		});
	});
	
	/*
	 * Toggle sub pages
	 */
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