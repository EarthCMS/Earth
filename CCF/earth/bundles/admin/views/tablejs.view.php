<script>
$(document).ready(function() 
{
	var datatable = $('{{$target}}').dataTable(
	{
		"dom": 'rt<"dataTable_footer"ip>',
		"processing": true,
		"serverSide": true,
		"ajax": "{{$remote}}",
		"pageLength": 25,
		"columns": 
		[
		{% each $columns as $col %} 
			{ 
				"data": "{{$col->name()}}", 
				"orderable": {{$col->sortable( true )}}, 
				"searchable": {{$col->searchable( true )}} 
			}, 
		{% endeach %} 
		],
		"language": {
		   "processing": ""
		}

	});
	
	{% if $searchfield %}
	$('{{$searchfield}}').keyup(function()
	{
		  datatable.fnFilter( $(this).val() );
	});
	{% endif %}
});
</script>