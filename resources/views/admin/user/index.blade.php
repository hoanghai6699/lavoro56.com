@extends('admin.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Quản lý thành viên</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li class="active">Thành viên</li>
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
                                    <th style="text-align: center">Họ tên</th>
                                    <th style="text-align: center">Email</th>
                                    <th style="text-align: center">Phone</th>
                                    <th style="text-align: center">Quyền</th>
                                    <th style="text-align: center">Sửa/Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $stt=0 ?>
                                @foreach($user as $u)
                                <?php $stt++ ?>
                                <tr>
                                    <td>{{$stt}}</td>
                                    <td style="text-align: center">{{$u->name}}</td>
                                    <td style="text-align: center">{{$u->email}}</td>
                                    <td style="text-align: center">{{$u->phone}}</td>
                                    <td style="text-align: center">
                                        @if($u["id"] == 1)
                                            SupperAdmin
                                        @elseif($u["level"] == 1)
                                            Admin
                                        @else
                                            Member
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        <a class="fa fa-pencil fa-fw" href="{{route('admin.get.edit.user',$u->id)}}" data-toggle="tooltip" data-placement="top" title="Sửa"></a>
                                        /
                                        <a class="fa fa-trash-o  fa-fw" onclick="return confirm('Bạn có chắc không?')" href="{{route('admin.get.delete.user',$u->id)}}" data-toggle="tooltip" data-placement="top" title="Xóa"></a>
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