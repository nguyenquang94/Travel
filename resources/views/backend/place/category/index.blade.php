@extends('app')

@section('sidemenu_system_balance')
active
@endsection

@section('html_title')
Quản lý category địa điểm
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
                Quản lý category địa điểm
            <span>> 
                Danh sách category
            </span>
        </h1>
    </div>
</div>

<section id="widget-grid" class="">
    <div class="row">
        <article class="col-lg-12">
            @box_open("Danh sách category")
                <div>
                    <div class="widget-body no-padding">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tên tiếng anh</th>
                                    <th>Tên tiếng việt</th>
                                    <th>Thuộc nhóm</th>
                                    <th>Ảnh</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name_en }}</td>
                                    <td>{{ $category->name_vi}}</td>
                                    <td>{{ $category->parent ? $category->parent->name_vi : ""}}</td>
                                    <td>
                                        <img src="{{ $category->icon ? $category->icon->link() : "" }}" style="width: 44px; height: 44px" />
                                    </td>
                                    <td>
                                        <a href="/place/category/{{ $category->id }}/edit" class="btn btn-primary btn-xs">Chỉnh sửa</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="widget-footer">
                            <a class="btn btn-primary" href="/place/category/create">Create</a>
                        </div>
                    </div>
                </div>
            @box_close
        </article>
    </div>
</section>
@endsection
