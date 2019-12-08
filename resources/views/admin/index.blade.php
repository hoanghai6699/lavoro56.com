@extends('admin.master')
@section('content')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tổng quan
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Tổng quan</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$product = DB::table('products')->count()}}</h3>
                        <p>Sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{$user = DB::table('users')->count()}}</h3>
                        <p>Thành viên</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{$order = DB::table('orders')->count()}}</h3>
                        <p>Đơn hàng</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-briefcase"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{$article = DB::table('articles')->count()}}</h3>
                        <p>Bài viết</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-paper"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            @if(Auth()->user()->id=='1')
            <div class="col-md-12 col-lg-12 col-xs-12">
                <div class="box">
                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
            @endif
        </div>
    </section>
    <!-- /.content -->
</div>

@stop

@section('script')
<script>
    // Create the chart
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Biểu đồ doanh thu'
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Mức doanh thu'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.0f} VNĐ'
            }
        }
    },

    tooltip: {
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f} VNĐ</b><br/>'
    },

    series: [
        {
            colorByPoint: true,
            data: [
                {
                    name: "Doanh thu ngày",
                    y: {{$moneyDay}},
                    
                },
                {
                    name: "Doanh thu tháng",
                    y: {{$moneyMonth}},
                    
                },
                {
                    name: "Doanh thu năm",
                    y: {{$moneyYear}},
                    
                } 
            ]
        }
    ],
});
</script>
@stop
