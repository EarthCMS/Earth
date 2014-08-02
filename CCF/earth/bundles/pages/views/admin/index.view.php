<ol class="sortable">
	<li id="list_1"><div><span class="disclose"><span></span></span>Item 1</div>
		<ol>
			<li id="list_2"><div><span class="disclose"><span></span></span>Sub Item 1.1</div>
				<ol>
					<li id="list_3"><div><span class="disclose"><span></span></span>Sub Item 1.2</div>
				</ol>
		</ol>
	<li id="list_4"><div><span class="disclose"><span></span></span>Item 2</div>
	<li id="list_5"><div><span class="disclose"><span></span></span>Item 3</div>
		<ol>
			<li id="list_6" class="mjs-nestedSortable-no-nesting"><div><span class="disclose"><span></span></span>Sub Item 3.1 (no nesting)</div>
			<li id="list_7"><div><span class="disclose"><span></span></span>Sub Item 3.2</div>
				<ol>
					<li id="list_8"><div><span class="disclose"><span></span></span>Sub Item 3.2.1</div>
				</ol>
		</ol>
	<li id="list_9"><div><span class="disclose"><span></span></span>Item 4</div>
	<li id="list_10"><div><span class="disclose"><span></span></span>Item 5</div>
</ol>
<?php $theme->capture_append( 'js', function() { ?>
<script>
$(document).ready(function()
{
	$('.sortable').nestedSortable(
	{
		handle: 'div',
		items: 'li',
		toleranceElement: '> div'
	});
});
</script>
<?php }); ?>