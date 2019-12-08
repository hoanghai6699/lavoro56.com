@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Mã giảm giá</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li class="active">Mã giảm giá</li>
        </ol>
        @if(Session::has('success'))
            <div class="alert alert-{!! Session::get('level') !!}">
                {!! Session::get('success') !!}
            </div>
        @endif
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Mã code</th>
                                    <th style="text-align: center;">Hình thức</th>
                                    <th style="text-align: center;">Giá trị</th>
                                    <th style="text-align: center;">Số lượng</th>
                                    <th style="text-align: center;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($coupon as $item)
                                <tr>
                                    <td>{{$item->code}}</td>
                                    <td style="text-align: center;">
                                        @if($item->type == 'percent')
                                            Phần trăm
                                        @elseif($item->type == 'fixed')
                                            Giá trị
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if($item->type == 'percent')
                                            {{$item->percent_off}} %
                                        @elseif($item->type == 'fixed')
                                            {{number_format($item->value,0,',','.')}} đ
                                        @endif
                                    </td>
                                    <td style="text-align: center;">{{$item->qty}}</td>
                                    <td class="center" style="text-align: center;">
                                        <a class="fa fa-trash-o fa-fw" onclick="return confirm('Bạn có chắc không?')" href="{{route('admin.get.delete.coupon',$item->id)}}" data-toggle="tooltip" data-placement="top" title="Xóa"></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@stop