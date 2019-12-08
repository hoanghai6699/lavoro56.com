@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Quản lý sản phẩm khuyến mãi</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li class="active">Sản phẩm khuyến mãi</li>
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
                                    <th style="text-align: center;">STT</th>
                                    <th style="text-align: center;">Ảnh sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th style="text-align: center;">% Giảm giá</th>
                                    <th style="text-align: center;">Ngày bắt đầu</th>
                                    <th style="text-align: center;">Ngày kết thúc</th>
                                    <th style="text-align: center;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $stt=0 ?>
                                @foreach($sale as $item)
                                <?php $stt++ ?>
                                <tr>
                                    <td>{{$stt}}</td>
                                    <td style="text-align: center;">
                                        <?php $n = DB::table('products')->where('id',$item->product_id)->first();?>
                                        <img src="{{url('uploads')}}/{{$n->image}}" width="80px">
                                    </td>
                                    <td>
                                        <?php $n = DB::table('products')->where('id',$item->product_id)->first();
                                        echo "$n->name";
                                        ?>
                                    </td>
                                    <td style="text-align: center;">{{$item->sale}} %</td>
                                    <td style="text-align: center;">{{$item->start_date}}</td>
                                    <td style="text-align: center;">{{$item->end_date}}</td>
                                    <td class="center" style="text-align: center;">
                                        <a class="fa fa-pencil fa-fw" href="{{route('admin.get.edit.sale',$item->id)}}" data-toggle="tooltip" data-placement="top" title="Sửa"></a>
                                        /
                                        <a class="fa fa-trash-o fa-fw" onclick="return confirm('Bạn có chắc không?')" href="{{route('admin.get.delete.sale',$item->id)}}" data-toggle="tooltip" data-placement="top" title="Xóa"></a>
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