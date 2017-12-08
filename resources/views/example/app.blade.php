@extends('layouts.app')

@push('sidebar')

@include("layouts.elements.sidebar_item_single", ["title" => "Products", "icon" => "fa fa-archive", "url" => "/post", "id" => "sidebar_post"])
@include("layouts.elements.sidebar_item_single", ["title" => "Categories", "icon" => "fa fa-shopping-bag", "url" => "/category", "id" => "sidebar_category"])
@include("layouts.elements.sidebar_item_single", ["title" => "Order", "icon" => "fa fa-shopping-bag", "url" => "/order", "id" => "sidebar_order"])
@include("layouts.elements.sidebar_item_single", ["title" => "User", "icon" => "fa fa-user ", "url" => "/user", "id" => "sidebar_user"])
@include("layouts.elements.sidebar_item_multi_open", ["title" => "User", "icon" => "fa fa-user ", "id" => "sidebar_user"])
@include("layouts.elements.sidebar_item_single", ["title" => "User", "icon" => "fa fa-user ", "url" => "/user", "id" => "sidebar_user"])
@include("layouts.elements.sidebar_item_multi_close")
@endpush