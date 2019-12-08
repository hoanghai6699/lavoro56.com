@extends('admin.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Quản lý đơn hàng chưa xử lý</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li><a href="{{route('admin.get.list.order')}}">Đơn hàng</a></li>
            <li class="active">Chưa xử lý</li>
        </ol>
        @if(Session::has('success'))
            <div class="alert alert-{!! Session::get('level') !!}">
                {!! Session::get('success') !!}
            </div>
        @endif
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Mã ĐH</th>
                                    <th style="text-align: center">Tên khách hàng</th>
                                    <th style="text-align: center">Tổng tiền</th>
                                    <th style="text-align: center">Mã giảm giá</th>
                                    <th style="text-align: center">Trạng thái</th>
                                    <th style="text-align: center">Phương thức</th>
                                    <th style="text-align: center">Thanh toán</th>
                                    <th style="text-align: center">Ngày tạo</th>
                                    <th style="text-align: center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pending as $item)
                                @if($item->status==0)
                                <tr>
                                    <td>#HD{{$item->id}}-{{$item->created_at->format('dmY')}}</td>
                                    <td style="text-align: center">
                                        <?php 
                                            $u = DB::table('users')->where('id',$item["user_id"])->first();
                                            echo "$u->name";
                                        ?>
                                    </td>
                                    <td style="text-align: center">{{number_format($item->total,0,',','.')}} đ</td>
                                    <td style="text-align: center">
                                        @if($item->coupon_id)
                                            {{$item->coupon->code}}
                                        @else
                                            Không nhập
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if($item->status==0)
                                            Chờ xử lý
                                        @elseif($item->status==1)
                                            Đang giao hàng
                                        @elseif($item->status==2)
                                           Đã nhận hàng
                                        @elseif($item->status==3)
                                            Đã hủy đơn
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if($item->payment_method=='cod')
                                            Ship COD
                                        @elseif($item->payment_method=='atm')
                                            ATM
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if($item->payment=='Chưa thanh toán')
                                            Chưa thanh toán
                                        @elseif($item->payment=='Đã thanh toán')
                                            Đã thanh toán
                                        @endif
                                    </td>
                                    <td style="text-align: center">{{$item->created_at->format('d-m-Y')}}</td>
                                    
                                    <td style="text-align: center">
                                        <a class="fa fa-eye fa-fw" data-id="{{$item->id}}" href="{{route('admin.get.view.order',$item->id)}}" data-toggle="tooltip" data-placement="top" title="Chi tiết"></a>
                                    </td>
                                </tr>
                                @endif
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