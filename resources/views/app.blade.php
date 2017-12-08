@extends('layouts.app')

@section("body_class")
menu-on-top
@endsection

@push('sidebar')

@include("libressltd.lbsidemenu.sidemenu")
@include("libressltd.deeppermission.sidebar")

@endpush