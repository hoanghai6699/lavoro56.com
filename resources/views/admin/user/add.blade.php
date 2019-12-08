@extends('admin.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Thêm mới thành viên</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li><a href="{{route('admin.get.list.user')}}">Thành viên</a></li>
            <li class="active">Thêm mới thành viên</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Họ tên</label>
                                <input type="text" class="form-control" name="name" placeholder="Họ tên" value="{{old('name')}}">
                                @if($errors->has('name'))
                                <div class="help-block" style="color: red;">
                                    {{$errors->first('name')}}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Email">
                                @if($errors->has('email'))
                                <div class="help-block" style="color: red;">
                                    {{$errors->first('email')}}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input type="password" class="form-control" name="password" placeholder="Mật khẩu">
                                @if($errors->has('password'))
                                <div class="help-block" style="color: red;">
                                    {{$errors->first('password')}}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" name="re_password" placeholder="Nhập lại mật khẩu">
                                @if($errors->has('re_password'))
                                <div class="help-block" style="color: red;">
                                    {{$errors->first('re_password')}}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{old('phone')}}">
                            </div>
                            <div class="form-group">
                                <label>Quyền </label>
                                <label class="radio-inline">
                                    <input name="rdoLevel" value="1" checked="" type="radio"> Admin
                                </label>
                                <label class="radio-inline">
                                    <input name="rdoLevel" value="0" type="radio"> Member
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@stop