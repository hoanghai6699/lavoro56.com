@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Quản lý sản phẩm</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li class="active">Sản phẩm</li>
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
                                    <th style="text-align: center;">Loại sản phẩm</th>
                                    <th style="text-align: center;">Trạng thái</th>
                                    <th style="text-align: center;">Nổi bật</th>
                                    <th style="text-align: center;">Ngày tạo</th>
                                    <th style="text-align: center;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $stt=0 ?>
                                @foreach($products as $prod)
                                <?php $stt++ ?>
                                <tr>
                                    <td>{{$stt}}</td>
                                    <td><img src="{!!url('uploads')!!}/{!!$prod['image']!!}" width="80px"></td>
                                    <td style="padding-top: 26px;">{{$prod->name}}
                                        <ul style="padding-left: 20px;">
                                            <li>Giá: {{ number_format($prod->price,'0',',','.') }} (đ)</li>
                                        </ul>
                                    </td>
                                    <td style="text-align: center;padding-top: 26px;">
                                        <?php 
                                            $cate = DB::table('categories')->where('id',$prod["category_id"])->first();
                                            echo "$cate->name";
                                        ?>
                                    </td>
                                    <td style="text-align: center;padding-top: 26px;">
                                        @if($prod->active==1)
                                            <a href="{{route('admin.get.action.product',$prod->id)}}" data-toggle="tooltip" data-placement="top" title="Hiển thị"><img src="{{url('admin/img/publish-check.png')}}"></a>
                                        @else
                                            <a href="{{route('admin.get.action.product',$prod->id)}}" data-toggle="tooltip" data-placement="top" title="Ẩn"><img src="{{url('admin/img/publish-deny.png')}}"></a>
                                        @endif
                                    </td>
                                    <td style="text-align: center;padding-top: 26px;">
                                        @if($prod->hot==1)
                                            <a href="{{route('admin.get.action1.product',$prod->id)}}" data-toggle="tooltip" data-placement="top" title="Nổi bật"><i class="fa text-yellow fa-star"></i></a>
                                        @else
                                            <a href="{{route('admin.get.action1.product',$prod->id)}}" data-toggle="tooltip" data-placement="top" title="Không"><i class="fa text-yellow fa-star-o"></i></a>
                                        @endif
                                    </td>
                                    <td style="text-align: center;padding-top: 26px;">{{$prod->created_at}}</td>
                                    <td class="center" style="text-align: center;padding-top: 26px;">
                                        <a class="fa fa-cogs fa-fw" href="{{route('admin.get.option.product',$prod->id)}}" data-toggle="tooltip" data-placement="top" title="Thêm size"></a>
                                        /
                                        <a class="fa fa-pencil fa-fw" href="{{route('admin.get.edit.product',$prod->id)}}" data-toggle="tooltip" data-placement="top" title="Sửa"></a>
                                        /
                                        <a class="fa fa-trash-o fa-fw" onclick="return confirm('Bạn có chắc không?')" href="{{route('admin.get.delete.product',$prod->id)}}" data-toggle="tooltip" data-placement="top" title="Xóa"></a>
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