<script>
$(document).ready(function() 
{
	userstable = $('{{$target}}').dataTable(
	{
		"dom": 'rtip',
		"processing": true,
		"serverSide": true,
		"ajax": "{{$remote}}",
		"columns": 
		[
		{% each $columns as $col %} 
			{ 
				"data": "{{$col->name()}}", 
				"orderable": {{$col->sortable( true )}}, 
				"searchable": {{$col->searchable( true )}} 
			}, 
		{% endeach %} 
		]

	});
	
	$('#content-search-input').keyup(function()
	{
		  userstable.fnFilter( $(this).val() );
	});
});
</script>