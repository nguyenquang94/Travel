@extends('app')

@section('sidemenu_order')
active
@endsection

@section('html_title')
Order
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans("order.list.title") }} 
            <span>> 
                {{ trans("general.list") }} 
            </span>
        </h1>
    </div>
</div>

<section id="widget-grid" class="">
    <div class="row">
        @if (isset($order))
        <article class="col-lg-9">
            @box_open(trans("user.list.title"))
                <div>
                    {!! Form::open(["url" => "/order/$order->id/item/create", "method" => "get"]) !!}
                    <div class="widget-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Select a date (range):</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" id="from" type="text" name="from_date" placeholder="From" value="{{ request()->from_date }}">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" id="to" type="text" name="to_date" placeholder="To" value="{{ request()->to_date }}">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::lbSelect("hotel_id", request()->hotel_id, App\Models\Hotel::toOption("name_vi"), "Hotel") !!}
                        <div class="widget-footer" style="text-align: left;">
                            {!! Form::lbSubmit() !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            @box_close

            @if (request()->has('hotel_id'))
            
            @box_open(trans("user.list.title"))
                <div>
                    {!! Form::open(["url" => "/order/$order->id/item", "method" => "POST"]) !!}
                    {!! Form::hidden("start_date", request()->from_date) !!}
                    {!! Form::hidden("end_date", request()->to_date) !!}
                    {!! Form::hidden("hotel_id", request()->hotel_id) !!}
                    <div class="widget-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Room type</th>
                                        <th>Room left</th>
                                        <th>Book number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hotel->roomtypes as $type)
                                    <tr>
                                        <td>{{ $type->name_vi }}</td>
                                        <td>{{ $type->room_available(request()->from_date, request()->to_date) }}</td>
                                        <td>{!! Form::lbText($type->id, null, null, "Number of room") !!}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="widget-footer" style="text-align: left;">
                            {!! Form::lbSubmit() !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            @box_close
            @endif
        </article>
        @endif
    </div>
</section>

@endsection

@push('script')

<script type="text/javascript">
    $(document).ready(function() {
        $("#from").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 3,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 3,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            onClose: function (selectedDate) {
                $("#from").datepicker("option", "maxDate", selectedDate);
            }
        });
    });

</script>
@endpush
