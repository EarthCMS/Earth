<table id="example" class="table table-ccd" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th width="10px">ID</th>
			<th width="32px">&nbsp;</th>
			<th>Email</th>
			<th>Group</th>
			<th>Member since</th>
		</tr>
	</thead>
</table>

<?php $theme->capture_append( 'js', function() use( $table ) 
{ 
	$init = $table->jsinit( '#example', to('@admin.users/listsource') );
	$init->set( 'searchfield', '#content-search-input' );
	echo $init->render();
}); ?>