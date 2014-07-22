<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>ID</th>
			<th>Email</th>
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