<script>
$(document).ready(function() 
{
	userstable = $('{{$target}}').dataTable(
	{
		"dom": 'rt<"dataTable_footer"ip>',
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
		],
		"language": {
		   "processing": ""
		}

	});
	
	{% if $searchfield %}
	$('{{$searchfield}}').keyup(function()
	{
		  userstable.fnFilter( $(this).val() );
	});
	{% endif %}
});
</script>