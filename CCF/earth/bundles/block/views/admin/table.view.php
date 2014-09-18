<table id="block-list-view" class="table table-ccd" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th width="10px">{{__('Earth\\Block::model/block.label.id')}}</th>
			<th>{{__('Earth\\Block::model/block.label.key')}}</th>
			<th width="10px">&nbsp;</th>
		</tr>
	</thead>
</table>

<?php $theme->capture_append( 'js', function() use( $table ) 
{ 
	$init = $table->jsinit( '#block-list-view', to('@admin.block/listsource') );
	$init->set( 'searchfield', '#content-search-input' );
	echo $init->render();
}); ?>