@extends('app')

@section('sidemenu_place')
active
@endsection

@section('html_title')
Danh sách địa điểm
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                Quản lý địa điểm
            <span>> 
                Danh sách địa điểm
            </span>
        </h1>
    </div>
</div>

<section id="widget-grid" ng-controller="ProjectListController">
    <div class="row">
        <article class="col-lg-12">
            @box_open("Danh sách địa điểm")
                <div>	
					<div class="jarviswidget-editbox">
						<input class="form-control" type="text">	
					</div>
					<div class="widget-body no-padding">
						<table id="example" class="display projects-table table table-striped table-bordered table-hover dataTable" cellspacing="0" width="100%">
					        <thead>
					            <tr>
					                <th></th>
					                <th style="width: 70px;">Code</th>
					                <th>Tên điểm</th>
                                    <th style="width: 30px;">Enable en</th>
                                    <th style="width: 30px;">Enable vi</th>
                                    <th style="width: 30px;">OK en</th>
                                    <th style="width: 30px;">OK vi</th>
                                </tr>
					        </thead>
					    </table>
                        <div class="widget-footer">
                            <a class="btn btn-primary" href="/place?resort=true">Tạo lại thứ tự</a>
                            <a class="btn btn-primary" href="/place/create">Thêm địa danh</a>
                        </div>
					</div>
				</div>
            @box_close
        </article>
    </div>
</section>

@endsection

@push('script')
<script type="text/javascript">
$(document).ready(function() {
	function format ( d ) {
	    return '<table cellpadding="5" cellspacing="0" border="0" class="table table-hover table-condensed">'+
            '<tr>'+
                '<td style="width:100px">Địa điểm:</td>'+
                '<td>'+d.name_vi+'</td>'+
                '<td>'+d.name_en+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td style="width:100px">Link:</td>'+
                '<td>'+d.name_in_url_vi+'</td>'+
                '<td>'+d.name_in_url_en+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td style="width:100px">Enable:</td>'+
                '<td>'+d.enable_en+'</td>'+
                '<td>'+d.enable_en+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td style="width:100px">Category:</td>'+
                (d.category ? '<td>'+d.category.name_vi+'</td>'+ '<td>'+d.category.name_en+'</td>' : "<td></td><td></td>") +
            '</tr>'+
            '<tr>'+
                '<td style="width:100px">Thao tác:</td>'+
                '<td colspan="2">'+
                    '<a class="btn btn-xs btn-primary" href="/place/create?parent_id=' + d.id + '">Thêm điểm con</a> ' +
                    '<a class="btn btn-xs btn-primary" href="/place/' + d.id + '/edit">Chỉnh sửa</a> ' +
                    '<a class="btn btn-xs btn-primary" href="/place/' + d.id + '/location">Toạ độ</a> ' +
                    '<a class="btn btn-xs btn-primary" href="/place/' + d.id + '/image">Ảnh</a> ' +
                '</td>' +
            '</tr>'+

	    '</table>';
	}

    var table = $('#example').DataTable( {
    	"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        "ajax": "/ajax/place",
        "bDestroy": true,
        "iDisplayLength": 15,
        "oLanguage": {
		    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
		},
        "columns": [
            {
                "class":          'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "code", defaultContent: "" },
            { "data": "name_vi", defaultContent: "" },
            { "data": "enable_en", defaultContent: "" },
            { "data": "enable_vi", defaultContent: "" },
            { "data": "ok_en", defaultContent: "" },
            { "data": "ok_vi", defaultContent: "" },
        ],
        "order": [[1, 'asc']],
        "fnDrawCallback": function( oSettings ) {
	       runAllCharts()
	    }
    } );

    $('#example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    });

})

</script>
@endpush