@extends('app')

@section('sidemenu_system_balance')
active
@endsection

@section('html_title')
Order
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li>System</li>
    <li>Balance</li>
</ol>

@endpush

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
    @include("backend.header_chart")
</div>

<section id="widget-grid" class="">
    <div class="row">
        <article class="col-lg-12">
            @box_open(trans("user.list.title"))
                <div>
                    <div class="widget-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Bank</th>
                                        <th>Bank number</th>
                                        <th>Bank holder</th>
                                        <th>Branch</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                        <th>Aaction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($balances as $b)
                                    <tr>
                                        <td>{{ $b->id }}</td>
                                        <td>{{ $b->bank->shortname }}</td>
                                        <td>{{ $b->bank_number }}</td>
                                        <td>{{ $b->bank_holder_name }}</td>
                                        <td>{{ $b->bank_branch }}</td>
                                        <td>{{ $b->type->name }}</td>
                                        <td>{{ number_format($b->amount) }}</td>
                                        <td>{!! $b->edit_button !!}</td>
                                        <td>{!! $b->system_transaction_button !!}</td>
                                    </tr>
                                    @endforeach
                                    {!! Form::open(["url" => "/system/balance", "method" => "post"]) !!}
                                    <tr>
                                        <td></td>
                                        <td>{!! Form::lbSelect2("bank_id", null, App\Models\Bank::toOption("shortname")) !!}</td>
                                        <td>{!! Form::lbText("bank_number", null, null, "Bank number") !!}</td>
                                        <td>{!! Form::lbText("bank_holder_name", null, null, "Holder name") !!}</td>
                                        <td>{!! Form::lbText("bank_branch", null, null, "Branch") !!}</td>
                                        <td></td>
                                        <td>{{ number_format($balances->sum("amount")) }}</td>
                                        <td>{!! Form::lbSubmit() !!}</td>
                                        <td><a href="/system/balance/refresh" class="btn btn-success">Refresh amount</a></td>
                                    </tr>
                                    {!! Form::close() !!}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>

@endsection
