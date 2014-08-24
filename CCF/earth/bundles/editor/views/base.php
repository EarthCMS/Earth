<?php echo UI\Form::textarea( $key, $content ); ?>
<?php if ( $modal ) : ?>
	<script>
		$( "#<?php echo UI\Form::form_id( 'textarea', $key ); ?>" ).elastic();
	</script>
<?php else : ?>
	<?php $theme->capture_append( 'js', function() { ?> 
		<script>
			$( "#<?php echo UI\Form::form_id( 'textarea', $key ); ?>" ).elastic();
		</script>
	<?php }); ?>
<?php endif; ?>
