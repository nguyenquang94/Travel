@extends('app')

@section('sidemenu_hotel')
active
@endsection

@section('sidebox_image')
btn-primary
@endsection

@section('html_title')
Quản lý ảnh {{ $place->name_vi }}
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li><a href="/place">Place</a></li>
    <li>Image</li>
</ol>

@endpush

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                Quản lý ảnh
            <span>> 
                {{ $place->name_vi }}
            </span>
        </h1>
    </div>
</div>

<section id="widget-grid" class="">
    <div class="row">
        <div class="superbox col-md-9">
            @foreach ($place->media as $media)
                <div class="superbox-list">
                    <img 
                        src="{{ $media->link(160, 160, 'scale_to_fill') }}" 
                        data-img="{{ $media->link() }}" 
                        alt="My first photoshop layer mask on a high end PSD template theme" 
                        title="Miller Cine" class="superbox-img">
                    @if ($media->id == $place->image_id)
                    <a class="btn btn-success btn-block">Cover</a>
                    @else
                    <a class="btn btn-primary btn-block" href="/place/{{ $place->id }}/image/{{ $media->id }}/edit">Mark as Cover</a>
                    @endif
                </div>
            @endforeach
            <div class="superbox-float"></div>
        </div>
        <div class="superbox-show" style="height:300px; display: none"></div>
        {!! Form::open(["url" => "/place/$place->id/image", "method" => "POST", "files" => true]) !!}
        {!! Form::file("image") !!}
        {!! Form::lbSubmit() !!}
        {!! Form::close() !!}
    </div>
</section>

@endsection

@push('script')
<script src="{{ asset('/sa/js/plugin/superbox/superbox.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.superbox').SuperBox();
    })
</script>
@endpush