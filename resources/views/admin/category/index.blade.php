@extends('admin.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Quản lý danh mục </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li class="active">Danh mục</li>
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
                                    <th>STT</th>
                                    <th>Tên danh mục</th>
                                    <th>Danh mục cha</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $stt=0 ?>
                                @foreach($categories as $cate)
                                <?php $stt++ ?>
                                <tr>
                                    <td>{{$stt}}</td>
                                    <td>{{$cate->name}}</td>
                                    <td>
                                        @if($cate['parent_id']==0)
                                            {{"None"}}
                                        @else
                                            <?php 
                                                $parent = DB::table('categories')->where('id',$cate["parent_id"])->first();
                                                echo "$parent->name";
                                            ?>
                                        @endif
                                    </td>

                                    <td>
                                        @if($cate->active==1)
                                            <a href="{{route('admin.get.action.category',$cate->id)}}" data-toggle="tooltip" data-placement="top" title="Hiển thị"><img src="{{url('/admin/img/publish-check.png')}}"></a>
                                        @else
                                            <a href="{{route('admin.get.action.category',$cate->id)}}" data-toggle="tooltip" data-placement="top" title="Ẩn"><img src="{{url('/admin/img/publish-deny.png')}}"></a>
                                        @endif
                                    </td>
                                    <td class="center">
                                        <a class="fa fa-pencil fa-fw" href="{{route('admin.get.edit.category',$cate->id)}}" data-toggle="tooltip" data-placement="top" title="Sửa"></a>
                                        /
                                        <a class="fa fa-trash-o  fa-fw" onclick="return confirm('Bạn có chắc không?')" href="{{route('admin.get.delete.category',$cate->id)}}" data-toggle="tooltip" data-placement="top" title="Xóa"></a>
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