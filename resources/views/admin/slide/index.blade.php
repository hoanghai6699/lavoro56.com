@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Quản lý slide </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li class="active">Slide</li>
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
                                    <th style="text-align: center;width: 80%;">Slide</th>
                                    <th style="text-align: center;">Trạng thái</th>
                                    <th style="text-align: center;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($slide as $item)
                                <tr style="text-align: center;">
                                    <td>
                                        <img src="{{url('/frontend/img')}}/{{$item->image}}" style="width: 500px;height: 200px;">
                                    </td>
                                    <td style="padding-top: 93px;">

                                        
                                        @if($item->status==1)
                                            <a href="{{route('admin.get.action.slide',$item->id)}}" data-toggle="tooltip" data-placement="top" title="Hiển thị"><img src="{{url('/admin/img/publish-check.png')}}"></a>
                                        @else
                                            <a href="{{route('admin.get.action.slide',$item->id)}}" data-toggle="tooltip" data-placement="top" title="Ẩn"><img src="{{url('/admin/img/publish-deny.png')}}"></a>
                                        @endif

                                    </td>
                                    <td class="center" style="padding-top: 93px;">
                                        <a class="fa fa-pencil fa-fw" href="{{route('admin.get.edit.slide',[$item->id])}}" data-toggle="tooltip" data-placement="top" title="Sửa"></a>
                                        /
                                        <a class="fa fa-trash-o  fa-fw" onclick="return confirm('Bạn có chắc không?')" href="{{route('admin.get.delete.slide',[$item->id])}}" data-toggle="tooltip" data-placement="top" title="Xóa"></a>
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