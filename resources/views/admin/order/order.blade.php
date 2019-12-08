@extends('admin.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Chi tiết đơn hàng</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li><a href="{{route('admin.get.list.order')}}"> Đơn hàng</a></li>
            <li class="active">Chi tiết đơn hàng</li>
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
                    

                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-body">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <table class="table table-bordered table-responsive">
                                        <thead>
                                            <th class="form-group" style="width: 500px;">Thông tin khách hàng</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Mã hóa đơn</td>
                                                <td>#HD{{$order->id}}-{{$order->created_at->format('dmY')}}</td>
                                            </tr>
                                            <tr>
                                                <td>Tên khách hàng</td>
                                                <td>
                                                    <?php $u = DB::table('users')->where('id',$order["user_id"])->first();
                                                        echo "$u->name"; 
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ngày đặt hàng</td>
                                                <td>{{$order->created_at}}</td>
                                            </tr>
                                            <tr>
                                                <td>Địa chỉ</td>
                                                <td>
                                                    {{$order->address}}
                                                    -
                                                    <?php $district = DB::table('districts')->where('id',$order["district_id"])->first();
                                                        echo "$district->district"; 
                                                    ?>
                                                    -
                                                    <?php $city = DB::table('cities')->where('id',$order["city_id"])->first();
                                                        echo "$city->city"; 
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Số điện thoại</td>
                                                <td>{{$order->phone}}</td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>{{$order->email}}</td>
                                            </tr>
                                            <tr>
                                                <td>Ghi chú</td>
                                                <td>{{$order->note}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @if(empty($order->status == 2 || $order->status == 3))
                                        <label>Trạng thái</label>
                                        <select class="form-control" name="status">
                                            <option value="0" @if($order->status==0) selected="selected" @endif>Chờ xử lý</option>
                                            <option value="1" @if($order->status==1) selected="selected" @endif>Đang giao hàng</option>
                                            <option value="2">Đã nhận hàng</option>
                                            <option value="3">Đã hủy đơn</option>
                                        </select>
                                    @endif
                                            
                                </div>
                                @if(empty($order->status == 2 || $order->status == 3))
                                <input type="submit" value="Xử lý" class="btn btn-primary">
                                @endif
                            </div>
                        </div>
                    </form>

                    
                </div>
            </div>
            
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $stt=0 ?>
                                @foreach($order_detail as $item)
                                <?php $t = DB::table('orders')->where('id',$item->order_id)->select('total','coupon_id')->first();?>
                                <?php $stt++ ?>
                                <tr>
                                    <td>#{{$stt}}</td>
                                    <td>
                                        <img src="{{url('uploads')}}/{{$item->product->image}}" class="img-responsive" alt="" width="80px" />
                                    </td>
                                    <td>
                                        <h6>
                                            <a href="{{route('frontend.get.chitietsanpham',[$item->product->id,$item->product->slug])}}" target="_blank">{{$item->product->name}}</a>
                                            <ul style="padding-left: 20px;">
                                                @if($item->price_sale>0)
                                                <li>Sale: {{$item->price_sale}} (%)</li>
                                                @endif
                                                <li>Size: 
                                                    <?php $p = DB::table('sizes')->where('id',$item->size_id)->first();
                                                        echo "$p->size";
                                                    ?>   
                                                </li>
                                            </ul>
                                        </h6>
                                    </td>
                                    <td><div>{{number_format($item->price,0,',','.')}} đ</div></td>
                                    <td><div>{{$item->qty}}</div></td>
                                    <td><div class="cart-subtotal">
                                    @if(isset($item->price_sale))
                                        {{number_format(($item->price*(100-$item->price_sale)/100)*$item->qty,0,',','.')}} đ
                                    @endif
                                        
                                        </div>
                                    </td>
                                    <td class="center">
                                        <a class="fa fa-trash-o  fa-fw" onclick="return confirm('Bạn có chắc không?')" href="{{route('admin.get.delete.order',$item->id)}}" data-toggle="tooltip" data-placement="top" title="Xóa"></a>
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