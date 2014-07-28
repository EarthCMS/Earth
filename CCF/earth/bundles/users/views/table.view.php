<?php
$group_id = isset( $group_id ) ? $group_id : null;
$search = isset( $search ) ? $search : true;
?>
<table id="user-list-view" class="table table-ccd" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th width="10px">ID</th>
			<th width="32px">&nbsp;</th>
			<th>Name</th>
			<th>Email</th>
			<th>Group</th>
			<th>Member since</th>
			<th width="10px">&nbsp;</th>
		</tr>
	</thead>
</table>

<?php $theme->capture_append( 'js', function() use( $table, $group_id, $search ) 
{ 
	$init = $table->jsinit( '#user-list-view', to('@admin.users/listsource', array( 'group' => $group_id )) );
	
	if ( $search )
	{
		$init->set( 'searchfield', '#content-search-input' );
	}
	
	echo $init->render();
}); ?>