<table id="group-list-view" class="table table-ccd" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th width="10px">ID</th>
			<th>Name</th>
			<th width="10px">&nbsp;</th>
		</tr>
	</thead>
</table>

<?php $theme->capture_append( 'js', function() use( $table ) 
{ 
	$init = $table->jsinit( '#group-list-view', to('@admin.users.groups/listsource') );
	$init->set( 'searchfield', '#content-search-input' );
	echo $init->render();
}); ?>