@extends('app')

@section('content')
<div ng-app="Calculate">
    <div class="row" ng-controller="CalculateController">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <form>
                        <div class="form-group">
                            <label class="control-label">Số xe</label>
                            <input class="form-control" type="text" ng-model="number_of_vihicle" ng-init="number_of_vihicle=10">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Giá nhập xe</label>
                            <input class="form-control" type="text" ng-model="init_price" ng-init="init_price=14000">
                        </div>
                        <div class="form-group">
                            <label class="control-label">% chạy</label>
                            <input class="form-control" type="text" ng-model="running_percentage" ng-init="running_percentage=40">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Công hàng tháng</label>
                            <input class="form-control" type="text" ng-model="monthly_maintain" ng-init="monthly_maintain=400">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Tiền đồ / 1000km</label>
                            <input class="form-control" type="text" ng-model="k_maintain" ng-init="k_maintain=300">
                        </div>
                        <div class="form-group">
                            <label class="control-label">km trung bình / ngày</label>
                            <input class="form-control" type="text" ng-model="k_per_day" ng-init="k_per_day=300">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Vòng đời (km)</label>
                            <input class="form-control" type="text" ng-model="circle" ng-init="circle=40000">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Giá thuê theo ngày</label>
                            <input class="form-control" type="text" ng-model="price" ng-init="price=180">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Giá bán cuối vòng đời</label>
                            <input class="form-control" type="text" ng-model="sell_price" ng-init="sell_price=6000">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default" ng-controller="CalculateController">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        Số xe
                    </div>
                    <div class="col-md-6">
                        @{{ number_of_vihicle }}
                    </div>

                    <div class="col-md-6">
                        Ngày chạy mỗi tháng
                    </div>
                    <div class="col-md-6">
                        @{{ running_day_in_month }}
                    </div>

                    <div class="col-md-6">
                        Doanh thu
                    </div>
                    <div class="col-md-6">
                        @{{ income }}
                    </div>

                    <div class="col-md-6">
                        Tổng số km chạy trong tháng
                    </div>
                    <div class="col-md-6">
                        @{{ total_km }}
                    </div>

                    <div class="col-md-6">
                        Bảo dưỡng / tháng
                    </div>
                    <div class="col-md-6">
                        @{{ total_maintain }}
                    </div>

                    <div class="col-md-6">
                        Khấu hao
                    </div>
                    <div class="col-md-6">
                        @{{ depreciation }}
                    </div>

                    <div class="col-md-6">
                        Lãi / xe
                    </div>
                    <div class="col-md-6">
                        @{{ profit }}
                    </div>

                    <div class="col-md-6">
                        Lãi
                    </div>
                    <div class="col-md-6">
                        @{{ profit * number_of_vihicle }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push("script")
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.2/angular.min.js"></script>
<script type="text/javascript">
    var bfapp = angular.module('Calculate', []);

    bfapp.controller('CalculateController', function($scope, $http) {
        $scope.$watch('running_percentage', function (value) {
            $scope.running_day_in_month = $scope.running_percentage * 30 / 100;
        });
        $scope.$watch('running_day_in_month * price', function (value) {
            $scope.income = value;
        });
        $scope.$watch('running_day_in_month * k_per_day', function (value) {
            $scope.total_km = value;
        });
        $scope.$watch('(total_km / 1000) * k_maintain + monthly_maintain * 1', function (value) {
            $scope.total_maintain = value;
        });
        $scope.$watch('total_km * (init_price - sell_price) / circle', function (value) {
            $scope.depreciation = value;
        });
        $scope.$watch('income - total_maintain - depreciation', function (value) {
            $scope.profit = value;
        });
    });
</script>


@endpush