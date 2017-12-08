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
        <article class="col-lg-12">
            @box_open(trans("user.list.title"))
                <div>
                    {!! Form::open(["url" => "/order/$order->id/item_bus/create", "method" => "get"]) !!}
                    <div class="widget-body">
                        {!! Form::lbDatepicker("date", request()->date, "Date") !!}
                        {!! Form::lbSelect("bus_id", request()->bus_id, App\Models\Bus_provider::toOption("name"), "Bus") !!}
                        <div class="widget-footer" style="text-align: left;">
                            {!! Form::lbSubmit() !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            @box_close

            @if (request()->has('bus_id'))
            
            @box_open(trans("user.list.title"))
                <div>
                    {!! Form::open(["url" => "/order/$order->id/item_bus", "method" => "POST"]) !!}
                    {!! Form::hidden("date", request()->date) !!}
                    {!! Form::hidden("bus_id", request()->bus_id) !!}
                    <div class="widget-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Bus type</th>
                                        <th>Start date</th>
                                        <th>Start time</th>
                                        <th>Price</th>
                                        <th>Price BWhere</th>
                                        <th>Price Direct</th>
                                        <th>Available</th>
                                        <th>Book number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bus->trips()->whereStartDate(request()->date)->get() as $trip)
                                    <tr>
                                        <td>{{ $trip->type->name }}</td>
                                        <td>{{ $trip->start_date }}</td>
                                        <td>{{ $trip->start_time }}</td>
                                        <td>{{ $trip->priceset->price }}</td>
                                        <td>{{ $trip->priceset->price_bwhere }}</td>
                                        <td>{{ $trip->priceset->price_direct }}</td>
                                        <td>{{ $trip->ticket_available() }}</td>
                                        <td>{!! Form::lbText($trip->id, null, null, "Number of Ticket") !!}</td>
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
