@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm mã giảm giá</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li><a href="{{route('admin.get.list.coupon')}}">Danh sách mã giảm giá</a></li>
            <li class="active">Thêm mã giảm giá</li>
        </ol>
        @if(Session::has('success'))
            <div class="alert alert-{!! Session::get('level') !!}">
                {!! Session::get('success') !!}
            </div>
        @endif
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-body">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Số lượng</label>
                                    <input type="number" class="form-control" name="qty">
                                    @if($errors->has('qty'))
                                    <div class="help-block" style="color: red;">
                                        {{$errors->first('qty')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Kiểu giảm giá</label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="percent">--Phần trăm--</option>
                                        <option value="fixed">--Giá trị--</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Phần trăm / Giá trị</label>
                                    <input type="text" class="form-control" name="input">
                                    @if($errors->has('input'))
                                    <div class="help-block" style="color: red;">
                                        {{$errors->first('input')}}
                                    </div>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@stop