@extends('app')

@section('sidemenu_lbfbc')
active
@endsection

@section('sidemenu_lbfbc_conversation')
btn-primary
@endsection

@section('html_title')
Conversation
@endsection

@push('ribbon')

<ol class="breadcrumb">
    <li>Conversation</li>
</ol>

@endpush

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-edit fa-fw "></i> 
                {{ trans("bus.list.title") }} 
            <span>> 
                {{ trans("general.list") }} 
            </span>
        </h1>
    </div>
</div>

<section id="widget-grid" class="" ng-app="ChatBoxApp">
    <div class="row">
        <article class="col-md-3">
            @box_open(trans("bus.list.title"))
                <div class="panel panel-default" ng-controller="ConversationController" ng-cloak>
                    <div class="panel-body status">
                        <div class="who clearfix" ng-repeat="conversation in conversations" style="padding: 5px;">
                            <a href="/lbfbc/conversation/@{{ conversation.id }}">
                                <img src="@{{ user.avatar }}" alt="img" ng-repeat="user in conversation.user_bridges" ng-if="user.avatar" width="40px" height="40px">
                                <span class="name font-sm">
                                    <span ng-repeat="user in conversation.user_bridges">@{{ user.user_firstname }} </span>
                                    <br>
                                    @{{ conversation.created_at}}
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            @box_close
        </article>
        @if (isset($conversation))
        
        <article class="col-md-3">
            @box_open(trans("bus.list.title"))
                <div>
                    <div class="widget-body">
                        {!! Form::open(["url" => "/lbfbc/conversation/$conversation->id", "method" => "put"]) !!}
                        {!! Form::lbSelect("action_type", null, [
                            ["name" => "Send image", "value" => "0"],
                            ["name" => "Send login", "value" => "1"],
                        ], "Action") !!}
                        {!! Form::lbSelect("hotel_id", null, App\Models\Place::toOption("name_vi"), "Select hotel to send image") !!}
                        {!! Form::lbSubmit() !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            @box_close
            @box_open(trans("bus.list.title"))
                <div>
                    <div class="widget-body">
                        @foreach ($conversation->user_bridges as $user)
                            @if ($user->user)
                                {!! Form::open(["url" => "/order/create", "method" => "get"]) !!}
                                {!! Form::hidden("user_id", $user->user->id) !!}
                                <button class="btn btn-block btn-primary">Create order</button>
                                {!! Form::close() !!}
                            @endif
                        @endforeach
                    </div>
                </div>
            @box_close
        </article>
        @endif
    </div>
</section>

@endsection

@section("test")
<article class="col-md-6">
    @box_open(trans("bus.list.title"))
        <div ng-controller="ConversationItemController">
            <div class="widget-body widget-hide-overflow no-padding">
                <div id="chat-body" class="chat-body custom-scroll">
                    <ul>
                        <li class="message" ng-repeat="message in messages">
                            <img src="@{{ message.sender.avatar }}" width="50px" height="50px" alt="">
                            <div class="message-text">
                                <time>
                                    @{{ message.created_at }}
                                </time> <a href="javascript:void(0);" class="username">@{{ message.sender.user_firstname }} @{{ message.sender.user_lastname }}</a> 
                                @{{ message.message }}
                            </div>
                        </li>
                    </ul>

                </div>
                <form>
                {!! Form::lbText("test", "test", null, "Reply") !!}
                </form>
            </div>

        </div>

    @box_close
</article>
@endsection

@push('script')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.2/angular.min.js"></script>
<script type="text/javascript">
var app = angular.module('ChatBoxApp', []);

app.controller('ConversationController', function($scope, $http) {
    $http.get("/ajax/lbfbc/conversation").then(function (response) {
        $scope.conversations = response.data;
    });
    setInterval(function() {
        $http.get("/ajax/lbfbc/conversation").then(function (response) {
            $scope.conversations = response.data;
        });
    }, 3000);
});

@if (isset($conversation))
app.controller('ConversationItemController', function($scope, $http) {
    $http.get("/ajax/lbfbc/conversation/{{ $conversation->id }}").then(function (response) {
        $scope.messages = response.data;
    });
});
@endif

</script>
@endpush