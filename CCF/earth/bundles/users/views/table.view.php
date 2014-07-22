<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>ID</th>
			<th>Email</th>
		</tr>
	</thead>
</table>

<?php $theme->capture_append( 'js', function() use( $table ) 
{ 
	echo $table->jsinit( '#example', to('@admin.users/listsource') );
}); ?>