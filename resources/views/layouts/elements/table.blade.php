<?php
	$special_id = str_random(40);
	$number_cols = [];
	for ($i = 0; $i < count($columns); $i ++)
	{
		if (isset($columns[$i]["type"]) && $columns[$i]["type"] == "money")
		{
			$number_cols[] = $i;
		}
	}
?>
<table id="{{ $special_id }}" class="table table-striped table-bordered" width="100%" style="overflow-x: auto;">
    <thead>
		<tr>
        	@foreach ($columns as $column)
				<th class="hasinput">
	        		@if (!isset($column['hasFilter']) || $column['hasFilter'] == true)
						<input type="text" class="form-control" placeholder="{{ $column['title'] }}" />
					@endif
				</th>
        	@endforeach
		</tr>
        <tr>
        	@foreach ($columns as $column)
        		<th>{{ $column['title'] }}</th>
        	@endforeach
        </tr>
    </thead>

    <tbody>
    </tbody>
    @if (isset($createForm))
    <tfoot>
		{!! $createForm["open"] !!}
    	<tr>
    	@foreach ($createForm["fields"] as $field)
	    	<td>
	    		{!! $field !!}
    		</td>
    	@endforeach
    	</tr>
    	{!! Form::close() !!}
    </tfoot>
    @endif
</table>


@push('script')
<style type="text/css">
	.autooverflow {
		overflow-x: auto;
		width: 100%;
	}
</style>

<script type="text/javascript">

var t_{{ $special_id }};

$(document).ready(function() {

	var responsiveHelper_datatable_fixed_column = undefined;
	
	var breakpointDefinition = {
		tablet : 1024,
		phone : 480
	};

    // Activate an inline edit on click of a table cell
    $('#example').on( 'click', 'tbody td:not(:first-child)', function (e) {
        editor.inline( this );
    } );

	t_{{ $special_id }} = $('#{{ $special_id }}').DataTable({
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
				"<'autooverflow't>"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		"autoWidth" : true,
		"oLanguage": {
			"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
		},
		"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_datatable_fixed_column) {
				responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#{{ $special_id }}'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_datatable_fixed_column.respond();
		},
		@if (count($number_cols) > 0)
		"columnDefs": [
            {
                "render": function ( data, type, row ) {
                    return "<span class=\"pull-right\">" + parseFloat(data).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + "</span>";
                },
                "targets": {{ json_encode($number_cols) }},
            }
        ],
        @endif
		serverSide: true,
	    ajax: {
	        url: '{{ $url }}',
	        type: '{{ $method or "GET"}}'
	    },
	    stateSave: true,
        columns: <?php echo json_encode($columns); ?>,
        pageLength: {{ $pageLength or 50 }}
    });
	@if (isset($reloadTime))
	
	setInterval(function() {
		t_{{ $special_id }}.ajax.reload();
	}, {{ $reloadTime}} );

	@endif
    	   
    // Apply the filter
    $("#{{ $special_id }} thead th input[type=text]").on( 'keyup change', function () {
    	
        t_{{ $special_id }}
            .column( $(this).parent().index()+':visible' )
            .search( this.value )
            .draw();
            
    } );
});
</script>

@endpush