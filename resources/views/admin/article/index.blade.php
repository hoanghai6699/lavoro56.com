@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Quản lý bài viết</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li class="active">Tin tức</li>
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
                                    <th style="text-align: center;">Ảnh</th>
                                    <th style="text-align: center;">Tên bài viết</th>
                                    <th style="text-align: center;">Trạng thái</th>
                                    <th style="text-align: center;">Ngày tạo</th>
                                    <th style="text-align: center;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $stt=0 ?>
                                @foreach($article as $articles)
                                <?php $stt++ ?>
                                <tr>
                                    <td>{{$stt}}</td>
                                    <td style="text-align: center;"><img src="{{url('uploads/article')}}/{{$articles['image']}}" width="80px"></td>
                                    <td style="text-align: center;padding-top: 33px;">{{$articles->name}}</td>
                                    <td style="text-align: center;padding-top: 33px;">
                                        @if($articles->active==1)
                                            <a href="{{route('admin.get.action.article',$articles->id)}}" data-toggle="tooltip" data-placement="top" title="Hiển thị"><img src="{{url('/admin/img/publish-check.png')}}"></a>
                                        @else
                                            <a href="{{route('admin.get.action.article',$articles->id)}}" data-toggle="tooltip" data-placement="top" title="Hiển thị"><img src="{{url('/admin/img/publish-deny.png')}}"></a>
                                        @endif
                                    </td>
                                    <td style="text-align: center;padding-top: 33px;">{{$articles->created_at}}</td>
                                    <td class="center" style="text-align: center;padding-top: 33px;">
                                        <a class="fa fa-pencil fa-fw" href="{{route('admin.get.edit.article',$articles->id)}}" data-toggle="tooltip" data-placement="top" title="Sửa"></a>
                                        /
                                        <a class="fa fa-trash-o  fa-fw" onclick="return confirm('Bạn có chắc không?')" href="{{route('admin.get.delete.article',$articles->id)}}" data-toggle="tooltip" data-placement="top" title="Xóa"></a>
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